<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address_line_1',
        'address_line_2',
        'town',
        'county',
        'post_code',
        'quantity_child',
        'quantity_adult',
        'notes',
        'required_at',
    ];

    protected $casts = [
        'required_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pickup()
    {
        return $this->hasOne(Pickup::class);
    }

    public function status()
    {
        return $this->hasOne(Status::class);
    }

    public function getFullNameAttribute()
    {
        return "$this->first_name $this->last_name";
    }
}
