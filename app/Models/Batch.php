<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $table = 'batches';

    public function orders()
    {
        return $this->hasManyThrough(Order::class, BatchOrder::class);
    }
}
