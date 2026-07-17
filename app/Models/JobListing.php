<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class JobListing extends Model
{
    use HasUuids;

    protected $guarded = [];

    protected $casts = [
        'requirements' => 'array',
        'is_active' => 'boolean',
        'posted_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
