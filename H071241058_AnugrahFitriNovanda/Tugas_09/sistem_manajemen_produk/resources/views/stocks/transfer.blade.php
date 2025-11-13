@extends('layouts.app')

@section('title', 'Transfer / Penyesuaian Stok')

@section('content')

    <!-- Header Halaman -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Transfer / Penyesuaian Stok
        </h1>
        <a href="{{ route('stocks.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold transition duration-300">
            &larr; Kembali ke Laporan Stok
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-2xl p-6 sm:p-8 max-w-2xl mx-auto">
        
        <form action="{{ route('stocks.transfer.store') }}" method="POST">
            @csrf <!-- Keamanan Laravel -->

            <div class="grid grid-cols-1 gap-6">
                
                <!-- Input Pilih Gudang (Wajib) -->
                <div>
                    <label for="warehouse_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Gudang (Wajib)
                    </label>
                    {{-- PERUBAHAN: Menambahkan class 'input-field' --}}
                    <select name="warehouse_id" id="warehouse_id"
                            class="input-field"
                            required>
                        <option value="">-- Pilih Gudang --</option>
                        @foreach ($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" @if(old('warehouse_id') == $warehouse->id) selected @endif>
                                {{ $warehouse->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Input Pilih Produk (Wajib) -->
                <div>
                    <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Produk (Wajib)
                    </label>
                    {{-- PERUBAHAN: Menambahkan class 'input-field' --}}
                    <select name="product_id" id="product_id"
                            class="input-field"
                            required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" @if(old('product_id') == $product->id) selected @endif>
                                {{ $product->name }} (SKU: {{ $product->sku }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Input Jumlah Stok (Sesuai PDF) -->
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                        Jumlah Stok (Wajib)
                    </label>
                    {{-- PERUBAHAN: Menambahkan class 'input-field' --}}
                    <input type="number" name="quantity" id="quantity"
                           value="{{ old('quantity') }}"
                           class="input-field"
                           placeholder="Contoh: 10 (masuk) atau -5 (keluar)"
                           required>
                    <p class="mt-2 text-xs text-gray-500">
                        Masukkan nilai positif (contoh: `10`) untuk stok masuk, atau nilai negatif (contoh: `-5`) untuk stok keluar.
                    </p>
                </div>

                <!-- Input Catatan (Opsional, dari 'stock_movements') -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan (Opsional)
                    </label>
                    {{-- PERUBAHAN: Menambahkan class 'input-field' --}}
                    <textarea name="notes" id="notes" rows="3"
                              placeholder="Contoh: Stok opname, barang rusak, retur"
                              class="input-field">{{ old('notes') }}</textarea>
                </div>

            </div>

            <!-- Tombol Submit -->
            <div class="mt-8 text-right">
                <button type="submit"
                        class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300 ease-in-out">
                    Proses Stok
                </button>
            </div>

        </form>
    </div>

    {{-- TAMBAHAN: Blok <style> untuk mempercantik input --}}
    <style>
        .input-field {
            display: block; width: 100%;
            padding: 0.75rem 1rem;
            border-width: 1px; border-color: #D1D5DB; /* gray-300 */
            border-radius: 0.5rem; /* rounded-lg */
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05); /* shadow-sm */
            transition: all 150ms ease-in-out;
        }
        .input-field:focus {
            outline: none;
            --tw-ring-color: #6366F1; /* indigo-500 */
            box-shadow: 0 0 0 2px var(--tw-ring-color);
            border-color: #6366F1; /* indigo-500 */
        }
    </style>

@endsection