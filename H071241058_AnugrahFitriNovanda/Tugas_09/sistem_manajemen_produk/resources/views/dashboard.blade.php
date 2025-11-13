@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    {{-- 1. Teks Selamat Datang (yang sudah diperbaiki) --}}
    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">
        Selamat Datang, {{ $user->name }}!
    </h1>
    <p class="text-lg text-gray-600 mb-8">
        Anda login sebagai 
        <span class="bg-purple-100 text-purple-800 font-semibold px-3 py-1 rounded-full text-sm mx-1">
            {{ $user->role->name }}
        </span> 
        Ini adalah ringkasan sistem Anda.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        @if(in_array($user->role->name, ['Admin', 'Staf Produk', 'Staf Gudang']))
            <a href="{{ route('products.index') }}" 
               class="block bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transform hover:scale-105 transition duration-300">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-500">Produk</h3>
                        <p class="text-5xl font-bold text-indigo-600 mt-2">{{ $data['product_count'] }}</p>
                    </div>
                    <div class="bg-indigo-100 rounded-full p-4">
                        <svg class="h-10 w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25L3 7.5m18 0v9l-9 5.25L3 16.5V7.5m9 5.25l9-5.25M3 7.5l9 5.25M12 21v-9.75" />
                        </svg>
                    </div>
                </div>
                <p class="text-indigo-600 font-semibold mt-4">
                    @if(in_array($user->role->name, ['Admin', 'Staf Produk']))
                        Kelola Produk &rarr;
                    @else
                        Lihat Produk &rarr;
                    @endif
                </p>
            </a>
        @endif

        @if(in_array($user->role->name, ['Admin', 'Staf Gudang']))
            <a href="{{ route('stocks.index') }}" 
               class="block bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transform hover:scale-105 transition duration-300">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-500">Stok</h3>
                        <p class="text-gray-600 mt-2 text-sm">Atur stok masuk dan keluar, serta lihat laporan.</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-4">
                        <svg class="h-10 w-10 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                    </div>
                </div>
                <p class="text-blue-600 font-semibold mt-10">Kelola Stok &rarr;</p>
            </a>
        @endif

        @if(in_array($user->role->name, ['Admin', 'Staf Produk']))
            <a href="{{ route('warehouses.index') }}" 
               class="block bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transform hover:scale-105 transition duration-300">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-500">Gudang</h3>
                        <p class="text-5xl font-bold text-purple-600 mt-2">{{ $data['warehouse_count'] }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-4">
                        <svg class="h-10 w-10 text-purple-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h6.75M9 11.25h6.75M9 15.75h6.75M4.5 21v-3.375c0-.621.504-1.125 1.125-1.125h12.75c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>
                    </div>
                </div>
                <p class="text-purple-600 font-semibold mt-4">
                    @if($user->role->name == 'Admin')
                        Kelola Gudang &rarr;
                    @else
                        Lihat Daftar Gudang &rarr;
                    @endif
                </p>
            </a>
        @endif

        @if($user->role->name == 'Admin')
            <a href="{{ route('categories.index') }}" 
               class="block bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transform hover:scale-105 transition duration-300">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-500">Kategori</h3>
                        <p class="text-5xl font-bold text-pink-600 mt-2">{{ $data['category_count'] }}</p>
                    </div>
                    <div class="bg-pink-100 rounded-full p-4">
                        <svg class="h-10 w-10 text-pink-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                        </svg>
                    </div>
                </div>
                <p class="text-pink-600 font-semibold mt-4">Kelola Kategori &rarr;</p>
            </a>
        @endif
    </div>


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8 mt-8">
        <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Pergerakan Stok (7 Hari Terakhir)</h3>
            <canvas id="stockMovementChart"></canvas>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Distribusi Stok per Gudang</h3>
            <canvas id="stockPerWarehouseChart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4 text-red-600">
                <span class="mr-2">⚠️</span>Produk dengan Stok Rendah
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="border-b">
                        <tr>
                            <th class="py-2 text-left text-sm font-medium text-gray-500">Produk</th>
                            <th class="py-2 text-left text-sm font-medium text-gray-500">Gudang</th>
                            <th class="py-2 text-right text-sm font-medium text-gray-500">Sisa Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data['low_stock_products'] as $item)
                            <tr class="border-b border-gray-100">
                                <td class="py-2 text-sm text-gray-700">{{ $item->product_name }}</td>
                                <td class="py-2 text-sm text-gray-500">{{ $item->warehouse_name }}</td>
                                <td class="py-2 text-sm font-bold text-red-600 text-right">{{ $item->quantity }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 text-center text-gray-500">Stok aman! Tidak ada produk di bawah batas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Pergerakan Stok Terakhir</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="border-b">
                        <tr>
                            <th class="py-2 text-left text-sm font-medium text-gray-500">Produk</th>
                            <th class="py-2 text-left text-sm font-medium text-gray-500">Gudang</th>
                            <th class="py-2 text-right text-sm font-medium text-gray-500">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data['recent_movements'] as $move)
                            <tr class="border-b border-gray-100">
                                <td class="py-2 text-sm text-gray-700">{{ $move->product->name }}</td>
                                <td class="py-2 text-sm text-gray-500">{{ $move->warehouse->name }}</td>
                                <td class="py-2 text-sm font-bold text-right">
                                    @if($move->type == 'in')
                                        <span class="text-green-600">+{{ $move->quantity }}</span>
                                    @else
                                        <span class="text-red-600">{{ $move->quantity }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 text-center text-gray-500">Belum ada pergerakan stok.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            const warehouseData = @json($data['warehouseChart']);
            const movementData = @json($data['movementChart']);

            const ctxWarehouse = document.getElementById('stockPerWarehouseChart');
            if (ctxWarehouse) {
                new Chart(ctxWarehouse, {
                    type: 'doughnut',
                    data: {
                        labels: warehouseData.labels,
                        datasets: [{
                            label: 'Total Stok',
                            data: warehouseData.data,
                            backgroundColor: [
                                'rgb(107, 33, 168)', // purple-700
                                'rgb(129, 140, 248)', // indigo-400
                                'rgb(59, 130, 246)',  // blue-500
                                'rgb(236, 72, 153)'  // pink-500
                            ],
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            },
                        }
                    }
                });
            }

            const ctxMovement = document.getElementById('stockMovementChart');
            if (ctxMovement) {
                new Chart(ctxMovement, {
                    type: 'bar',
                    data: {
                        labels: movementData.labels,
                        datasets: [
                            {
                                label: 'Stok Masuk',
                                data: movementData.stok_masuk,
                                borderColor: 'rgb(22, 163, 74)', // green-600
                                backgroundColor: 'rgba(22, 163, 74, 0.1)',
                                fill: true,
                                tension: 0.3
                            },
                            {
                                label: 'Stok Keluar',
                                data: movementData.stok_keluar,
                                borderColor: 'rgb(220, 38, 38)', // red-600
                                backgroundColor: 'rgba(220, 38, 38, 0.1)',
                                fill: true,
                                tension: 0.3
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                        }
                    }
                });
            }

        }); 
    </script>

@endsection