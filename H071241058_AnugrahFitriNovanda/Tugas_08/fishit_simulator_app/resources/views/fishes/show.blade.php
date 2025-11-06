@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="mb-6 bg-green-200 border-l-4 border-green-600 text-green-900 p-4 rounded-lg shadow-md max-w-3xl mx-auto" role="alert">
            <p class="font-bold">Sukses!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <h1 class="text-4xl font-extrabold text-blue-900 mb-2 text-center">
        {{ $fish->name }}
    </h1>

    <div class="flex justify-center mb-8">
        @php $color = $fish->rarity_color; @endphp
        <span class="px-4 py-1.5 inline-flex text-sm leading-5 font-bold rounded-full 
                     bg-{{ $color }}-100 text-{{ $color }}-800 border border-{{ $color }}-300 shadow-sm">
            {{ $fish->rarity }}
        </span>
    </div>

    <div class="bg-white shadow-xl rounded-2xl p-8 md:p-10 max-w-3xl mx-auto">
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
            
            <div class="space-y-6">
                <div>
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Harga Jual per kg</h3>
                    <p class="mt-1 text-2xl font-bold text-gray-900">{{ $fish->formatted_price }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Rentang Berat</h3>
                    <p class="mt-1 text-2xl font-bold text-gray-900">{{ $fish->formatted_weight_range }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Peluang Tertangkap</h3>
                    <p class="mt-1 text-2xl font-bold text-gray-900">{{ $fish->formatted_probability }}</p>
                </div>
            </div>

            <div class="space-y-6">
                 <div>
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Deskripsi</h3>
                    <p class="mt-1 text-base text-gray-700 leading-relaxed break-words">
                        {{-- Tampilkan deskripsi, atau pesan default jika kosong --}}
                        {{ $fish->description ?? '(Tidak ada deskripsi)' }}
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Info Lain</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Ditambahkan: {{ $fish->created_at->format('d M Y, H:i') }}
                    </p>
                    <p class="mt-1 text-sm text-gray-600">
                        Diperbarui: {{ $fish->updated_at->format('d M Y, H:i') }}
                    </p>
                </div>
            </div>
            
        </div> 

        <div class="border-t border-gray-200 mt-8 pt-6 flex items-center justify-between">
            
            <div class="flex items-center space-x-4">
                <a href="{{ route('fishes.edit', $fish) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-all">
                    Edit
                </a>
                
                <form action="{{ route('fishes.destroy', $fish) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ikan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-all">
                        Hapus
                    </button>
                </form>
            </div>

            <a href="{{ route('fishes.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition-all">
                &larr; Kembali ke Daftar
            </a>

        </div>

    </div>
@endsection

