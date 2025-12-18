@extends('layouts.app')

@section('title', 'Menu - MealLink')

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Daftar Menu</h1>
            <p>Temukan berbagai pilihan menu katering lezat untuk kebutuhan Anda</p>
        </div>
    </section>

    <!-- Menu Section -->
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

            @if($menus->count() > 0)
                <div class="menu-grid">
                    @foreach($menus as $menu)
                        <div class="menu-card">
                            <div class="menu-image">
                                @php
                                    $icons = ['🍛', '🍲', '🥗', '🍖', '🍜', '🍱', '🍽️'];
                                    $icon = $icons[$menu->id % count($icons)];
                                @endphp
                                {{ $icon }}
                            </div>
                            <div class="menu-content">
                                <span class="menu-category">Katering</span>
                                <h3>{{ $menu->name }}</h3>
                                <p>{{ $menu->description ?? 'Menu lezat dari katering terpercaya.' }}</p>
                                <div class="menu-footer">
                                    <div class="menu-price">Rp {{ number_format($menu->price, 0, ',', '.') }} <span>/porsi</span></div>
                                    
                                    @auth
                                        <form action="{{ route('orders.store') }}" method="POST" class="order-form">
                                            @csrf
                                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                            <div class="quantity-input">
                                                <input type="number" name="quantity" value="1" min="1" max="100" class="qty-field">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Pesan</button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-primary">Login untuk Pesan</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">🍽️</div>
                    <h3>Belum Ada Menu</h3>
                    <p>Silakan jalankan seeder untuk menambahkan data demo.</p>
                    <code>php artisan db:seed</code>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('styles')
<style>
    .order-form {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .quantity-input {
        display: flex;
        align-items: center;
    }
    .qty-field {
        width: 60px;
        padding: 8px;
        border: 2px solid var(--gray-200);
        border-radius: var(--radius);
        text-align: center;
        font-size: 0.9rem;
    }
    .qty-field:focus {
        outline: none;
        border-color: var(--primary);
    }
</style>
@endpush
