<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Service extends Model
{
    use HasUuids;

    protected $guarded = [];

    protected $casts = [
        'key_features' => 'array',
        'business_benefits' => 'array',
        'is_featured' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }
}
