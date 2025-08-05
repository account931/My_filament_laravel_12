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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->nullable(); // SEO-friendly URL
            $table->text('description')->nullable();
            $table->string('sku')->unique(); // stock keeping unit
            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable(); // Sale price
            $table->unsignedInteger('stock')->default(0);  // Total available units
            // $table->foreignId('category_id')->constrained()->onDelete('cascade')->nullable();
            $table->string('image')->nullable(); // Main image
            $table->json('gallery')->nullable(); // JSON array of image URLs
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('views')->default(0); // For analytics
            $table->json('details')->nullable(); // JSON array of image URLs
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
