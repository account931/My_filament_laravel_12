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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained()->onDelete('cascade');

            $table->unsignedBigInteger('product_id')->nullable(); // optional, if you track products
            $table->string('product_name');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);      // price per item
            $table->decimal('subtotal', 10, 2);   // quantity * price
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
