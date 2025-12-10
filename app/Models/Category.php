<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use RuntimeException; // Used for throwing a controlled error

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'parent_id', 'description'];

    // --- Accessor/Mutator Logic for Strict Slug Generation ---

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => [
                'name' => $value,
                // The setter calls the new strict check method
                'slug' => $this->getStrictUniqueSlug($value),
            ],
        );
    }

    /**
     * Helper method to generate the slug and enforce strict uniqueness.
     * Throws a RuntimeException with status code 409 if the base slug exists.
     * * @throws \RuntimeException
     */
    protected function getStrictUniqueSlug(string $name): string
    {
        $baseSlug = Str::slug($name);

        // 1. Check if the generated base slug already exists in the database.
        if ($this->slugExists($baseSlug)) {
            // If it exists, throw a specific exception.
            // We use 409 as the code to signal HTTP Conflict to the controller.
            throw new RuntimeException(
                "The category name '{$name}' conflicts with an existing slug: '{$baseSlug}'. Please choose a different name.",
                409
            );
        }

        // 2. If it's unique, return the base slug without any counter.
        return $baseSlug;
    }

    /**
     * Checks if a given slug already exists, ignoring the current category's ID during updates.
     */
    protected function slugExists(string $slug): bool
    {
        return Category::where('slug', $slug)
            // Ignore the current record ID only if we are updating (this->id exists)
            ->where('id', '!=', $this->id ?? 0)
            ->exists();
    }

    // --- Relationships (Unchanged) ---

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
