<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncidentNote extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $note) {
            $note->created_at ??= now();
        });
    }

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
