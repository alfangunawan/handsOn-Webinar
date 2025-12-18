@extends('layouts.app')

@section('title', 'Pesanan Saya - MealLink')

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Pesanan Saya</h1>
            <p>Lacak dan kelola semua pesanan katering Anda</p>
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

            @if(isset($orders) && count($orders) > 0)
                @foreach($orders as $order)
                    <div class="order-card">
                        <div class="order-icon">🍽️</div>
                        <div class="order-info">
                            <h4>Pesanan #{{ $order['id'] ?? 'N/A' }}</h4>
                            <p>Qty: {{ $order['quantity'] ?? 1 }} porsi • {{ $order['created_at'] ?? 'Baru saja' }}</p>
                        </div>
                        <span class="order-status {{ $order['status'] ?? 'pending' }}">
                            {{ ucfirst($order['status'] ?? 'pending') }}
                        </span>
                        <div class="order-price">Rp {{ number_format($order['total_price'] ?? 0, 0, ',', '.') }}</div>
                    </div>
                @endforeach
            @else
                <!-- Sample Orders for Demo -->
                <div class="order-card">
                    <div class="order-icon">🍛</div>
                    <div class="order-info">
                        <h4>Pesanan #001 - Nasi Ayam Geprek</h4>
                        <p>Qty: 5 porsi • 18 Desember 2024</p>
                    </div>
                    <span class="order-status completed">Completed</span>
                    <div class="order-price">Rp 125.000</div>
                </div>
                <div class="order-card">
                    <div class="order-icon">🍲</div>
                    <div class="order-info">
                        <h4>Pesanan #002 - Rendang Padang</h4>
                        <p>Qty: 10 porsi • 18 Desember 2024</p>
                    </div>
                    <span class="order-status pending">Pending</span>
                    <div class="order-price">Rp 350.000</div>
                </div>
                <div class="order-card">
                    <div class="order-icon">🍱</div>
                    <div class="order-info">
                        <h4>Pesanan #003 - Bento Salmon Teriyaki</h4>
                        <p>Qty: 3 porsi • 17 Desember 2024</p>
                    </div>
                    <span class="order-status completed">Completed</span>
                    <div class="order-price">Rp 165.000</div>
                </div>
            @endif

            @if(!isset($orders) || count($orders) == 0)
                <div style="margin-top: 40px;">
                    <div class="empty-state">
                        <div class="empty-state-icon">📦</div>
                        <h3>Belum Ada Pesanan</h3>
                        <p>Anda belum memiliki pesanan. Mulai pesan menu favorit Anda sekarang!</p>
                        <a href="/menus" class="btn btn-primary btn-lg">Lihat Menu</a>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
