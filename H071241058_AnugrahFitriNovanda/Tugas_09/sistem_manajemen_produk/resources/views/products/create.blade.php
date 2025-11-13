@extends('layouts.app')

@section('title', 'Tambah Produk Baru')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Tambah Produk Baru
        </h1>
        <a href="{{ route('products.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold transition duration-300">
            &larr; Kembali ke Daftar
        </a>
    </div>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf 

        <div class="bg-white rounded-xl shadow-2xl p-6 sm:p-8 mb-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Informasi Utama Produk</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Produk (Wajib)</label>
                    <input type="text" name="name" id="name" 
                           class="input-field @error('name') border-red-500 @enderror" 
                           value="{{ old('name') }}" required> {{-- Menggunakan old(), bukan $product --}}
                    @error('name')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Kategori (Opsional)</label>
                    <select name="category_id" id="category_id" class="input-field">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if(old('category_id') == $category->id) selected @endif>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Harga (Wajib)</label>
                    <input type="number" name="price" id="price" step="0.01" min="0" class="input-field" value="{{ old('price') }}" required placeholder="Contoh: 1500000.00">
                    @error('price')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">SKU (Wajib, Unik)</label>
                    <input type="text" name="sku" id="sku" 
                           class="input-field @error('sku') border-red-500 @enderror" 
                           value="{{ old('sku') }}" required 
                           placeholder="Contoh: KAT-MEREK-001">
                    
                    <p class="text-xs text-gray-500 mt-1">
                        Format: [KAT]-[MEREK]-[NOMOR]. Gunakan huruf kapital. Contoh: LAP-ASUS-001
                    </p>
                    
                    @error('sku')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="status" class="input-field">
                        <option value="active" @if(old('status') == 'active') selected @endif>Active</option>
                        <option value="inactive" @if(old('status') == 'inactive') selected @endif>Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-2xl p-6 sm:p-8 mb-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Detail Produk</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">Berat (kg) (Wajib)</label>
                    <input type="number" name="weight" id="weight" step="0.01" min="0" class="input-field" value="{{ old('weight') }}" required placeholder="Contoh: 1.50">
                    @error('weight')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="size" class="block text-sm font-medium text-gray-700 mb-2">Ukuran (Opsional)</label>
                    <input type="text" name="size" id="size" class="input-field" value="{{ old('size') }}" placeholder="Contoh: 15 inch">
                </div>
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Lengkap (Opsional)</label>
                    <textarea name="description" id="description" rows="4" class="input-field">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        <div class="mt-8 text-right">
            <button type="submit"
                    class="bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300 ease-in-out">
                Simpan Produk
            </button>
        </div>
    </form>
    
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
        /* Style untuk input yang error */
        .input-field.border-red-500 {
            border-color: #EF4444; /* red-500 */
        }
        .input-field.border-red-500:focus {
            --tw-ring-color: #EF4444; /* red-500 */
            border-color: #EF4444; /* red-500 */
        }
    </style>

@endsection
