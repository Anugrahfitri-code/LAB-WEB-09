<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'category_id', 
        'sku',         
        'status',      
        'image_url',   
    ];

    /**
     * Mendefinisikan relasi "satu Produk milik satu Kategori".
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Mendefinisikan relasi 1:1 "satu Produk memiliki satu ProductDetail".
     */
    public function productDetail(): HasOne
    {
        return $this->hasOne(ProductDetail::class);
    }

    /**
     * Mendefinisikan relasi N:M "satu Produk dimiliki banyak Gudang".
     */
    public function warehouses(): BelongsToMany
    {
        return $this->belongsToMany(Warehouse::class, 'product_warehouse')
                    ->withPivot('quantity'); 
    }

    /**
     * Mendefinisikan relasi N:M "satu Produk dimiliki banyak Supplier".
     */
    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class, 'product_supplier');
    }

    /**
     * Mendefinisikan relasi "satu Produk memiliki banyak StockMovement".
     */
    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }
}