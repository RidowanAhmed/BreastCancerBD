<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
       'user_id', 'phone_num', 'position', 'short_address', 'long_address'
    ];

    protected $casts = [
        'position' => 'array',
    ];
}
