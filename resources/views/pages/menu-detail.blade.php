@extends('layouts.app')

@section('title', $menu->name . ' - MealLink')

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span class="separator">›</span>
                <a href="{{ route('menus.index') }}">Menu</a>
                <span class="separator">›</span>
                <span class="current">{{ $menu->name }}</span>
            </nav>
            <h1>Detail Menu</h1>
        </div>
    </section>

    <!-- Menu Detail Section -->
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

            <div class="menu-detail">
                <div class="menu-detail-image">
                    @php
                        $icons = ['🍛', '🍲', '🥗', '🍖', '🍜', '🍱', '🍽️'];
                        $icon = $icons[$menu->id % count($icons)];
                    @endphp
                    {{ $icon }}
                </div>
                
                <div class="menu-detail-content">
                    <div class="menu-detail-header">
                        <span class="menu-category">{{ $menu->katering?->name ?? 'Katering' }}</span>
                        <h2>{{ $menu->name }}</h2>
                    </div>
                    
                    <p class="menu-description">
                        {{ $menu->description ?? 'Menu lezat dari katering terpercaya. Dibuat dengan bahan-bahan berkualitas dan resep terbaik.' }}
                    </p>
                    
                    <div class="menu-detail-price">
                        <span class="price-label">Harga per porsi</span>
                        <span class="price-value">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                    </div>
                    
                    @auth
                        <form action="{{ route('orders.store') }}" method="POST" class="order-detail-form">
                            @csrf
                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                            
                            <div class="form-group">
                                <label class="form-label">Jumlah Porsi</label>
                                <div class="quantity-selector">
                                    <button type="button" class="qty-btn minus" onclick="decrementQty()">−</button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="100" class="qty-input">
                                    <button type="button" class="qty-btn plus" onclick="incrementQty()">+</button>
                                </div>
                            </div>
                            
                            <div class="order-summary">
                                <div class="summary-row">
                                    <span>Subtotal</span>
                                    <span id="subtotal">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-lg btn-full">
                                <span>🛒</span> Pesan Sekarang
                            </button>
                        </form>
                    @else
                        <div class="login-prompt">
                            <p>Silakan login untuk memesan menu ini</p>
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login untuk Pesan</a>
                        </div>
                    @endauth
                </div>
            </div>
            
            <div class="back-link">
                <a href="{{ route('menus.index') }}" class="btn btn-outline">
                    ← Kembali ke Daftar Menu
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
    
    .menu-detail {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 40px;
        box-shadow: var(--shadow-lg);
        margin-bottom: 40px;
    }
    
    .menu-detail-image {
        background: var(--gradient-primary);
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10rem;
        min-height: 400px;
    }
    
    .menu-detail-content {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }
    
    .menu-detail-header h2 {
        font-size: 2rem;
        margin-top: 8px;
    }
    
    .menu-description {
        color: var(--gray-600);
        font-size: 1.1rem;
        line-height: 1.7;
    }
    
    .menu-detail-price {
        background: var(--gray-50);
        padding: 20px;
        border-radius: var(--radius);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .price-label {
        color: var(--gray-500);
        font-size: 0.9rem;
    }
    
    .price-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary);
    }
    
    .quantity-selector {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .qty-btn {
        width: 44px;
        height: 44px;
        border: 2px solid var(--gray-200);
        background: var(--white);
        border-radius: var(--radius);
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--gray-600);
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .qty-btn:hover {
        border-color: var(--primary);
        color: var(--primary);
    }
    
    .qty-input {
        width: 80px;
        height: 44px;
        border: 2px solid var(--gray-200);
        border-radius: var(--radius);
        text-align: center;
        font-size: 1.1rem;
        font-weight: 600;
    }
    
    .qty-input:focus {
        outline: none;
        border-color: var(--primary);
    }
    
    .order-summary {
        background: var(--gray-50);
        padding: 20px;
        border-radius: var(--radius);
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 1.1rem;
    }
    
    .summary-row span:last-child {
        font-weight: 700;
        color: var(--gray-900);
    }
    
    .btn-full {
        width: 100%;
    }
    
    .login-prompt {
        background: var(--gray-50);
        padding: 32px;
        border-radius: var(--radius);
        text-align: center;
    }
    
    .login-prompt p {
        color: var(--gray-500);
        margin-bottom: 16px;
    }
    
    .back-link {
        text-align: center;
    }
    
    @media (max-width: 768px) {
        .menu-detail {
            grid-template-columns: 1fr;
            gap: 32px;
            padding: 24px;
        }
        
        .menu-detail-image {
            min-height: 250px;
            font-size: 6rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    const pricePerUnit = {{ $menu->price }};
    
    function updateSubtotal() {
        const qty = document.getElementById('quantity').value;
        const subtotal = pricePerUnit * qty;
        document.getElementById('subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    }
    
    function incrementQty() {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) < 100) {
            input.value = parseInt(input.value) + 1;
            updateSubtotal();
        }
    }
    
    function decrementQty() {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
            updateSubtotal();
        }
    }
    
    document.getElementById('quantity').addEventListener('change', updateSubtotal);
</script>
@endpush
