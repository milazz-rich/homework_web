<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'subtitle',
        'price',
        'image_path',
        'type',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'type' => 'integer',
    ];

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }
}