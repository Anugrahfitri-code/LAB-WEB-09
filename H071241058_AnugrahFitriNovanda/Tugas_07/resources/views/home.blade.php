{{-- 1. Mewarisi layout utama --}}
@extends('layouts.main')

{{-- 2. Mengatur Judul Halaman --}}
@section('title', 'Selamat Datang di Malang - Eksplor Pariwisata')

{{-- 3. Mengisi Konten Halaman --}}
@section('content')

    <section class="hero-section" style="background-image: url('{{ asset('images/hero-bg.jpg') }}');">
        <div class="hero-overlay"></div> <div class="hero-content">
            <h1 class="hero-title">
                <span class="letter-wrapper"><span class="letter">M</span></span>
                <span class="letter-wrapper"><span class="letter">A</span></span>
                <span class="letter-wrapper"><span class="letter">L</span></span>
                <span class="letter-wrapper"><span class="letter">A</span></span>
                <span class="letter-wrapper"><span class="letter">N</span></span>
                <span class="letter-wrapper"><span class="letter">G</span></span>
            </h1>
            <p class="hero-subtitle anim-fade-up">Kota Sejuta Pesona dan Kenangan.</p>
            <a href="{{ route('destinasi') }}" class="hero-cta anim-fade-up">Mulai Eksplorasi</a>
        </div>
    </section>

    <section class="container intro-section">
        <div class="intro-content anim-scroll-fade">
            <h2 class="intro-title">Tentang Kota Malang</h2>
            <p>
                Selamat datang di Malang, sebuah kota di Jawa Timur yang menawarkan perpaduan sempurna antara
                pesona sejarah, keindahan alam, dan denyut kehidupan kota yang modern. Dikenal dengan
                julukan "Kota Apel" dan "Kota Bunga", Malang dikelilingi oleh pegunungan yang
                menjadikan udaranya sejuk dan pemandangannya menakjubkan.
            </p>
            <p>
                Dari jalanan bersejarah di Kajoetangan hingga keriuhan Alun-Alun Tugu,
                setiap sudut kota ini menceritakan kisahnya sendiri. Website ini adalah panduan Anda
                untuk menjelajahi destinasi wisata terbaik, mencicipi kuliner legendaris, dan
                menemukan keajaiban tersembunyi di Kota Malang.
            </p>
        </div>
        <div class="intro-image anim-scroll-fade">
            <img src="{{ asset('images/destinasi-aluntugu.jpg') }}" alt="Alun-Alun Tugu Malang">
        </div>
    </section>

@endsection