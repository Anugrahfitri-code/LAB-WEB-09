@extends('layouts.main')

@section('title', 'Destinasi Wisata Malang')

@section('content')

    <div class="container page-container">
        <h1 class="section-title anim-judul">Destinasi Populer</h1>

        <div class="wisata-grid">
            

            <x-card-wisata 
                :gambarUrl="asset('images/destinasi-kampungwarnawarni.jpg')"
                judul="Kampung Warna-Warni"
                deskripsi="Perkampungan unik di bantaran sungai yang diubah menjadi spot foto penuh warna yang instagramable." 
            />

            <x-card-wisata 
                :gambarUrl="asset('images/destinasi-aluntugu.jpg')"
                judul="Alun-Alun Tugu"
                deskripsi="Ikon bersejarah Kota Malang dengan tugu kemerdekaan yang dikelilingi taman bunga dan kolam teratai." 
            />

            <x-card-wisata 
                :gambarUrl="asset('images/destinasi-kajoetangan.jpg')"
                judul="Kajoetangan Heritage"
                deskripsi="Menyusuri lorong waktu di kampung lawas dengan arsitektur bangunan kolonial yang masih asli dan terawat." 
            />

            <a href="{{ route('kuliner') }}" class="next-page-link" title="Lanjut ke Kuliner">
                Lihat Kuliner Khas &rarr;
            </a>
            
            </div>
    </div>

@endsection