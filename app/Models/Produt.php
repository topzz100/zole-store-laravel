<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produt extends Model
{
    /** @use HasFactory<\Database\Factories\ProdutFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category_id',
        'brand',
        'price',
        'tags',
        'images',
        'is_sold',  // added
    ];

    protected $casts = [
        'tags' => 'array',
        'images' => 'array',
        'is_sold' => 'boolean',
    ];
}
