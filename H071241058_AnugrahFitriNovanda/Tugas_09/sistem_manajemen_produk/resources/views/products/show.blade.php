@extends('layouts.app')

@section('title', 'Detail Produk: ' . $product->name)

@section('content')

    <!-- Header Halaman -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Detail Produk
        </h1>
        <a href="{{ route('products.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold transition duration-300">
            &larr; Kembali ke Daftar Produk
        </a>
    </div>

    <!-- Layout Grid Utama -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri: Info Utama & Detail -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Kartu Informasi Utama -->
            <div class="bg-white rounded-xl shadow-2xl p-6 sm:p-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Informasi Utama</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Nama Produk</h3>
                        <p class="text-lg font-semibold text-gray-900">{{ $product->name }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">SKU</h3>
                        <p class="text-lg font-semibold text-gray-900">{{ $product->sku }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Harga</h3>
                        <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Status</h3>
                        @if($product->status == 'active')
                            <span class="text-sm font-medium px-3 py-1 bg-green-100 text-green-800 rounded-full">Aktif</span>
                        @else
                            <span class="text-sm font-medium px-3 py-1 bg-red-100 text-red-800 rounded-full">Nonaktif</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Kartu Detail Produk -->
            <div class="bg-white rounded-xl shadow-2xl p-6 sm:p-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Detail Produk</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Berat</h3>
                        <p class="text-lg font-semibold text-gray-900">{{ $product->productDetail->weight ?? '-' }} kg</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Ukuran</h3>
                        <p class="text-lg font-semibold text-gray-900">{{ $product->productDetail->size ?? '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <h3 class="text-sm font-medium text-gray-500">Deskripsi</h3>
                        <p class="text-gray-700 mt-1 prose">
                            {!! nl2br(e($product->productDetail->description ?? '-')) !!}
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Kolom Kanan: Info Tambahan (Kategori & Supplier) -->
        <div class="lg:col-span-1 space-y-6">
            
            <!-- Kartu Kategori -->
            <div class="bg-white rounded-xl shadow-2xl p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Kategori</h2>
                <div class="flex items-center">
                    <span class="bg-pink-100 rounded-full p-2">
                        <svg class="h-6 w-6 text-pink-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" /></svg>
                    </span>
                    <span class="ml-4 text-lg font-medium text-gray-700">{{ $product->category->name ?? 'Tanpa Kategori' }}</span>
                </div>
            </div>

            <!-- Kartu Supplier -->
            <div class="bg-white rounded-xl shadow-2xl p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Supplier</h2>
                <ul class="space-y-2">
                    @forelse($product->suppliers as $supplier)
                        <li class="flex items-center">
                            <span class="bg-gray-100 rounded-full p-2">
                                <svg class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125V14.25m-17.25 4.5h1.125c.621 0 1.125-.504 1.125-1.125V14.25m0 0V4.875c0-.621.504-1.125 1.125-1.125h12.75c.621 0 1.125.504 1.125 1.125v9.375m-17.25 0h17.25" /></svg>
                            </span>
                            <span class="ml-4 text-gray-700">{{ $supplier->name }}</span>
                        </li>
                    @empty
                        <li class="text-gray-500">Belum ada supplier terhubung.</li>
                    @endforelse
                </ul>
            </div>

        </div>
    </div>

@endsection