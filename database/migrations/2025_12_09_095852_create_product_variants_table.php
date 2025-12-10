<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->id();

            // Foreign Key to the Product table
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            // Unique identifier for inventory tracking
            $table->string('sku')->unique();

            // Variant attributes (options)
            $table->string('color')->nullable();
            $table->string('size')->nullable();

            // Pricing and Inventory
            $table->decimal('price', 8, 2); // The actual price of this variant (or adjustment)
            $table->unsignedInteger('stock_quantity')->default(0);

            // Optional: for images specific to this variant
            $table->string('image_path')->nullable();

            $table->timestamps();

            // Ensures no two variants of the same product can have the same color/size combination.
            $table->unique(['product_id', 'color', 'size']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
