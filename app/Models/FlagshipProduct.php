<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlagshipProduct extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_live' => 'boolean',
        'links' => 'array',
    ];
}
