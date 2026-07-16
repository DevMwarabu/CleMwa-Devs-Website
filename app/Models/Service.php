<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Service extends Model
{
    use HasUuids;

    protected $fillable = [
        'slug',
        'title',
        'description',
        'content',
        'icon_svg',
        'color_theme',
        'image_url',
        'delay'
    ];
}
