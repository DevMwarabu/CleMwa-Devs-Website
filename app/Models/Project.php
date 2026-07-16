<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Project extends Model
{
    use HasUuids;
    
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'content',
        'challenge',
        'solution',
        'results',
        'client_name',
        'industry',
        'project_type',
        'image_url',
        'tags',
        'requires_quote',
        'color_theme',
        'delay',
    ];

    protected $casts = [
        'tags' => 'array',
        'requires_quote' => 'boolean',
    ];
}
