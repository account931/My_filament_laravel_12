<?php

use App\Models\Booking\BookingBooking;
use App\Models\Booking\BookingRoom;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

/*
|--------------------------------------------------------------------------
| Room Calendar API Tests
|--------------------------------------------------------------------------
*/

it('returns free slots for a room and date', function () {
    $room = BookingRoom::factory()->create();
    $date = Carbon::tomorrow()->toDateString();

    $response = $this->getJson("/api/rooms/{$room->id}/calendar?date={$date}");

    $response
        ->assertOk()
        ->assertJsonStructure([
            'room_id',
            'room_name',
            'date',
            'slots' => [
                '*' => ['book_id', 'start', 'end', 'status', 'user_name'],
            ],
        ]);

    expect($response['slots'][0]['status'])->toBe('free');
});

it('marks slots as booked when a booking exists', function () {
    $room = BookingRoom::factory()->create();
    $date = Carbon::tomorrow();

    BookingBooking::factory()->create([
        'room_id' => $room->id,
        'start_time' => $date->copy()->setTime(10, 0),
        'end_time' => $date->copy()->setTime(11, 0),
        'username' => 'John',
        'status' => 'confirmed',
    ]);

    $response = $this->getJson(
        "/api/rooms/{$room->id}/calendar?date={$date->toDateString()}"
    );

    $slotStart = $date->copy()->setTime(10, 0)->format('Y-m-d H:i');

    $bookedSlot = collect($response['slots'])
        ->firstWhere('start', $slotStart);

    expect($bookedSlot['status'])->toBe('booked');
    expect($bookedSlot['user_name'])->toBe('John');
});

it('creates a booking successfully', function () {
    $room = BookingRoom::factory()->create();
    $date = Carbon::tomorrow()->toDateString();

    $response = $this->postJson("/api/rooms/{$room->id}/bookings", [
        'booking_date' => $date,
        'start_time' => '10:00',
        'end_time' => '11:00',
        'user_name' => 'Alice',
        'booking_password' => 'secret',
    ]);

    $response
        ->assertCreated()
        ->assertJson(['message' => 'Booking created successfully.']);

    $this->assertDatabaseHas('booking_bookings', [
        'room_id' => $room->id,
        'username' => 'Alice',
    ]);

    $booking = BookingBooking::first();
    expect(Hash::check('secret', $booking->password_to_delete))->toBeTrue();
});

it('prevents overlapping bookings', function () {
    $room = BookingRoom::factory()->create();
    $date = Carbon::tomorrow();

    BookingBooking::factory()->create([
        'room_id' => $room->id,
        'start_time' => $date->copy()->setTime(10, 0),
        'end_time' => $date->copy()->setTime(11, 0),
        'status' => 'confirmed',
    ]);

    $response = $this->postJson("/api/rooms/{$room->id}/bookings", [
        'booking_date' => $date->toDateString(),
        'start_time' => '10:30',
        'end_time' => '11:30',
        'user_name' => 'Bob',
        'booking_password' => '123',
    ]);

    $response
        ->assertStatus(409)
        ->assertJson(['message' => 'This time slot is already booked.']);
});

it('deletes a booking with correct password', function () {
    $booking = BookingBooking::factory()->create([
        'password_to_delete' => Hash::make('delete-me'),
    ]);

    $response = $this->deleteJson("/api/booking/{$booking->id}", [
        'password' => 'delete-me',
    ]);

    $response
        ->assertOk()
        ->assertJson(['message' => 'Booking deleted successfully']);

    $this->assertSoftDeleted($booking);
});

it('rejects deletion with invalid password', function () {
    $booking = BookingBooking::factory()->create([
        'password_to_delete' => Hash::make('correct'),
    ]);

    $response = $this->deleteJson("/api/booking/{$booking->id}", [
        'password' => 'wrong',
    ]);

    $response
        ->assertStatus(403)
        ->assertJson(['message' => 'Invalid password']);

    $this->assertDatabaseHas('booking_bookings', [
        'id' => $booking->id,
    ]);
});

it('validates required booking fields', function () {
    $room = BookingRoom::factory()->create();

    $this->postJson("/api/rooms/{$room->id}/bookings", [])
        ->assertStatus(422)
        ->assertJsonValidationErrors([
            'booking_date',
            'start_time',
            'end_time',
            'user_name',
            'booking_password',
        ]);
});
