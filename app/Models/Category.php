<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    //
    protected $fillable = ['name', 'slug', 'parent_id', 'description'];

    // --- Accessor/Mutator Logic for Slug Generation ---

    /**
     * Defines the Mutator for the 'name' attribute.
     * When the 'name' is set (during create or update), this function runs, 
     * setting both the 'name' and automatically generating the unique 'slug'.
     *
     * @return Attribute
     */
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

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
