<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'subtitle',
        'price',
        'image_path',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'float',
            'type' => 'integer',
        ];
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(Cart::class, 'product_id');
    }
}
