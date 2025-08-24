<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OneTimeLink extends Model
{
    protected $fillable = ['token', 'used'];
}
