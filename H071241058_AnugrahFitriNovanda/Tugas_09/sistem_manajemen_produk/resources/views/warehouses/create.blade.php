@extends('layouts.app')

@section('title', 'Tambah Gudang Baru')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Tambah Gudang Baru
        </h1>
        <a href="{{ route('warehouses.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold transition duration-300">
            &larr; Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-2xl p-6 sm:p-8 max-w-2xl mx-auto">
        
        <form action="{{ route('warehouses.store') }}" method="POST">
            @csrf 
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Gudang (Wajib)
                    </label>
                    <input type="text" name="name" id="name"
                           class="input-field"
                           value="{{ old('name') }}"
                           required>
                    @error('name')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                        Lokasi (Opsional)
                    </label>
                    <textarea name="location" id="location" rows="4"
                              class="input-field">{{ old('location') }}</textarea>
                </div>
            </div>
            <div class="mt-8 text-right">
                <button type="submit"
                        class="bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300 ease-in-out">
                    Simpan Gudang
                </button>
            </div>
        </form>
    </div>

    {{-- Blok <style> untuk mempercantik input --}}
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
