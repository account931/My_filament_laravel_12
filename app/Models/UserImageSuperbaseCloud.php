<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static \App\Models\User create(array $attributes = [])
 */
class UserImageSuperbaseCloud extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'path', 'bucket_name', 'is_private_bucket'];

    protected $table = 'user_images_supabase';

    // Set default values for attributes
    protected $attributes = [
        'is_private_bucket' => false,
    ];

    // Cast to boolean automatically
    protected $casts = [
        'is_private_bucket' => 'boolean',
    ];

    /**
     * Get the user that owns the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
