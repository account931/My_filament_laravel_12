<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;  // Spatie Permission
use OwenIt\Auditing\Contracts\Auditable; // Sanctum
use Spatie\Permission\Traits\HasRoles;  // Laravel Audit

class User extends Authenticatable implements Auditable, FilamentUser  // Laravel Audit
{
    // Spatie Permission
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles; // Sanctum
    use \OwenIt\Auditing\Auditable;   // Laravel Audit

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'description',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // filament staff
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
        // return str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
    }

    // Do not use
    /*
    public function audits()
    {
        return $this->hasMany(\App\Models\Audit::class, 'user_id');
    }
    */
}
