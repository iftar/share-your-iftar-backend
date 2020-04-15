<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use App\Notifications\User\VerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    protected $statuses = [
        'approved' => 'Approved',
        'disabled' => 'Disabled'
    ];
    protected $types = [
        'user'             => 'User',
        'charity'          => 'Charity User',
        'collection-point' => 'Collection Point User'
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
        'tokens'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    public function getFullNameAttribute()
    {
        return "$this->first_name $this->last_name";
    }
}
