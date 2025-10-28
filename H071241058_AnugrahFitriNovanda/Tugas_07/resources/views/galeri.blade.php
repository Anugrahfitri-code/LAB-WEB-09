@extends('layouts.main')

@section('title', 'Galeri Foto Malang')

@section('content')

    <div class="container page-container">
        <h1 class="section-title anim-judul">Galeri Foto Malang</h1>
        
        <p class="gallery-intro anim-fade-up">
            Menikmati sudut-sudut kota Malang yang ikonik dan penuh cerita, 
            dari arsitektur bersejarah hingga denyut kehidupan kota.
        </p>

        <div class="masonry-grid anim-grid-container">

            <div class="masonry-item">
                <img src="{{ asset('images/galeri-stasiun.jpg') }}" alt="Stasiun Malang Kotabaru">
                <div class="item-overlay"><span>Stasiun Kotabaru</span></div>
            </div>

            <div class="masonry-item">
                <img src="{{ asset('images/galeri-ijen.jpg') }}" alt="Ijen Boulevard Malang">
                <div class="item-overlay"><span>Ijen Boulevard</span></div>
            </div>

            <div class="masonry-item">
                <img src="{{ asset('images/galeri-malam.jpeg') }}" alt="Malang Night Paradise">
                <div class="item-overlay"><span>Malang Night Paradise</span></div>
            </div>

            <div class="masonry-item">
                <img src="{{ asset('images/galeri-museum-brawijaya.jpg') }}" alt="Museum Brawijaya">
                <div class="item-overlay"><span>Museum Brawijaya</span></div>
            </div>

            <div class="masonry-item">
                <img src="{{ asset('images/destinasi-kajoetangan.jpg') }}" alt="Kajoetangan Heritage">
                <div class="item-overlay"><span>Kajoetangan Heritage</span></div>
            </div>

            <div class="masonry-item">
                <img src="{{ asset('images/destinasi-kampungwarnawarni.jpg') }}" alt="Kampung Warna Warni">
                <div class="item-overlay"><span>Kampung Warna Warni</span></div>
            </div>

             <a href="{{ route('agenda') }}" class="next-page-link" title="Lanjut ke Agenda">
                Lihat Agenda Festival &rarr;
            </a>

        </div> </div> @endsection