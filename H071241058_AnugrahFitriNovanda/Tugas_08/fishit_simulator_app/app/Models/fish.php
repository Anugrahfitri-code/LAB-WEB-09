<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; 

class Fish extends Model
{
    use HasFactory;

    protected $table = 'fishes';

    protected $fillable = [
        'name',
        'rarity',
        'base_weight_min',
        'base_weight_max',
        'sell_price_per_kg',
        'catch_probability',
        'description',
    ];

    public const RARITIES = [
        'Common', 
        'Uncommon', 
        'Rare', 
        'Epic', 
        'Legendary', 
        'Mythic', 
        'Secret'
    ];

    protected function rarityColor(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->rarity) {
                'Common' => 'gray',
                'Uncommon' => 'green',
                'Rare' => 'blue',
                'Epic' => 'purple',
                'Legendary' => 'orange',
                'Mythic' => 'red',
                'Secret' => 'pink',
                default => 'gray',
            }
        );
    }

    protected function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format($this->sell_price_per_kg) . ' Coins'
        );
    }


    protected function formattedWeightRange(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->base_weight_min} - {$this->base_weight_max} kg"
        );
    }

    protected function formattedProbability(): Attribute
    {
        return Attribute::make(
            get: fn () => rtrim(rtrim(number_format($this->catch_probability, 2), '0'), '.') . '%'
        );
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['rarity'] ?? false, function ($query, $rarity) {
            return $query->where('rarity', $rarity);
        });

        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        });

        $query->when($filters['sort'] ?? false, function ($query, $sort) {
            $dir = Str::lower($filters['dir'] ?? 'asc') === 'asc' ? 'asc' : 'desc';
            
            if (in_array($sort, ['name', 'sell_price_per_kg', 'catch_probability'])) {
                return $query->orderBy($sort, $dir);
            }
        });
    }
}

