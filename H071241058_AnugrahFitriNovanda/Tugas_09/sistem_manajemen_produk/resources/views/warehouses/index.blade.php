@extends('layouts.app')

@section('title', 'Manajemen Gudang')

@section('content')

    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 sm:mb-0">
            Manajemen Gudang (Warehouse)
        </h1>
        
        {{-- Tombol "Tambah" ini HANYA MUNCUL untuk Admin --}}
        @if(Auth::user()->role->name == 'Admin')
            <a href="{{ route('warehouses.create') }}" class="bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                + Tambah Gudang
            </a>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Gudang
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Lokasi
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    
                    @forelse ($warehouses as $warehouse)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $warehouse->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700">{{ $warehouse->location ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                
                                {{-- PERUBAHAN DI SINI --}}
                                
                                <!-- Tombol "Lihat" (Untuk semua yg bisa akses halaman ini) -->
                                <a href="{{ route('warehouses.show', $warehouse->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                    Lihat
                                </a>

                                {{-- Tombol "Edit/Hapus" (Hanya Admin) --}}
                                @if(Auth::user()->role->name == 'Admin')
                                    <a href="{{ route('warehouses.edit', $warehouse->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                    
                                    <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus gudang ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            Hapus
                                        </button>
                                    </form>
                                @else
                                    {{-- Pesan untuk Staf Produk --}}
                                    <span class="text-xs text-gray-500 italic ml-2">Hanya Admin</span>
                                @endif
                                
                                {{-- AKHIR PERUBAHAN --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                Belum ada data gudang.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

@endsection