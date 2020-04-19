<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchOrder extends Model
{
    protected $table = 'batch_orders';

    protected $fillable = [
        'batch_id',
        'order_id',
    ];

    protected $casts = [
        'batch_id' => 'integer',
        'order_id' => 'date',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
