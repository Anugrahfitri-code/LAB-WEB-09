{{-- 
    Ini komponen card. dipanggil dengan:
    <x-card-wisata 
        :gambar_url="$url" 
        :judul="$judul" 
        :deskripsi="$deskripsi" 
    />
--}}

@props(['gambarUrl', 'judul', 'deskripsi'])

<div class="wisata-card anim-card">
    <div class="card-image-container">
        <img src="{{ $gambarUrl }}" alt="{{ $judul }}" class="card-image">
    </div>
    <div class="card-content">
        <h3 class="card-title">{{ $judul }}</h3>
        <p class="card-description">{{ $deskripsi }}</p>
    </div>
</div>