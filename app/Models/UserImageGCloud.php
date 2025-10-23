<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static \App\Models\User create(array $attributes = [])
 */
class UserImageGCloud extends Model
{
    protected $fillable = ['user_id', 'path'];

    protected $table = 'user_images_gcloud';

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
