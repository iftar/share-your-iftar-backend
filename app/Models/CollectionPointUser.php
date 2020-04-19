<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionPointUser extends Model
{
    protected $table = 'collection_point_users';

    protected $fillable = [
        'collection_point_id',
        'user_id',
    ];

    protected $casts = [
        'collection_point_id' => 'integer',
        'user_id'             => 'integer',
    ];

    public function collectionPoint()
    {
        return $this->belongsTo(CollectionPoint::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
