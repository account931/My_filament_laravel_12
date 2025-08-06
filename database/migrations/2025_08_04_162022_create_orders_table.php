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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // If you have users and want to link orders to them
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            $table->string('name');
            $table->string('email');
            $table->text('address');
            $table->string('payment_method');
            $table->decimal('total_amount', 10, 2); // e.g. 99999999.99 max
            $table->string('status')->default('pending'); // e.g. pending, processing, completed, cancelled
            $table->timestamp('paid_at')->nullable(); //
            $table->string('stripe_session_id')->nullable()->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
