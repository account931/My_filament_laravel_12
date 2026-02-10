<?php

// Table booking_bookings, holds all bookings

namespace App\Models\Booking;

use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Eloquent\Factories\HasFactory; //Factory traithas been introduced in Laravel v8.
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // for scope
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;  // Laravel Audit

class BookingBooking extends Model implements Auditable  // Laravel Audit
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    // //Factory trait has been introduced in Laravel v8.
    use SoftDeletes;   // Laravel Audit

    private $start_time;

    private $end_time;

    // protected $appends = ['location_json']; //ells Eloquent to automatically include a custom accessor (getLocationJsonAttribute) in the model's array and JSON representations.

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'room_id',
        'user_id',
        'username',
        'start_time',
        'end_time',
        'password_to_delete',
        'total_hours',
        'total_price',
        'status',
    ];

    // Hide sensitive attributes from JSON / API responses
    protected $hidden = [
        'password_to_delete',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'total_price' => 'decimal:2',
        // 'password' => 'hashed',  //hash password (we use in Controller =>  Hash::make($request->booking_password))
    ];

    /**
     * A booking belongs to a room
     */
    public function room()
    {
        return $this->belongsTo(BookingRoom::class);
    }

    /**
     * A booking belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if booking overlaps with a time range
     */
    public function overlaps(Carbon $start, Carbon $end): bool
    {
        return $this->start_time < $end && $this->end_time > $start;
    }

    // When the model is in a subfolder, Laravel sometimes needs an explicit factory method in the model
    protected static function newFactory(): \Database\Factories\BookingBookingFactory
    {
        return \Database\Factories\BookingBookingFactory::new();
    }
}
