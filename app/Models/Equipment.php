<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// for scope
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Factory traithas been introduced in Laravel v8.
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;  // Laravel Audit

class Equipment extends Model implements Auditable  // Laravel Audit
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    // //Factory trait has been introduced in Laravel v8.
    use SoftDeletes;   // Laravel Audit

    protected $table = 'equipments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'trademark_name',
    ];

    /**
     * @var array<string, string>
     */
    protected $dispatchesEvents = [
    ];

    /**
     * BelongsToMany: get venues that have equipment
     */
    public function venues(): BelongsToMany
    {
        return $this->belongsToMany(Venue::class);
    }
}
