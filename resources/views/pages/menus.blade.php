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

            <!-- Action Bar -->
            <div class="action-bar">
                <div class="menu-count">
                    <span>{{ $menus->count() }} Menu Tersedia</span>
                </div>
                @auth
                    <a href="{{ route('menus.create') }}" class="btn btn-primary">
                        <span>+</span> Tambah Menu
                    </a>
                @endauth
            </div>

            @if($menus->count() > 0)
                <div class="menu-grid">
                    @foreach($menus as $menu)
                        <div class="menu-card">
                            <a href="{{ route('menus.show', $menu->id) }}" class="menu-link">
                                <div class="menu-image">
                                    @php
                                        $icons = ['🍛', '🍲', '🥗', '🍖', '🍜', '🍱', '🍽️'];
                                        $icon = $icons[$menu->id % count($icons)];
                                    @endphp
                                    {{ $icon }}
                                </div>
                            </a>
                            <div class="menu-content">
                                <span class="menu-category">{{ $menu->katering?->name ?? 'Katering' }}</span>
                                <h3><a href="{{ route('menus.show', $menu->id) }}">{{ $menu->name }}</a></h3>
                                <p>{{ Str::limit($menu->description ?? 'Menu lezat dari katering terpercaya.', 80) }}</p>
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
                                @auth
                                    <div class="menu-actions">
                                        <a href="{{ route('menus.edit', $menu->id) }}" class="btn-edit">✏️ Edit</a>
                                    </div>
                                @endauth
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
    .action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        padding: 16px 24px;
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
    }
    .menu-count {
        color: var(--gray-600);
        font-weight: 500;
    }
    .menu-link {
        display: block;
        text-decoration: none;
    }
    .menu-content h3 a {
        color: var(--gray-900);
        text-decoration: none;
        transition: var(--transition);
    }
    .menu-content h3 a:hover {
        color: var(--primary);
    }
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
    .menu-actions {
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid var(--gray-100);
    }
    .btn-edit {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 6px 12px;
        background: var(--gray-100);
        color: var(--gray-600);
        font-size: 0.8rem;
        font-weight: 500;
        border-radius: var(--radius-sm);
        transition: var(--transition);
        text-decoration: none;
    }
    .btn-edit:hover {
        background: var(--gray-200);
        color: var(--gray-800);
    }
    @media (max-width: 768px) {
        .action-bar {
            flex-direction: column;
            gap: 16px;
        }
    }
</style>
@endpush

