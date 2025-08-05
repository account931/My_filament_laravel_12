<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;  // Laravel Audit

class Product extends Model implements Auditable  // Laravel Audit
{
    //
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;      // Laravel Audit

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'sku',
        'price',
        'discount_price',
        'stock',
        // 'category_id', // Uncomment if you add category foreign key later
        'image',
        'gallery',
        'is_active',
        'views',
        'details',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
