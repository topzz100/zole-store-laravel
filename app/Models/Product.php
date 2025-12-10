<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'base_price',
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

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => [
                'name' => $value,
                // Calls the helper function to generate and check for uniqueness
                'slug' => $this->generateUniqueSlug($value),
            ],
        );
    }

    /**
     * Helper method to ensure the generated slug is unique by appending a counter.
     */
    protected function generateUniqueSlug(string $name): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $count = 1;

        // Loop until a unique slug is found
        while (Category::where('slug', $slug)
            // IMPORTANT: For updates, ignore the category being updated.
            ->where('id', '!=', $this->id ?? 0)
            ->exists()
        ) {
            $slug = $baseSlug . '-' . $count++;
        }

        return $slug;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
