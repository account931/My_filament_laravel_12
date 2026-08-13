<?php

// Uses Scout + Algolia Cloud

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;  // Laravel Audit
use OwenIt\Auditing\Contracts\Auditable; // Scout + Algolia Cloud

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property float|null $price
 * @property string|null $image
 */
class Product extends Model implements Auditable  // Laravel Audit
{
    //
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    use \OwenIt\Auditing\Auditable;
    use Searchable;

    // Laravel Audit
    use SoftDeletes; // Scout + Algolia Cloud

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

    // Scout + Algolia Cloud, define searchable fields
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
