<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Manajemen')</title> 
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex min-h-screen">

        <aside class="w-64 bg-gradient-to-br from-purple-700 to-indigo-800 text-white shadow-xl flex flex-col">
            
            <div class="p-6 text-center border-b border-purple-800">
                <h2 class="text-2xl font-bold">Manajemen</h2>
                @auth
                    <span class="text-sm text-indigo-200 block mt-1">
                        Halo, {{ Auth::user()->name }}
                    </span>
                    <span class="text-xs text-indigo-300 font-medium">
                        ({{ Auth::user()->role->name }})
                    </span>
                @endauth
            </div>

            <nav class="flex-1 py-4 space-y-2">
                
                <a href="{{ route('dashboard') }}" class="block px-6 py-2.5 text-indigo-100 hover:bg-purple-600">
                    Dashboard
                </a>

                @if(Auth::user()->role->name == 'Admin')
                    <a href="{{ route('categories.index') }}" class="block px-6 py-2.5 text-indigo-100 hover:bg-purple-600">
                        Manajemen Kategori
                    </a>
                    <a href="{{ route('warehouses.index') }}" class="block px-6 py-2.5 text-indigo-100 hover:bg-purple-600">
                        Manajemen Gudang
                    </a>
                    <a href="{{ route('products.index') }}" class="block px-6 py-2.5 text-indigo-100 hover:bg-purple-600">
                        Manajemen Produk
                    </a>
                    <a href="{{ route('stocks.index') }}" class="block px-6 py-2.5 text-indigo-100 hover:bg-purple-600">
                        Manajemen Stok
                    </a>

                @elseif(Auth::user()->role->name == 'Staf Produk')
                    <a href="{{ route('products.index') }}" class="block px-6 py-2.5 text-indigo-100 hover:bg-purple-600">
                        Manajemen Produk
                    </a>
                    <a href="{{ route('warehouses.index') }}" class="block px-6 py-2.5 text-indigo-100 hover:bg-purple-600">
                        Lihat Gudang
                    </a>

                @elseif(Auth::user()->role->name == 'Staf Gudang')
                    <a href="{{ route('stocks.index') }}" class="block px-6 py-2.5 text-indigo-100 hover:bg-purple-600">
                        Manajemen Stok
                    </a>
                    <a href="{{ route('products.index') }}" class="block px-6 py-2.5 text-indigo-100 hover:bg-purple-600">
                        Lihat Produk
                    </a>
                @endif
                
            </nav>

            <div class="p-4 border-t border-purple-800">
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1">
            <div class="w-full min-h-full bg-gradient-to-br from-indigo-100 via-purple-100 to-pink-100 p-4 sm:p-6 lg:p-8">
                
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-5 shadow" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-5 shadow" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6 shadow" role="alert">
                        <strong class="font-bold">Oops! Ada kesalahan.</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')

            </div>
        </main>
    </div>

</body>
</html>