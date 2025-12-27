<?php

// Table booking_rooms, holds all rooms

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // for scope
// use Illuminate\Database\Eloquent\Factories\HasFactory; //Factory trait has been introduced in Laravel v8.
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;  // Laravel Audit

class BookingRoom extends Model implements Auditable  // Laravel Audit
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    // Factory trait has been introduced in Laravel v8.
    use SoftDeletes;

    protected $table = 'booking_rooms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'capacity',
        'price_per_hour',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price_per_hour' => 'decimal:2',
    ];

    // When the model is in a subfolder, Laravel sometimes needs an explicit factory method in the model
    protected static function newFactory(): \Database\Factories\BookingRoomFactory
    {
        return \Database\Factories\BookingRoomFactory::new();
    }

    /**
     * A room can have many bookings
     */
    public function bookings()
    {
        return $this->hasMany(BookingBooking::class);
    }

    /**
     * Scope for active rooms only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
