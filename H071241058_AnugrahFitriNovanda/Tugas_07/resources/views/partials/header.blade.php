<header class="main-header">
    <nav class="navbar">
        <div class="navbar-brand">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo-malang.png') }}" alt="Logo Malang" class="navbar-logo">
            </a>
            <a href="{{ route('home') }}" class="brand-name">Eksplor Malang</a>
        </div>

        <div class="navbar-menu desktop-menu">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('destinasi') }}" class="nav-link {{ request()->routeIs('destinasi') ? 'active' : '' }}">Destinasi</a>
            <a href="{{ route('kuliner') }}" class="nav-link {{ request()->routeIs('kuliner') ? 'active' : '' }}">Kuliner</a>
            <a href="{{ route('galeri') }}" class="nav-link {{ request()->routeIs('galeri') ? 'active' : '' }}">Galeri</a>
            <a href="{{ route('agenda') }}" class="nav-link {{ request()->routeIs('agenda') ? 'active' : '' }}">Agenda</a>
            <a href="{{ route('kontak') }}" class="nav-link {{ request()->routeIs('kontak') ? 'active' : '' }}">Kontak</a>
        </div>

        <button id="hamburger-btn" class="hamburger-btn">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
        </button>
    </nav>
</header>

<div id="mobile-menu" class="mobile-menu">
    <a href="{{ route('home') }}" class="mobile-nav-link">Home</a>
    <a href="{{ route('destinasi') }}" class="mobile-nav-link">Destinasi</a>
    <a href="{{ route('kuliner') }}" class="mobile-nav-link">Kuliner</a>
    <a href="{{ route('galeri') }}" class="mobile-nav-link">Galeri</a>
    <a href="{{ route('agenda') }}" class="mobile-nav-link">Agenda</a>
    <a href="{{ route('kontak') }}" class="mobile-nav-link">Kontak</a>
</div>