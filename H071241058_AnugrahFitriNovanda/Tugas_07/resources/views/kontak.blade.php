@extends('layouts.main')

@section('title', 'Kontak Kami')

@section('content')

    <div class="container page-container">
        <h1 class="section-title anim-judul">Kontak & Informasi</h1>

        <p class="gallery-intro anim-fade-up">
            Punya pertanyaan atau masukan? Silakan hubungi kami melalui form di bawah ini.
        </p>

        <div class="contact-form-container anim-scroll-fade">
            <form action="#" method="POST">
                <div class="form-group">
                    <label for="nama">Nama Anda</label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap Anda" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Anda</label>
                    <input type="email" id="email" name="email" placeholder="contoh@email.com" required>
                </div>

                <div class="form-group">
                    <label for="pesan">Pesan Anda</label>
                    <textarea id="pesan" name="pesan" rows="6" placeholder="Tuliskan pesan atau pertanyaan Anda di sini..."></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="contact-submit-btn">Kirim Pesan</button>
                </div>
            </form>
        </div>
    </div>

@endsection