@extends('layouts.app')

@section('title', $katering->name . ' - MealLink')

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span class="separator">›</span>
                <a href="{{ route('katerings.index') }}">Katering</a>
                <span class="separator">›</span>
                <span class="current">{{ $katering->name }}</span>
            </nav>
            <h1>{{ $katering->name }}</h1>
        </div>
    </section>

    <!-- Katering Detail Section -->
    <section class="section">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="katering-detail">
                <div class="katering-header">
                    <div class="katering-icon-large">🏪</div>
                    <div class="katering-info">
                        <h2>{{ $katering->name }}</h2>
                        <p class="katering-desc">{{ $katering->description ?? 'Katering berkualitas dengan berbagai pilihan menu lezat untuk berbagai acara.' }}</p>
                        <div class="katering-meta">
                            <span class="meta-item">
                                <span>🍽️</span> {{ $katering->menus->count() }} Menu
                            </span>
                            <span class="meta-item">
                                <span>📅</span> Bergabung {{ $katering->created_at->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                    @auth
                        <div class="katering-actions">
                            <a href="{{ route('katerings.edit', $katering->id) }}" class="btn btn-outline">✏️ Edit</a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Menu dari Katering ini -->
            <div class="katering-menus">
                <div class="section-header-local">
                    <h3>Menu dari {{ $katering->name }}</h3>
                    @auth
                        <a href="{{ route('menus.create') }}" class="btn btn-primary btn-sm">+ Tambah Menu</a>
                    @endauth
                </div>

                @if($katering->menus->count() > 0)
                    <div class="menu-grid">
                        @foreach($katering->menus as $menu)
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
                                    <h4><a href="{{ route('menus.show', $menu->id) }}">{{ $menu->name }}</a></h4>
                                    <p>{{ Str::limit($menu->description ?? 'Menu lezat dari katering terpercaya.', 60) }}</p>
                                    <div class="menu-footer">
                                        <div class="menu-price">Rp {{ number_format($menu->price, 0, ',', '.') }} <span>/porsi</span></div>
                                        @auth
                                            <form action="{{ route('orders.store') }}" method="POST" class="order-form-inline">
                                                @csrf
                                                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-primary btn-sm">Pesan</button>
                                            </form>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-menus">
                        <p>Katering ini belum memiliki menu.</p>
                    </div>
                @endif
            </div>
            
            <div class="back-link">
                <a href="{{ route('katerings.index') }}" class="btn btn-outline">
                    ← Kembali ke Daftar Katering
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
    
    .katering-detail {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 32px;
        box-shadow: var(--shadow-lg);
        margin-bottom: 40px;
    }
    .katering-header {
        display: flex;
        gap: 24px;
        align-items: flex-start;
    }
    .katering-icon-large {
        width: 120px;
        height: 120px;
        background: var(--gradient-primary);
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        flex-shrink: 0;
    }
    .katering-info {
        flex: 1;
    }
    .katering-info h2 {
        font-size: 2rem;
        margin-bottom: 12px;
    }
    .katering-desc {
        color: var(--gray-600);
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 16px;
    }
    .katering-meta {
        display: flex;
        gap: 24px;
    }
    .meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        color: var(--gray-500);
        font-size: 0.9rem;
    }
    .katering-actions {
        flex-shrink: 0;
    }
    
    .katering-menus {
        margin-bottom: 40px;
    }
    .section-header-local {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .section-header-local h3 {
        font-size: 1.5rem;
    }
    
    .menu-content h4 {
        font-size: 1rem;
        margin-bottom: 8px;
    }
    .menu-content h4 a {
        color: var(--gray-900);
        text-decoration: none;
        transition: var(--transition);
    }
    .menu-content h4 a:hover {
        color: var(--primary);
    }
    
    .order-form-inline {
        display: inline;
    }
    
    .empty-menus {
        text-align: center;
        padding: 40px;
        background: var(--gray-50);
        border-radius: var(--radius);
    }
    .empty-menus p {
        color: var(--gray-500);
    }
    
    .back-link {
        text-align: center;
    }
    
    @media (max-width: 768px) {
        .katering-header {
            flex-direction: column;
            text-align: center;
        }
        .katering-icon-large {
            margin: 0 auto;
        }
        .katering-meta {
            justify-content: center;
            flex-wrap: wrap;
        }
        .section-header-local {
            flex-direction: column;
            gap: 16px;
        }
    }
</style>
@endpush
