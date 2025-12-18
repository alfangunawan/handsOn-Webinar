@extends('layouts.app')

@section('title', 'MealLink - Marketplace Katering Online')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Temukan <span>Katering Terbaik</span> untuk Setiap Momen</h1>
                    <p>MealLink menghubungkan Anda dengan penyedia katering berkualitas. Pesan makanan lezat untuk acara apapun dengan mudah dan cepat.</p>
                    <div class="hero-buttons">
                        <a href="/menus" class="btn btn-primary btn-lg">Lihat Menu</a>
                        <a href="#features" class="btn btn-outline btn-lg">Pelajari Lebih</a>
                    </div>
                    <div class="hero-stats">
                        <div class="stat-item">
                            <div class="stat-number">500+</div>
                            <div class="stat-label">Katering Terdaftar</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">10K+</div>
                            <div class="stat-label">Pesanan Sukses</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">4.9</div>
                            <div class="stat-label">Rating Pengguna</div>
                        </div>
                    </div>
                </div>
                <div class="hero-image">
                    <div class="hero-image-placeholder">🍱</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section" id="features">
        <div class="container">
            <div class="section-header">
                <h2>Kenapa Pilih MealLink?</h2>
                <p>Platform katering online yang memudahkan Anda menemukan dan memesan makanan berkualitas</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🔍</div>
                    <h3>Mudah Dicari</h3>
                    <p>Temukan berbagai pilihan katering dengan menu yang beragam sesuai selera dan kebutuhan Anda.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3>Pemesanan Cepat</h3>
                    <p>Proses pemesanan yang simple dan cepat. Pilih menu, tentukan jumlah, dan pesan dalam hitungan detik.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">✅</div>
                    <h3>Kualitas Terjamin</h3>
                    <p>Semua katering telah melalui proses verifikasi untuk memastikan kualitas dan kebersihan makanan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Menu Section -->
    <section class="section" style="background: var(--gray-100);">
        <div class="container">
            <div class="section-header">
                <h2>Menu Populer</h2>
                <p>Menu favorit yang paling banyak dipesan oleh pelanggan kami</p>
            </div>
            <div class="menu-grid">
                <div class="menu-card">
                    <div class="menu-image">🍛</div>
                    <div class="menu-content">
                        <span class="menu-category">Nasi Box</span>
                        <h3>Nasi Ayam Geprek</h3>
                        <p>Nasi putih dengan ayam geprek sambal pedas, lalapan segar, dan kerupuk.</p>
                        <div class="menu-footer">
                            <div class="menu-price">Rp 25.000 <span>/porsi</span></div>
                            <a href="/menus" class="btn btn-primary">Pesan</a>
                        </div>
                    </div>
                </div>
                <div class="menu-card">
                    <div class="menu-image">🍲</div>
                    <div class="menu-content">
                        <span class="menu-category">Prasmanan</span>
                        <h3>Paket Rendang Padang</h3>
                        <p>Rendang daging sapi empuk dengan bumbu rempah khas Padang yang nikmat.</p>
                        <div class="menu-footer">
                            <div class="menu-price">Rp 35.000 <span>/porsi</span></div>
                            <a href="/menus" class="btn btn-primary">Pesan</a>
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
                            <a href="/menus" class="btn btn-primary">Pesan</a>
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
                            <a href="/menus" class="btn btn-primary">Pesan</a>
                        </div>
                    </div>
                </div>
            </div>
            <div style="text-align: center; margin-top: 40px;">
                <a href="/menus" class="btn btn-outline btn-lg">Lihat Semua Menu</a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Siap Memesan Katering?</h2>
            <p>Bergabung dengan ribuan pelanggan yang telah mempercayakan kebutuhan katering mereka kepada MealLink.</p>
            <a href="/menus" class="btn btn-white btn-lg">Mulai Sekarang</a>
        </div>
    </section>
@endsection
