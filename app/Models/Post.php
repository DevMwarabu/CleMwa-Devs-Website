<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Post extends Model
{
    use HasUuids;

    protected $guarded = [];

    protected $casts = [
        'tags' => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
