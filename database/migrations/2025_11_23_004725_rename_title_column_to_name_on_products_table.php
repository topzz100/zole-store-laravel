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
        Schema::table('name_on_products', function (Blueprint $table) {
            // Change the column name from 'title' to 'name'
            Schema::table('products', function (Blueprint $table) {
                $table->renameColumn('title', 'name');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('name_on_products', function (Blueprint $table) {
            // Revert the column name from 'name' back to 'title'
            Schema::table('products', function (Blueprint $table) {
                $table->renameColumn('name', 'title');
            });
        });
    }
};
