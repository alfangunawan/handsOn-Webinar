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
            @if($menus->count() > 0)
                <div class="menu-grid">
                    @foreach($menus as $menu)
                        <div class="menu-card">
                            <div class="menu-image">🍽️</div>
                            <div class="menu-content">
                                <span class="menu-category">Katering</span>
                                <h3>{{ $menu->name }}</h3>
                                <p>{{ $menu->description ?? 'Menu lezat dari katering terpercaya.' }}</p>
                                <div class="menu-footer">
                                    <div class="menu-price">Rp {{ number_format($menu->price, 0, ',', '.') }} <span>/porsi</span></div>
                                    <form action="{{ route('orders.store') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary">Pesan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State / Demo Data -->
                <div class="menu-grid">
                    <div class="menu-card">
                        <div class="menu-image">🍛</div>
                        <div class="menu-content">
                            <span class="menu-category">Nasi Box</span>
                            <h3>Nasi Ayam Geprek</h3>
                            <p>Nasi putih dengan ayam geprek sambal pedas, lalapan segar, dan kerupuk renyah.</p>
                            <div class="menu-footer">
                                <div class="menu-price">Rp 25.000 <span>/porsi</span></div>
                                <button class="btn btn-primary" disabled>Pesan</button>
                            </div>
                        </div>
                    </div>
                    <div class="menu-card">
                        <div class="menu-image">🍲</div>
                        <div class="menu-content">
                            <span class="menu-category">Prasmanan</span>
                            <h3>Rendang Padang</h3>
                            <p>Rendang daging sapi empuk dengan bumbu rempah khas Padang yang nikmat.</p>
                            <div class="menu-footer">
                                <div class="menu-price">Rp 35.000 <span>/porsi</span></div>
                                <button class="btn btn-primary" disabled>Pesan</button>
                            </div>
                        </div>
                    </div>
                    <div class="menu-card">
                        <div class="menu-image">🥗</div>
                        <div class="menu-content">
                            <span class="menu-category">Sehat</span>
                            <h3>Salad Bowl Premium</h3>
                            <p>Sayuran segar dengan protein pilihan dan dressing homemade yang lezat.</p>
                            <div class="menu-footer">
                                <div class="menu-price">Rp 30.000 <span>/porsi</span></div>
                                <button class="btn btn-primary" disabled>Pesan</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="empty-state" style="margin-top: 40px;">
                    <p style="color: var(--gray-500);">Belum ada menu di database. Jalankan seeder untuk menambahkan data demo.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
