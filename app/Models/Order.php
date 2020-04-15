<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'required_date',
        'quantity',
        'collection_point_id',
        'collection_point_time_slot_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address_line_1',
        'address_line_2',
        'town',
        'county',
        'post_code',
        'notes',
    ];

    protected $casts = [
        'required_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function batchOrder()
    {
        return $this->hasOne(BatchOrder::class);
    }

    public function batch()
    {
        return $this->batchOrder->batch;
    }

    public function getFullNameAttribute()
    {
        return "$this->first_name $this->last_name";
    }
}
