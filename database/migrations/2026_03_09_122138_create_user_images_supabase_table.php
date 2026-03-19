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
        Schema::create('user_images_supabase', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('path'); // Supabase Cloud Storage relative path or URL, e.g users/1/1773153374_malta.jpeg
            $table->string('bucket_name'); //
            $table->boolean('is_private_bucket')->default(false);  // private or public bucket
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_images_supabase');
    }
};
