@extends('layouts.app')

@section('content')
    <h1 class="text-4xl font-extrabold text-blue-900 mb-8 text-center">
        Edit Ikan: <span class="text-yellow-500">{{ $fish->name }}</span>
    </h1>

    <div class="bg-white shadow-xl rounded-2xl p-8 md:p-10 max-w-3xl mx-auto">
        
        @if ($errors->any())
            <div class="mb-6 bg-red-200 border-l-4 border-red-600 text-red-900 p-4 rounded-lg shadow-md" role="alert">
                <strong class="font-bold">Oops! Ada yang salah:</strong>
                <ul class="list-disc list-inside mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('fishes.update', $fish) }}" method="POST">
            @csrf 
            @method('PUT') 

            <div class="space-y-6">

                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Nama Ikan</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $fish->name) }}"
                           class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror" required
                           placeholder="cth: Ikan Mas">
                    @error('name')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="rarity" class="block text-sm font-bold text-gray-700 mb-1">Rarity</label>
                    <select name="rarity" id="rarity" 
                            class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('rarity') border-red-500 @enderror" required>
                        <option value="">Pilih Rarity</option>
                        @foreach($rarities as $rarity)
                            <option value="{{ $rarity }}" {{ old('rarity', $fish->rarity) == $rarity ? 'selected' : '' }}>
                                {{ $rarity }}
                            </option>
                        @endforeach
                    </select>
                    @error('rarity')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="base_weight_min" class="block text-sm font-bold text-gray-700 mb-1">Berat Minimum (kg)</label>
                        <input type="number" step="0.01" name="base_weight_min" id="base_weight_min" value="{{ old('base_weight_min', $fish->base_weight_min) }}"
                               class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('base_weight_min') border-red-500 @enderror" required
                               placeholder="cth: 0.5">
                        @error('base_weight_min')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="base_weight_max" class="block text-sm font-bold text-gray-700 mb-1">Berat Maksimum (kg)</label>
                        <input type="number" step="0.01" name="base_weight_max" id="base_weight_max" value="{{ old('base_weight_max', $fish->base_weight_max) }}"
                               class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('base_weight_max') border-red-500 @enderror" required
                               placeholder="cth: 2.5">
                        @error('base_weight_max')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="sell_price_per_kg" class="block text-sm font-bold text-gray-700 mb-1">Harga Jual / kg (Coins)</label>
                        <input type="number" name="sell_price_per_kg" id="sell_price_per_kg" value="{{ old('sell_price_per_kg', $fish->sell_price_per_kg) }}"
                               class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('sell_price_per_kg') border-red-500 @enderror" required
                               placeholder="cth: 10">
                        @error('sell_price_per_kg')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="catch_probability" class="block text-sm font-bold text-gray-700 mb-1">Peluang Tangkap (0.01 - 100%)</label>
                        <input type="number" step="0.01" name="catch_probability" id="catch_probability" value="{{ old('catch_probability', $fish->catch_probability) }}"
                               class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('catch_probability') border-red-500 @enderror" required
                               placeholder="cth: 75.5">
                        @error('catch_probability')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-1">Deskripsi (Boleh kosong)</label>
                    <textarea name="description" id="description" rows="4"
                              class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                              placeholder="Deskripsi singkat tentang ikan...">{{ old('description', $fish->description) }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="border-t border-gray-200 pt-6 flex items-center space-x-4">
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200">
                        Perbarui Data
                    </button>
                    <a href="{{ route('fishes.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition-all">
                        Batal
                    </a>
                </div>

            </div> 
        </form>
    </div>
@endsection

