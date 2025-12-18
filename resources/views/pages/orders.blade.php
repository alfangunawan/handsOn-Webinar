@extends('layouts.app')

@section('title', 'Pesanan Saya - MealLink')

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Pesanan Saya</h1>
            <p>Selamat datang, {{ Auth::user()->name }}! Lacak dan kelola semua pesanan katering Anda</p>
        </div>
    </section>

    <!-- Orders Section -->
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

            @if($orders->count() > 0)
                <div class="orders-header">
                    <h3>Total {{ $orders->count() }} Pesanan</h3>
                </div>
                
                @foreach($orders as $order)
                    <div class="order-card">
                        <div class="order-icon">
                            @php
                                $icons = ['🍛', '🍲', '🥗', '🍖', '🍜', '🍱'];
                                $icon = $icons[$order->menu_id % count($icons)];
                            @endphp
                            {{ $icon }}
                        </div>
                        <div class="order-info">
                            <h4>{{ $order->menu?->name ?? 'Pesanan #' . $order->id }}</h4>
                            <p>Qty: {{ $order->quantity }} porsi • {{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <span class="order-status {{ $order->status }}">
                            @switch($order->status)
                                @case('pending')
                                    🕐 Menunggu
                                    @break
                                @case('processing')
                                    🍳 Diproses
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
                        <div class="order-price">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                        <div class="order-actions">
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline btn-sm">Detail</a>
                            @if($order->status === 'pending')
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger-outline btn-sm">Batalkan</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📦</div>
                    <h3>Belum Ada Pesanan</h3>
                    <p>Anda belum memiliki pesanan. Mulai pesan menu favorit Anda sekarang!</p>
                    <a href="{{ route('menus.index') }}" class="btn btn-primary btn-lg">Lihat Menu</a>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('styles')
<style>
    .orders-header {
        margin-bottom: 24px;
    }
    .orders-header h3 {
        color: var(--gray-600);
        font-size: 1rem;
        font-weight: 500;
    }
    .order-actions {
        display: flex;
        gap: 8px;
    }
    .btn-sm {
        padding: 8px 16px;
        font-size: 0.8rem;
    }
    .btn-danger-outline {
        background: transparent;
        color: #dc2626;
        border: 2px solid #fecaca;
        padding: 8px 16px;
        font-size: 0.8rem;
        font-weight: 600;
        border-radius: var(--radius);
        transition: var(--transition);
    }
    .btn-danger-outline:hover {
        background: #fee2e2;
        border-color: #dc2626;
    }
    .order-status.processing {
        background: #dbeafe;
        color: #2563eb;
    }
    .order-status.cancelled {
        background: #fee2e2;
        color: #dc2626;
    }
</style>
@endpush

