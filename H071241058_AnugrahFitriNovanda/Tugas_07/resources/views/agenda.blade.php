@extends('layouts.main')

@section('title', 'Agenda Festival di Malang')

@section('content')

    <div class="container page-container">
        <h1 class="section-title anim-judul">Agenda & Festival</h1>
        
        <p class="gallery-intro anim-fade-up">
            Malang tidak hanya soal wisata, tapi juga rumah bagi berbagai
            festival kreatif dan budaya yang meriah sepanjang tahun.
        </p>

        <div class="timeline-container">
            
            <div class="timeline-item anim-timeline-item">
                <div class="timeline-image">
                    <img src="{{ asset('images/agenda-mfc.jpg') }}" alt="Malang Flower Carnival">
                </div>
                <div class="timeline-content">
                    <span class="timeline-date">Agustus</span>
                    <h3 class="timeline-title">Malang Flower Carnival</h3>
                    <p>
                        Saksikan parade kostum megah dan kreatif bertema flora dan fauna
                        yang menghiasi jalanan utama Kota Malang. Salah satu karnaval terbaik di Indonesia.
                    </p>
                </div>
            </div>

            <div class="timeline-item anim-timeline-item">
                <div class="timeline-image">
                    <img src="{{ asset('images/agenda-malangtempoedoeloe.jpg') }}" alt="Festival Malang Tempoe Doeloe">
                </div>
                <div class="timeline-content">
                    <span class="timeline-date">Mei</span>
                    <h3 class="timeline-title">Festival Malang Kembali</h3>
                    <p>
                        Lebih dikenal sebagai 'Malang Tempoe Doeloe', festival ini membawa Anda
                        kembali ke masa lalu dengan dekorasi, kuliner, dan pertunjukan jadul.
                    </p>
                </div>
            </div>

            <div class="timeline-item anim-timeline-item">
                <div class="timeline-image">
                    <img src="{{ asset('images/galeri-ijen.jpg') }}" alt="Car Free Day Ijen">
                </div>
                <div class="timeline-content">
                    <span class="timeline-date">Setiap Minggu Pagi</span>
                    <h3 class="timeline-title">Car Free Day Ijen</h3>
                    <p>
                        Bukan festival, tapi agenda rutin yang wajib dikunjungi.
                        Jalan Ijen yang bersejarah berubah menjadi pusat olahraga, kuliner, dan komunitas.
                    </p>
                </div>
            </div>

            <a href="{{ route('kontak') }}" class="next-page-link" title="Lanjut ke Kontak">
                Hubungi Kami &rarr;
            </a>

        </div> </div> @endsection