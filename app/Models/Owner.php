<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder; //for scope
use App\Models\Venue;
use App\Events\OwnerCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Factories\HasFactory; //Factory traithas been introduced in Laravel v8.
use OwenIt\Auditing\Contracts\Auditable;  //Laravel Audit

class Owner extends Model implements Auditable  //Laravel Audit
{
	use HasFactory; ////Factory trait has been introduced in Laravel v8.
	use SoftDeletes;
    use \OwenIt\Auditing\Auditable;   //Laravel Audit
	
	 /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [  //for mass assignment in API
        'first_name',
		'last_name',
		'email',
		'phone',
		'location',
        'image'
    ];
	
	 /**
     * @var array<string, string>
     */
    protected $dispatchesEvents = [
        //'created'  => OwnerCreated::class,  //disabled
        //'updated'  => UserUpdated::class,
        //'deleting' => UserDeleting::class,
        //'deleted'  => UserDeleted::class,
    ];
	
	 /**
     * Scope a query to only include confirmed owners (local scope).
     */
    public function scopeConfirmed(Builder $query): void
    {
        $query->where('confirmed', '=', 1);
    }
	
	/**
     * Scope a query to only include owners created last year (local scope).
     */
	public function scopeCreatedAtLastYear($query)
    {
        return $query->where('created_at', '>=', now()->subYear());
    }
	
	/**
     * Accessor: get the user's first name
     *
     * @param  string  $value
     * @return string
     */
    public function getFirstNameAttribute($value)
    {
        return "<span style='color:red;font-size:0.7em;'>accessor</span> " . ucfirst($value);
    }

    /**
     * HasMany: get the venuess for the owner post.
     */
    public function venues() //: HasMany
    {
        return $this->hasMany(Venue::class);
    }

}
