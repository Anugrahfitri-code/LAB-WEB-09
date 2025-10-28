@extends('layouts.main')

@section('title', 'Kuliner Khas Malang')

@section('content')

    <div class="container page-container">
        <h1 class="section-title anim-judul">Kuliner Khas Malang</h1>

        <div class="wisata-grid">

            <x-card-wisata 
                :gambarUrl="asset('images/kuliner-bakso.jpg')"
                judul="Bakso Malang"
                deskripsi="Cita rasa bakso legendaris dengan kuah kaldu gurih dan aneka pelengkap seperti siomay, tahu, dan pangsit goreng." 
            />

            <x-card-wisata 
                :gambarUrl="asset('images/kuliner-cwie-mie.jpg')"
                judul="Cwie Mie Malang"
                deskripsi="Mi tipis dengan taburan ayam cincang halus (mirip abon) dan pangsit renyah. Berbeda dari mi ayam biasa." 
            />

            <x-card-wisata 
                :gambarUrl="asset('images/kuliner-toko-oen.jpg')"
                judul="Es Krim Toko Oen"
                deskripsi="Menikmati es krim 'homemade' dengan resep klasik di toko legendaris yang bernuansa kolonial otentik." 
            />

             <a href="{{ route('galeri') }}" class="next-page-link" title="Lanjut ke Galeri">
                Lihat Galeri Foto &rarr;
            </a>
            
            </div>
    </div>

@endsection