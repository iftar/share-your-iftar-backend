<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharityUser extends Model
{
    protected $table = 'charity_users';

    protected $fillable = [
        'charity_id',
        'user_id',
    ];

    protected $casts = [
        'charity_id' => 'integer',
        'user_id'    => 'integer',
    ];

    public function charity()
    {
        return $this->belongsTo(Charity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
