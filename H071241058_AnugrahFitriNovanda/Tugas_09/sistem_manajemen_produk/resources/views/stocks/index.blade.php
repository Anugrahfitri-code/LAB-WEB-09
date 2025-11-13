@extends('layouts.app')

@section('title', 'Manajemen Stok')

@section('content')

    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 sm:mb-0">
            Laporan Stok Produk
        </h1>
        
        <a href="{{ route('stocks.transfer.create') }}" class="bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
            Buat Transfer Stok
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
        <form action="{{ route('stocks.index') }}" method="GET">
            {{-- Menggunakan Grid agar lebih rapi --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-4 items-center">
                
                <div class="sm:col-span-1 lg:col-span-1">
                    <label for="warehouse_id" class="block text-sm font-medium text-gray-700">
                        Filter Gudang:
                    </label>
                    <select name="warehouse_id" id="warehouse_id"
                            class="input-field mt-1 w-full">
                        <option value="">-- Semua Gudang --</option>
                        @foreach ($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" 
                                @if($selectedWarehouseId == $warehouse->id) selected @endif>
                                {{ $warehouse->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-2 lg:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700">
                        Cari Nama/SKU:
                    </label>
                    <input type="text" name="search" id="search"
                           class="input-field mt-1 w-full"
                           placeholder="Masukkan nama produk atau SKU..."
                           value="{{ $searchQuery ?? '' }}"> {{-- Ingat nilai pencarian lama --}}
                </div>

                <div class="sm:col-span-3 lg:col-span-2 flex items-end gap-2 mt-5">
                    <button type="submit"
                            class="bg-indigo-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300">
                        Cari
                    </button>
                    <a href="{{ route('stocks.index') }}" class="text-gray-600 hover:text-indigo-800 font-medium py-2 px-4 rounded-lg bg-gray-100 hover:bg-gray-200">
                        Reset
                    </a>
                </div>

            </div>
        </form>
    </div>
    <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Gudang
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Produk (SKU)
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total Stok (SUM)
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    
                    @forelse ($stocks as $stock)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $stock->warehouse_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $stock->product_name }}</div>
                                <div class="text-xs text-gray-500">{{ $stock->product_sku }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-lg font-bold text-indigo-700">{{ $stock->quantity }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                Tidak ada data stok untuk ditampilkan.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

    {{-- Kita perlu 'input-field' style di sini untuk form filter --}}
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