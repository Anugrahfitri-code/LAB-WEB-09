<!DOCTYPE html>
    <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>@yield('title', 'Eksplor Pariwisata Nusantara')</title>
            
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
            
            <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
            
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        </head>
        <body class="body-loading">
            @include('partials.header')
            <div id="preloader">
                <div class="preloader-content">
                    <img src="{{ asset('images/logo-malang.png') }}" alt="Logo Malang" class="preloader-logo">
                    <p class="preloader-text">Memuat Pesona Malang...</p>
                </div>
            </div>

            <main>
                @yield('content')
            </main>

            @include('partials.footer')
            <a id="scrollTopBtn" class="scroll-top-btn">
                &#8593;
            </a>

        </body>
    </html>