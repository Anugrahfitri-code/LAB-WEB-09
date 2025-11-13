<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductDetail extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', // Foreign key
        'description',
        'weight',
        'size',
    ];

    /**
     * Mendefinisikan relasi "satu ProductDetail milik satu Produk".
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}