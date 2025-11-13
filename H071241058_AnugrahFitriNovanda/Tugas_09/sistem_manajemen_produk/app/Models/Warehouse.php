<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warehouse extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'location',
    ];

    /**
     * Mendefinisikan relasi N:M (Many-to-Many) "satu Gudang memiliki banyak Produk".
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_warehouse')
                    ->withPivot('quantity');
    }

    /**
     * Mendefinisikan relasi "satu Gudang memiliki banyak StockMovement".
     */
    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }
}