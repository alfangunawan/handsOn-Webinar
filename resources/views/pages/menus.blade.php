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
            @if(isset($menus) && count($menus) > 0)
                <div class="menu-grid">
                    @foreach($menus as $menu)
                        <div class="menu-card">
                            <div class="menu-image">🍽️</div>
                            <div class="menu-content">
                                <span class="menu-category">Katering</span>
                                <h3>{{ $menu['name'] ?? 'Menu Item' }}</h3>
                                <p>{{ $menu['description'] ?? 'Deskripsi menu yang lezat dan nikmat.' }}</p>
                                <div class="menu-footer">
                                    <div class="menu-price">Rp {{ number_format($menu['price'] ?? 0, 0, ',', '.') }} <span>/porsi</span></div>
                                    <form action="/orders" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="menu_id" value="{{ $menu['id'] ?? 1 }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary">Pesan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Sample Menu Cards for Demo -->
                <div class="menu-grid">
                    <div class="menu-card">
                        <div class="menu-image">🍛</div>
                        <div class="menu-content">
                            <span class="menu-category">Nasi Box</span>
                            <h3>Nasi Ayam Geprek</h3>
                            <p>Nasi putih dengan ayam geprek sambal pedas, lalapan segar, dan kerupuk renyah.</p>
                            <div class="menu-footer">
                                <div class="menu-price">Rp 25.000 <span>/porsi</span></div>
                                <a href="#" class="btn btn-primary">Pesan</a>
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
                                <a href="#" class="btn btn-primary">Pesan</a>
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
                                <a href="#" class="btn btn-primary">Pesan</a>
                            </div>
                        </div>
                    </div>
                    <div class="menu-card">
                        <div class="menu-image">🍖</div>
                        <div class="menu-content">
                            <span class="menu-category">BBQ</span>
                            <h3>Grilled Chicken Set</h3>
                            <p>Ayam panggang dengan bumbu BBQ special, nasi butter, dan sayuran grill.</p>
                            <div class="menu-footer">
                                <div class="menu-price">Rp 40.000 <span>/porsi</span></div>
                                <a href="#" class="btn btn-primary">Pesan</a>
                            </div>
                        </div>
                    </div>
                    <div class="menu-card">
                        <div class="menu-image">🍜</div>
                        <div class="menu-content">
                            <span class="menu-category">Mie</span>
                            <h3>Mie Goreng Special</h3>
                            <p>Mie goreng dengan topping telur, bakso, dan sayuran pilihan.</p>
                            <div class="menu-footer">
                                <div class="menu-price">Rp 22.000 <span>/porsi</span></div>
                                <a href="#" class="btn btn-primary">Pesan</a>
                            </div>
                        </div>
                    </div>
                    <div class="menu-card">
                        <div class="menu-image">🍱</div>
                        <div class="menu-content">
                            <span class="menu-category">Bento</span>
                            <h3>Bento Salmon Teriyaki</h3>
                            <p>Set bento dengan salmon teriyaki, nasi jepang, dan side dish lengkap.</p>
                            <div class="menu-footer">
                                <div class="menu-price">Rp 55.000 <span>/porsi</span></div>
                                <a href="#" class="btn btn-primary">Pesan</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
