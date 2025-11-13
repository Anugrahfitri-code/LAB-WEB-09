@extends('layouts.app')

@section('title', 'Detail Gudang: ' . $warehouse->name)

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Detail Gudang
        </h1>
        <a href="{{ route('warehouses.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold transition duration-300">
            &larr; Kembali ke Daftar Gudang
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-2xl p-6 sm:p-8 mb-6 max-w-3xl mx-auto">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-sm font-medium text-gray-500 mb-1">Nama Gudang</h2>
                <p class="text-2xl font-semibold text-gray-900">{{ $warehouse->name }}</p>
            </div>
            <div class="md:col-span-2">
                <h2 class="text-sm font-medium text-gray-500 mb-1">Lokasi</h2>
                <p class="text-gray-700">{{ $warehouse->location ?? '-' }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-2xl p-6 sm:p-8 max-w-3xl mx-auto mt-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">
            Stok Produk di Gudang Ini ({{ $warehouse->products->count() }})
        </h2>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Produk (SKU)</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Jumlah Stok</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    {{-- Loop melalui produk-produk yang terhubung ke gudang ini --}}
                    @forelse($warehouse->products as $product)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                <div class="text-xs text-gray-500">SKU: {{ $product->sku }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{-- Menampilkan nama kategori jika ada --}}
                                {{ $product->category->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                {{-- Data 'quantity' diambil dari tabel pivot --}}
                                <span class="text-lg font-bold text-indigo-700">{{ $product->pivot->quantity }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-4 text-center text-gray-500">
                                Belum ada produk yang distok di gudang ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection