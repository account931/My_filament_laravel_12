<?php

// Internal api controller to make requests to get free and booked slots, used in Vue
// api/rooms/1/calendar?date=2025-12-16

namespace App\Http\Controllers\Api\BookingApi;

// use App\Http\Controllers\Controller\Owner;
use App\Http\Controllers\Controller;
use App\Models\Booking\BookingBooking;
use App\Models\Booking\BookingRoom;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomCalendarController extends Controller
{
    // gets booking data for selected date and room
    public function index(Request $request, BookingRoom $room)
    {
        /*
        $request->validate([
            //'room_id' => ['required', 'integer', 'exists:booking_rooms,id'],  //Since  method receives BookingRoom $room via route model binding, Laravel does the validation automatically:If the {room} in the URL does not exist in the database, Laravel will return a 404 Not Found
            'date'    => ['required', 'date', 'after_or_equal:'.Carbon::now()->subDays(3)->format('Y-m-d')], // no older than 3 days
        ]);

        $date = Carbon::parse($request->date);

        // Working hours (can be moved to config)
        $dayStart = $date->copy()->startOfDay(); // 00:00:00;  //->setTime(8, 0);  //Working hours
        $dayEnd = $date->copy()->endOfDay(); // 23:59:59    //->setTime(22, 0);  //Working hours

        // Fetch bookings for that day
        $bookings = BookingBooking::where('room_id', $room->id)
            ->where('status', '!=', 'cancelled')// Booking::STATUS_CANCELLED
            ->where(function ($q) use ($dayStart, $dayEnd) {
                $q->where('start_time', '<', $dayEnd)
                    ->where('end_time', '>', $dayStart);
            })
            ->orderBy('start_time')
            ->get(['start_time', 'end_time']);

        // Generate slots (1-hour intervals)
        $slots = [];
        $cursor = $dayStart->copy();

        while ($cursor < $dayEnd) {
            $slotStart = $cursor->copy();
            $slotEnd = $cursor->copy()->addHour();

            $isBooked = $bookings->contains(function ($booking) use ($slotStart, $slotEnd) {
                return $booking->start_time < $slotEnd &&
                       $booking->end_time > $slotStart;
            });

            $slots[] = [
                'start' => $slotStart->format('Y-m-d H:i'),
                'end' => $slotEnd->format('Y-m-d H:i'),
                'status' => $isBooked ? 'booked' : 'free',
            ];

            $cursor->addHour();
        }

        return response()->json([
            'room_id' => $room->id,
            'room_name' => $room->name,   //  room name
            'date' => $date->toDateString(),
            'slots' => $slots,
        ]);
        */

        $request->validate([
            'date' => ['required', 'date', 'after_or_equal:'.Carbon::now()->subDays(3)->format('Y-m-d')],
        ]);

        $date = Carbon::parse($request->date);

        // Working day start/end (full day here, can adjust to working hours)
        $dayStart = $date->copy()->startOfDay();
        $dayEnd = $date->copy()->endOfDay();

        // Fetch bookings for that day
        $bookings = BookingBooking::where('room_id', $room->id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($q) use ($dayStart, $dayEnd) {
                $q->where('start_time', '<', $dayEnd)
                    ->where('end_time', '>', $dayStart);
            })
            ->orderBy('start_time')
            ->get(['id', 'start_time', 'end_time', 'username', 'status']);

        // Generate 1-hour slots
        $slots = [];
        $cursor = $dayStart->copy();

        while ($cursor < $dayEnd) {
            $slotStart = $cursor->copy();
            $slotEnd = $cursor->copy()->addHour();

            // Check if the slot is booked and get the booking
            $booking = $bookings->first(function ($b) use ($slotStart, $slotEnd) {
                return $b->start_time < $slotEnd && $b->end_time > $slotStart;
            });

            $slots[] = [
                'book_id' => $booking ? $booking->id : null,
                'start' => $slotStart->format('Y-m-d H:i'),
                'end' => $slotEnd->format('Y-m-d H:i'),
                'status' => $booking ? 'booked' : 'free',  // generate status dynamically for front-end
                // 'statusDB' => $booking ? $booking->status : null, // i.e 'confirmed', etc. works, but so far optional
                'user_name' => $booking ? $booking->username : null,
            ];

            $cursor->addHour();
        }

        return response()->json([
            'room_id' => $room->id,
            'room_name' => $room->name,
            'date' => $date->toDateString(),
            'slots' => $slots,
        ]);

    }

    // save new booking slot
    public function store(Request $request, BookingRoom $room)
    {
        // Validate input
        // no need to validate room_id,  //Since  method receives BookingRoom $room via route model binding, Laravel does the validation automatically:If the {room} in the URL does not exist in the database, Laravel will return a 404 Not Found
        $request->validate([
            'booking_date' => ['required', 'date', 'after_or_equal:'.Carbon::today()->format('Y-m-d')],  // can not book past dates
            'start_time' => ['required', 'date_format:H:i',
                // custom validation, u can t book today slot with  start time  in the past.
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->booking_date === Carbon::today()->toDateString()) {
                        $startDateTime = Carbon::parse($request->booking_date.' '.$value);

                        if ($startDateTime->isPast()) {
                            $fail('The start time cannot be in the past.');
                        }
                    }
                },
            ],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'user_name' => ['required', 'string'],
            'booking_password' => ['required', 'string', 'min:3'],
            // 'user_id'        => ['required', 'integer'], // optional
        ], [
            'booking_date.required' => 'Booking date is required',
            'booking_date.after_or_equal' => 'Booking date cannot be in the past',
            'start_time.required' => 'Start time is required',
            'end_time.required' => 'End time is required',
            'end_time.after' => 'End time must be after start time',
            'user_name.required' => 'User name is required',
            'booking_password.required' => 'Password is required',
            'booking_password.min' => 'Password must be at least 3 characters',
        ]);

        // $startTime = Carbon::parse($request->start_time);
        // $endTime = Carbon::parse($request->end_time);

        // Combine date and time into Carbon timestamps
        $startTimestamp = Carbon::parse($request->booking_date.' '.$request->start_time);
        $endTimestamp = Carbon::parse($request->booking_date.' '.$request->end_time);

        // Check if the slot overlaps with existing bookings
        $overlap = BookingBooking::where('room_id', $room->id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($q) use ($startTimestamp, $endTimestamp) {
                $q->where('start_time', '<', $endTimestamp)
                    ->where('end_time', '>', $startTimestamp);
            })
            ->exists();

        if ($overlap) {
            return response()->json([
                'message' => 'This time slot is already booked.',
            ], 409); // Conflict
        }

        // Create new booking
        $booking = BookingBooking::create([
            'room_id' => $room->id,
            'username' => $request->user_name, // Auth::user()->name,
            'start_time' => $startTimestamp,
            'end_time' => $endTimestamp,
            'password_to_delete' => $request->booking_password,
            'status' => 'confirmed', // or default status
        ]);

        return response()->json([
            'message' => 'Booking created successfully.',
            'booking' => $booking,
        ], 201);
    }
}
