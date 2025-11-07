<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /** Mass assignable */
    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'address',
        'user_id',
        'password',
    ];

    /** Hidden fields for arrays */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /** Casts */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /** Relationship: user has many photos */
    public function photos()
    {
        return $this->hasMany(Photo::class)->orderBy('created_at');
    }
}
