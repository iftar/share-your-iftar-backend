<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $statuses = [
        'approved' => 'Approved',
        'disabled' => 'Disabled'
    ];

    protected $types = [
        'user'    => 'User',
        'charity' => 'Charity User'
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'type',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function pickups()
    {
        return $this->hasMany(Pickup::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    public function getFullNameAttribute()
    {
        return "$this->first_name $this->last_name";
    }
}
