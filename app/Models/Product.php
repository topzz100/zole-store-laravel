<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
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
        'gender',
        'is_sold',  // added
    ];

    protected $casts = [
        'tags' => 'array',
        'images' => 'array',
        'is_sold' => 'boolean',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
