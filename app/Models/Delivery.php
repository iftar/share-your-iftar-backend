<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'deliveries';

    protected $fillable = [
        'user_id',
        'pickup_id',
        'notes,'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pickup()
    {
        return $this->belongsTo(Pickup::class);
    }

    public function status()
    {
        return $this->hasOne(Status::class);
    }
}
