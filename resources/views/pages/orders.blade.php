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
                            <h4>Pesanan #{{ $order->id }}</h4>
                            <p>Qty: {{ $order->quantity }} porsi • {{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <span class="order-status {{ $order->status }}">
                            @switch($order->status)
                                @case('pending')
                                    Menunggu
                                    @break
                                @case('processing')
                                    Diproses
                                    @break
                                @case('completed')
                                    Selesai
                                    @break
                                @case('cancelled')
                                    Dibatalkan
                                    @break
                                @default
                                    {{ ucfirst($order->status) }}
                            @endswitch
                        </span>
                        <div class="order-price">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
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
