<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasUuids;

    protected $guarded = [];

    protected $casts = [
        'tags' => 'array',
        'requires_quote' => 'boolean',
        'gallery' => 'array',
        'technologies' => 'array',
        'features_delivered' => 'array',
        'stats' => 'array',
        'is_featured' => 'boolean',
        'completion_date' => 'date',
        'links' => 'array',
    ];
}
