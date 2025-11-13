@extends('layouts.app')

@section('title', 'Detail Kategori: ' . $category->name)

@section('content')

    <!-- Header Halaman -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Detail Kategori
        </h1>
        <a href="{{ route('categories.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold transition duration-300">
            &larr; Kembali ke Daftar Kategori
        </a>
    </div>

    <!-- Kartu Detail Kategori -->
    <div class="bg-white rounded-xl shadow-2xl p-6 sm:p-8 mb-6 max-w-3xl mx-auto">
        
        <!-- Grid untuk tampilan detail yang rapi -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-sm font-medium text-gray-500 mb-1">Nama Kategori</h2>
                <p class="text-2xl font-semibold text-gray-900">{{ $category->name }}</p>
            </div>
            <div>
                <h2 class="text-sm font-medium text-gray-500 mb-1">Induk Kategori</h2>
                <p class="text-2xl font-semibold text-gray-900">{{ $category->parent->name ?? '-' }}</p>
            </div>
            <div class="md:col-span-2">
                <h2 class="text-sm font-medium text-gray-500 mb-1">Deskripsi</h2>
                <p class="text-gray-700">{{ $category->description ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Kartu Daftar Produk dalam Kategori Ini -->
    <div class="bg-white rounded-xl shadow-2xl p-6 sm:p-8 max-w-3xl mx-auto mt-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">
            Produk dalam Kategori Ini ({{ $category->products->count() }})
        </h2>
        
        <ul class="divide-y divide-gray-200">
            @forelse($category->products as $product)
                <li class="py-3 flex justify-between items-center">
                    <div>
                        <span class="text-lg font-medium text-gray-900">{{ $product->name }}</span>
                        <span class="block text-sm text-gray-500">SKU: {{ $product->sku }}</span>
                    </div>
                    <span class="text-lg font-semibold text-gray-800">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                </li>
            @empty
                <li class="py-3 text-center text-gray-500">
                    Belum ada produk di dalam kategori ini.
                </li>
            @endforelse
        </ul>
    </div>

@endsection