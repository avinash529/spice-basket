<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('farmer_id')->nullable()->constrained()->nullOnDelete();
            $table->string('unit')->default('100g');
            $table->unsignedInteger('stock_qty')->default(0);
            $table->string('origin')->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['farmer_id']);
            $table->dropColumn([
                'slug',
                'category_id',
                'farmer_id',
                'unit',
                'stock_qty',
                'origin',
                'image_url',
                'is_active',
            ]);
        });
    }
};
