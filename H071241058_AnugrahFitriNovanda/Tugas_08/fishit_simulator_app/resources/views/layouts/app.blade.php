<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fish It! - Database Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;900&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Nunito', 'ui-sans-serif', 'system-ui'],
                    },
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="bg-blue-100 text-gray-900 antialiased">

    <nav class="bg-blue-600 shadow-lg">
        <div class="container mx-auto px-6 py-4">
            <a href="{{ route('fishes.index') }}" class="text-3xl font-extrabold text-white hover:text-yellow-300 transition-colors">
                <span class="text-yellow-300">Fish It!</span> Database
            </a>
        </div>
    </nav>

    <main class="container mx-auto px-6 py-12">
        @yield('content') 
    </main>

    <footer class="text-center text-blue-800 py-6 mt-8">
        <p>&copy; {{ date('Y') }} Fish It Simulator (Roblox). All rights reserved.</p>
    </footer>

</body>
</html>

