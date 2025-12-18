<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MealLink - Marketplace Katering Online Terbaik">
    <title>@yield('title', 'MealLink - Marketplace Katering')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container navbar-content">
            <a href="/" class="logo">
                <span class="logo-icon">🍽️</span>
                <span class="logo-text">Meal<span class="logo-highlight">Link</span></span>
            </a>
            <div class="nav-links">
                <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Beranda</a>
                <a href="/menus" class="nav-link {{ request()->is('menus*') ? 'active' : '' }}">Menu</a>
                <a href="/orders" class="nav-link {{ request()->is('orders*') ? 'active' : '' }}">Pesanan</a>
            </div>
            <div class="nav-actions">
                <button class="btn btn-outline">Masuk</button>
                <button class="btn btn-primary">Daftar</button>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="/" class="logo">
                        <span class="logo-icon">🍽️</span>
                        <span class="logo-text">Meal<span class="logo-highlight">Link</span></span>
                    </a>
                    <p class="footer-desc">Platform marketplace katering online terbaik untuk menghubungkan penyedia katering dengan pelanggan.</p>
                </div>
                <div class="footer-links">
                    <h4>Navigasi</h4>
                    <ul>
                        <li><a href="/">Beranda</a></li>
                        <li><a href="/menus">Menu</a></li>
                        <li><a href="/orders">Pesanan</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Bantuan</h4>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Hubungi Kami</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Ikuti Kami</h4>
                    <div class="social-links">
                        <a href="#" class="social-link">📘</a>
                        <a href="#" class="social-link">📸</a>
                        <a href="#" class="social-link">🐦</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 MealLink. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
