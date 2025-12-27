<?php

// A booking conflicts if:
// existing.start < new.end  AND existing.end > new.start

/*
$conflict = Booking::where('room_id', $roomId)
    ->where('status', '!=', 'cancelled')
    ->where(function ($query) use ($startTime, $endTime) {
        $query->where('start_time', '<', $endTime)
              ->where('end_time', '>', $startTime);
    })
    ->exists();

if ($conflict) {
    throw ValidationException::withMessages([
        'time' => 'This room is already booked for the selected time.'
    ]);
}
*/

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
        Schema::create('booking_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')
                ->constrained('booking_rooms')
                ->cascadeOnDelete();

            $table->string('username');

            $table->string('password_to_delete');

            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete(); // not used

            $table->dateTime('start_time');   // booking start
            $table->dateTime('end_time');     // booking end

            $table->integer('total_hours')->nullable();   // calculated
            $table->decimal('total_price', 10, 2)->nullable();

            $table->enum('status', ['pending', 'confirmed', 'cancelled'])
                ->default('confirmed');

            $table->timestamps();
            $table->softDeletes(); // adds nullable deleted_at timestamp

            // Prevent double booking
            $table->index(['room_id', 'start_time', 'end_time']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_bookings');
    }
};
