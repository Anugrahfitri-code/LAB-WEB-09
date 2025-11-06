@extends('layouts.app')

@section('content')

    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-4xl font-extrabold text-blue-900">Daftar Ikan</h1>
        <a href="{{ route('fishes.create') }}" 
           class="w-full md:w-auto bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200 text-center">
            + Tambah Ikan Baru
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-200 border-l-4 border-green-600 text-green-900 p-4 rounded-lg shadow-md" role="alert">
            <p class="font-bold">Sukses!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <form method="GET" action="{{ route('fishes.index') }}" class="mb-8 bg-white p-6 rounded-2xl shadow-xl">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div>
                <label for="search" class="block text-sm font-bold text-gray-700 mb-1">Cari Nama Ikan:</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                       class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="cth: Ikan Mas...">
            </div>
            
            <div>
                <label for="rarity" class="block text-sm font-bold text-gray-700 mb-1">Filter Rarity:</label>
                <select name="rarity" id="rarity" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Semua Rarity</option>
                    @foreach($rarities as $rarity)
                        <option value="{{ $rarity }}" {{ request('rarity') == $rarity ? 'selected' : '' }}>
                            {{ $rarity }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col md:flex-row items-end space-y-3 md:space-y-0 md:space-x-3">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-all">
                    Filter / Cari
                </button>
                <a href="{{ route('fishes.index') }}" class="w-full md:w-auto text-center text-gray-800 bg-gray-200 hover:bg-gray-300 font-bold py-3 px-6 rounded-lg transition-all" title="Reset Filter">
                    Reset
                </a>
            </div>
        </div>
    </form>

    <div class="bg-white shadow-xl rounded-2xl overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-blue-500">
                <tr>
                    {{-- 
                        LOGIKA SORTING BARU:
                        - sortable_link_standard: Default 'asc'. ▲ = 'asc' (A-Z).
                        - sortable_link_inverted: Default 'desc'. ▲ = 'desc' (Tertinggi).
                    --}}
                    @php
                    function build_sort_link($column, $label, $defaultDir, $visualMap) {
                        $params = request()->all();
                        $currentSort = request('sort');
                        $currentDir = request('dir');
                        
                        $arrow = '';
                        $nextDir = $defaultDir;

                        if ($currentSort == $column) {
                            // Kolom ini AKTIF
                            $arrowClass = 'text-white'; // Selalu terlihat
                            
                            // Tentukan panah berdasarkan $visualMap
                            if ($currentDir == 'asc') {
                                $arrow = ($visualMap == 'standard') ? '▲' : '▼'; // Standard: asc=UP. Inverted: asc=DOWN.
                                $nextDir = 'desc';
                            } else {
                                $arrow = ($visualMap == 'standard') ? '▼' : '▲'; // Standard: desc=DOWN. Inverted: desc=UP.
                                $nextDir = 'asc';
                            }
                        } else {
                            // Kolom ini TIDAK AKTIF
                            // PERBAIKAN: Tampilkan panah default (samar), bukan disembunyikan
                            $arrowClass = 'text-blue-200 opacity-50 group-hover:opacity-100';
                            
                            // Tampilkan panah default
                            if ($defaultDir == 'asc') {
                                $arrow = ($visualMap == 'standard') ? '▲' : '▼';
                            } else {
                                $arrow = ($visualMap == 'standard') ? '▼' : '▲';
                            }
                        }
                        
                        $params['sort'] = $column;
                        $params['dir'] = $nextDir;
                        
                        return '<a href="'.route('fishes.index', $params).'" class="inline-flex items-center group">
                                    '.$label.' 
                                    <span class="ml-1.5 text-xs ' . $arrowClass . '">'.$arrow.'</span>
                                </a>';
                    }

                    /**
                     * Untuk 'Nama'. Default A-Z (asc). Panah Atas ▲ = asc.
                     */
                    function sortable_link_standard($column, $label) {
                        return build_sort_link($column, $label, 'asc', 'standard');
                    }

                    /**
                     * Untuk 'Harga' & 'Peluang'. Default Tertinggi (desc). Panah Atas ▲ = desc.
                     */
                    function sortable_link_inverted($column, $label) {
                        return build_sort_link($column, $label, 'desc', 'inverted');
                    }
                    @endphp
                    
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                        {{-- Nama: Default 'asc'. ▲ = 'asc' (A-Z) --}}
                        {!! sortable_link_standard('name', 'Nama') !!}
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                        Rarity
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                        {{-- Harga: Default 'desc'. ▲ = 'desc' (Tertinggi) --}}
                        {!! sortable_link_inverted('sell_price_per_kg', 'Harga/kg') !!}
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                        {{-- Peluang: Default 'desc'. ▲ = 'desc' (Tertinggi) --}}
                        {!! sortable_link_inverted('catch_probability', 'Peluang') !!}
                    </th>
                    <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($fishes as $fish)
                    <tr class="hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900">{{ $fish->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php $color = $fish->rarity_color; @endphp
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full 
                                        bg-{{ $color }}-100 text-{{ $color }}-800 border border-{{ $color }}-300">
                                {{ $fish->rarity }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $fish->formatted_price }} 
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $fish->formatted_probability }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('fishes.show', $fish) }}" class="text-blue-600 hover:text-blue-900 font-bold mr-3">Lihat</a>
                            <a href="{{ route('fishes.edit', $fish) }}" class="text-yellow-600 hover:text-yellow-900 font-bold mr-3">Edit</a>
                            <form action="{{ route('fishes.destroy', $fish) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ikan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 text-lg">
                            Tidak ada data ikan yang ditemukan... 🎣
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{-- Menambahkan `appends` agar filter & sort tetap ada saat ganti halaman --}}
        {{ $fishes->appends(request()->query())->links() }}
    </div>

@endsection

