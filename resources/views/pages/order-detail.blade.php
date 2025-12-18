@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->id . ' - MealLink')

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span class="separator">›</span>
                <a href="{{ route('orders.index') }}">Pesanan Saya</a>
                <span class="separator">›</span>
                <span class="current">Pesanan #{{ $order->id }}</span>
            </nav>
            <h1>Detail Pesanan</h1>
        </div>
    </section>

    <!-- Order Detail Section -->
    <section class="section">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <div class="order-detail-card">
                <!-- Order Header -->
                <div class="order-detail-header">
                    <div class="order-id">
                        <span class="label">Nomor Pesanan</span>
                        <span class="value">#{{ $order->id }}</span>
                    </div>
                    <span class="order-status {{ $order->status }}">
                        @switch($order->status)
                            @case('pending')
                                🕐 Menunggu Konfirmasi
                                @break
                            @case('processing')
                                🍳 Sedang Diproses
                                @break
                            @case('completed')
                                ✅ Selesai
                                @break
                            @case('cancelled')
                                ❌ Dibatalkan
                                @break
                            @default
                                {{ ucfirst($order->status) }}
                        @endswitch
                    </span>
                </div>

                <!-- Order Timeline -->
                <div class="order-timeline">
                    <div class="timeline-item {{ in_array($order->status, ['pending', 'processing', 'completed']) ? 'active' : '' }}">
                        <div class="timeline-icon">📝</div>
                        <div class="timeline-content">
                            <span class="timeline-title">Pesanan Dibuat</span>
                            <span class="timeline-time">{{ $order->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                    <div class="timeline-item {{ in_array($order->status, ['processing', 'completed']) ? 'active' : '' }}">
                        <div class="timeline-icon">🍳</div>
                        <div class="timeline-content">
                            <span class="timeline-title">Sedang Diproses</span>
                            <span class="timeline-time">{{ $order->status == 'processing' || $order->status == 'completed' ? 'Dikonfirmasi' : 'Menunggu' }}</span>
                        </div>
                    </div>
                    <div class="timeline-item {{ $order->status == 'completed' ? 'active' : '' }}">
                        <div class="timeline-icon">✅</div>
                        <div class="timeline-content">
                            <span class="timeline-title">Selesai</span>
                            <span class="timeline-time">{{ $order->status == 'completed' ? $order->updated_at->format('d M Y, H:i') : '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="order-items">
                    <h3>Pesanan</h3>
                    <div class="order-item">
                        <div class="item-image">
                            @php
                                $icons = ['🍛', '🍲', '🥗', '🍖', '🍜', '🍱'];
                                $icon = $icons[$order->menu_id % count($icons)];
                            @endphp
                            {{ $icon }}
                        </div>
                        <div class="item-info">
                            <h4>{{ $order->menu?->name ?? 'Menu #' . $order->menu_id }}</h4>
                            <p>{{ $order->menu?->description ?? 'Menu dari katering terpercaya' }}</p>
                        </div>
                        <div class="item-quantity">
                            {{ $order->quantity }} porsi
                        </div>
                        <div class="item-price">
                            Rp {{ number_format($order->menu?->price ?? 0, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="order-summary-detail">
                    <div class="summary-row">
                        <span>Subtotal ({{ $order->quantity }} porsi)</span>
                        <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Actions -->
                @if($order->status === 'pending')
                    <div class="order-actions">
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                ❌ Batalkan Pesanan
                            </button>
                        </form>
                    </div>
                @endif
            </div>
            
            <div class="back-link">
                <a href="{{ route('orders.index') }}" class="btn btn-outline">
                    ← Kembali ke Daftar Pesanan
                </a>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
        font-size: 0.9rem;
    }
    .breadcrumb a {
        color: var(--gray-400);
        transition: var(--transition);
    }
    .breadcrumb a:hover {
        color: var(--primary);
    }
    .breadcrumb .separator {
        color: var(--gray-500);
    }
    .breadcrumb .current {
        color: var(--white);
    }
    
    .order-detail-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 40px;
        box-shadow: var(--shadow-lg);
        margin-bottom: 40px;
    }
    
    .order-detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 24px;
        border-bottom: 1px solid var(--gray-200);
        margin-bottom: 32px;
    }
    
    .order-id .label {
        display: block;
        font-size: 0.875rem;
        color: var(--gray-500);
        margin-bottom: 4px;
    }
    
    .order-id .value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gray-900);
    }
    
    .order-status {
        padding: 10px 20px;
        border-radius: var(--radius-full);
        font-size: 0.9rem;
        font-weight: 600;
    }
    
    .order-status.pending {
        background: #fef3c7;
        color: #d97706;
    }
    
    .order-status.processing {
        background: #dbeafe;
        color: #2563eb;
    }
    
    .order-status.completed {
        background: #dcfce7;
        color: #16a34a;
    }
    
    .order-status.cancelled {
        background: #fee2e2;
        color: #dc2626;
    }
    
    /* Timeline */
    .order-timeline {
        display: flex;
        justify-content: space-between;
        margin-bottom: 40px;
        position: relative;
    }
    
    .order-timeline::before {
        content: '';
        position: absolute;
        top: 24px;
        left: 60px;
        right: 60px;
        height: 2px;
        background: var(--gray-200);
    }
    
    .timeline-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        position: relative;
        z-index: 1;
    }
    
    .timeline-icon {
        width: 48px;
        height: 48px;
        background: var(--gray-100);
        border-radius: var(--radius-full);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin-bottom: 12px;
        border: 3px solid var(--white);
    }
    
    .timeline-item.active .timeline-icon {
        background: var(--gradient-primary);
    }
    
    .timeline-title {
        display: block;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 4px;
    }
    
    .timeline-time {
        font-size: 0.8rem;
        color: var(--gray-400);
    }
    
    /* Order Items */
    .order-items {
        margin-bottom: 32px;
    }
    
    .order-items h3 {
        font-size: 1.125rem;
        margin-bottom: 16px;
    }
    
    .order-item {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 20px;
        background: var(--gray-50);
        border-radius: var(--radius);
    }
    
    .item-image {
        width: 80px;
        height: 80px;
        background: var(--gradient-primary);
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
    }
    
    .item-info {
        flex: 1;
    }
    
    .item-info h4 {
        font-size: 1.1rem;
        margin-bottom: 4px;
    }
    
    .item-info p {
        color: var(--gray-500);
        font-size: 0.875rem;
    }
    
    .item-quantity {
        color: var(--gray-600);
        font-weight: 500;
    }
    
    .item-price {
        font-weight: 700;
        color: var(--gray-900);
        font-size: 1.1rem;
    }
    
    /* Order Summary */
    .order-summary-detail {
        background: var(--gray-50);
        padding: 24px;
        border-radius: var(--radius);
        margin-bottom: 32px;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        color: var(--gray-600);
    }
    
    .summary-row.total {
        margin-bottom: 0;
        padding-top: 12px;
        border-top: 1px solid var(--gray-200);
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--gray-900);
    }
    
    /* Actions */
    .order-actions {
        text-align: center;
        padding-top: 24px;
        border-top: 1px solid var(--gray-200);
    }
    
    .btn-danger {
        background: #dc2626;
        color: var(--white);
        padding: 12px 24px;
        font-size: 0.9rem;
        font-weight: 600;
        border-radius: var(--radius);
        transition: var(--transition);
    }
    
    .btn-danger:hover {
        background: #b91c1c;
    }
    
    .back-link {
        text-align: center;
    }
    
    @media (max-width: 768px) {
        .order-detail-card {
            padding: 24px;
        }
        
        .order-detail-header {
            flex-direction: column;
            gap: 16px;
            text-align: center;
        }
        
        .order-timeline {
            flex-direction: column;
            gap: 16px;
        }
        
        .order-timeline::before {
            display: none;
        }
        
        .timeline-item {
            flex-direction: row;
            text-align: left;
            gap: 16px;
        }
        
        .order-item {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
@endpush
