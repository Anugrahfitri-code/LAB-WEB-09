<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 

class FishController extends Controller
{

    public function index(Request $request)
    {
        $rarities = Fish::RARITIES;

        $query = Fish::query()->filter($request->only('rarity', 'search'));

        $sortColumn = $request->input('sort');
        $sortDirection = $request->input('dir', 'asc'); 

        $sortableColumns = ['name', 'sell_price_per_kg', 'catch_probability'];
        
        if (in_array($sortColumn, $sortableColumns)) {
            $query->orderBy($sortColumn, $sortDirection);
        } else {
            $query->orderBy('name', 'asc'); 
        }

        $fishes = $query->paginate(10)->withQueryString();

        return view('fishes.index', [
            'fishes' => $fishes,
            'rarities' => $rarities,
            'request' => $request, 
        ]);
    }

    public function create()
    {
        return view('fishes.create', [
            'rarities' => Fish::RARITIES,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate($this->rules(), $this->messages());

        Fish::create($validatedData);

        return redirect()->route('fishes.index')->with('success', 'Ikan baru berhasil ditambahkan!');
    }

    public function show(Fish $fish)
    {
        return view('fishes.show', compact('fish'));
    }

    public function edit(Fish $fish)
    {
        return view('fishes.edit', [
            'fish' => $fish,
            'rarities' => Fish::RARITIES,
        ]);
    }

    public function update(Request $request, Fish $fish)
    {
        $validatedData = $request->validate($this->rules($fish), $this->messages());

        $fish->update($validatedData);

        return redirect()->route('fishes.show', $fish)->with('success', 'Data ikan berhasil diperbarui!');
    }

    public function destroy(Fish $fish)
    {
        $fish->delete();
        return redirect()->route('fishes.index')->with('success', 'Data ikan berhasil dihapus.');
    }

    private function rules(Fish $fish = null): array
    {
        $uniqueRule = Rule::unique('fishes', 'name'); 

        if ($fish) {
            $uniqueRule->ignore($fish->id);
        }

        return [
            'name' => ['required', 'string', 'max:100', $uniqueRule],
            'rarity' => ['required', Rule::in(Fish::RARITIES)],
            'base_weight_min' => ['required', 'numeric', 'min:0.01', 'lte:base_weight_max'], 
            'base_weight_max' => ['required', 'numeric', 'gte:base_weight_min'],
            'sell_price_per_kg' => ['required', 'integer', 'min:1'],
            'catch_probability' => ['required', 'numeric', 'min:0.01', 'max:100.00'],
            'description' => 'nullable|string',
        ];
    }

    private function messages(): array
    {
        return [
            'name.unique' => 'Nama ikan ini sudah ada di database, tidak boleh duplikat.',
            
            'name.required' => 'Nama ikan tidak boleh kosong.',
            'rarity.required' => 'Anda harus memilih rarity.',
            'base_weight_min.required' => 'Berat minimum tidak boleh kosong.',
            'base_weight_max.required' => 'Berat maksimum tidak boleh kosong.',
            'sell_price_per_kg.required' => 'Harga jual tidak boleh kosong.',
            'catch_probability.required' => 'Peluang tangkap tidak boleh kosong.',

            'base_weight_max.gte' => 'Berat maksimum harus lebih besar atau sama dengan berat minimum.',
            'base_weight_min.lte' => 'Berat minimum harus lebih kecil atau sama dengan berat maksimum.',
            'catch_probability.min' => 'Peluang tangkap minimal adalah 0.01%.',
            'catch_probability.max' => 'Peluang tangkap maksimal adalah 100%.',
            'rarity.in' => 'Nilai Rarity tidak valid.',
            '*.numeric' => 'Field ini harus berupa angka.',
            '*.integer' => 'Field ini harus berupa angka bulat.',
        ];
    }
}

