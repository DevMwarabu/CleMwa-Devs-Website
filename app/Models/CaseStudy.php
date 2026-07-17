<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseStudy extends Model
{
    protected $guarded = [];

    protected $casts = [
        'technologies' => 'array',
        'is_featured' => 'boolean',
    ];
}

