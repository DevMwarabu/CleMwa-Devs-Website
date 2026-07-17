<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Product extends Model
{
    use HasUuids;
    protected $guarded = [];

    protected $casts = [
        'is_featured' => 'boolean',
        'rating' => 'decimal:1',
        'gallery' => 'array',
        'screenshots' => 'array',
        'platforms' => 'array',
        'features' => 'array',
        'modules' => 'array',
        'integrations' => 'array',
        'pricing_tiers' => 'array',
        'stats' => 'array',
        'faqs' => 'array',
        'documentation' => 'array',
        'testimonials' => 'array',
    ];
}
