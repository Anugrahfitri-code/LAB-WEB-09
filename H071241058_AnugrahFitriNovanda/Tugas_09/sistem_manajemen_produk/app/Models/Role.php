<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Mendefinisikan relasi "satu Role memiliki banyak User".
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}