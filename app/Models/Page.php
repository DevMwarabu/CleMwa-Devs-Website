<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['title', 'slug', 'content', 'meta_description', 'is_published', 'layout'])]
class Page extends Model
{
    use HasUuids;
    //
}
