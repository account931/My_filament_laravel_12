<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;  // Laravel Audit

class Order extends Model implements Auditable  // Laravel Audit
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;      // Laravel Audit

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'address',
        'payment_method',
        'total_amount',
        'status',
        'stripe_session_id',
    ];

    protected $casts = [
        'stripe_session_id' => 'array',
    ];

    // An order belongs to a user (optional)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // An order has many order items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
