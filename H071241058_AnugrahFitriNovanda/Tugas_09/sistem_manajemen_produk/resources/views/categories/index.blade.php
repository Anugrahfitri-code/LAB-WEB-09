@extends('layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')

    <!-- Header Halaman dan Tombol Tambah -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 sm:mb-0">
            Manajemen Kategori
        </h1>
        
        {{-- Tombol "Tambah" ini HANYA MUNCUL untuk Admin --}}
        @if(Auth::user()->role->name == 'Admin')
            <a href="{{ route('categories.create') }}" class="bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                + Tambah Kategori
            </a>
        @endif
    </div>

    <!-- Tampilan Tabel -->
    <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <!-- Header Tabel -->
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Kategori
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Deskripsi
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <!-- Body Tabel -->
                <tbody class="bg-white divide-y divide-gray-200">
                    
                    @forelse ($categories as $category)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700">{{ $category->description ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                
                                {{-- Tombol "Aksi" ini HANYA MUNCUL untuk Admin --}}
                                @if(Auth::user()->role->name == 'Admin')
                                    
                                    {{-- INI ADALAH TOMBOL "LIHAT" YANG HILANG --}}
                                    <a href="{{ route('categories.show', $category->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                        Lihat
                                    </a>
                                    
                                    <a href="{{ route('categories.edit', $category->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                    
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            Hapus
                                        </button>
                                    </form>

                                {{-- Jika bukan admin, hanya bisa melihat (sesuai aturan peran) --}}
                                @else
                                    {{-- Staf lain bisa juga melihat detail --}}
                                    <a href="{{ route('categories.show', $category->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                        Lihat
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                Belum ada data kategori.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

@endsection