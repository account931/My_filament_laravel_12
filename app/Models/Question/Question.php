<?php

// Table question

namespace App\Models\Question;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // for scope
// use Illuminate\Database\Eloquent\Factories\HasFactory; //Factory trait has been introduced in Laravel v8.
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;  // Laravel Audit

class Question extends Model implements Auditable  // Laravel Audit
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    // use SoftDeletes;

    protected $table = 'questions';

    protected $casts = [
        'answers' => 'array', // JSON → array
    ];

    protected $fillable = ['question', 'answers'];
}
