{{-- 1. Mewarisi layout utama --}}
@extends('layouts.app')

{{-- 2. Mengisi judul halaman --}}
@section('title', 'Tambah Kategori Baru')

{{-- 3. Mengisi konten halaman --}}
@section('content')

    <!-- Header Halaman -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Tambah Kategori Baru
        </h1>
        <a href="{{ route('categories.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold transition duration-300">
            &larr; Kembali ke Daftar
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-2xl p-6 sm:p-8 max-w-2xl mx-auto">
        
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf 
            <div class="grid grid-cols-1 gap-6">
                
                <!-- Input Nama Kategori -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Kategori (Wajib)
                    </label>
                    {{-- 4. Terapkan style 'input-field' --}}
                    <input type="text" name="name" id="name"
                           class="input-field" 
                           value="{{ old('name') }}"
                           required>
                </div>

                <!-- Input Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi (Opsional)
                    </label>
                    {{-- 4. Terapkan style 'input-field' --}}
                    <textarea name="description" id="description" rows="4"
                              class="input-field">{{ old('description') }}</textarea>
                </div>

                <!-- Input Induk Kategori -->
                <div>
                    <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Induk Kategori (Opsional, untuk Sub-kategori)
                    </label>
                    {{-- 4. Terapkan style 'input-field' --}}
                    <select name="parent_id" id="parent_id"
                            class="input-field">
                        <option value="">-- Tidak Ada Induk --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if(old('parent_id') == $category->id) selected @endif>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="mt-8 text-right">
                <button type="submit"
                        class="bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300 ease-in-out">
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>

    {{-- 5. Tambahkan blok <style> ini untuk mempercantik input --}}
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