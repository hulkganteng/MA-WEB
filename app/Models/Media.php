<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    protected $fillable = [
        'name', 'disk', 'path', 'mime_type', 'extension', 'size', 'type',
        'collection', 'alt', 'meta', 'mediable_type', 'mediable_id',
    ];

    protected function casts(): array
    {
        return [
            'meta' => 'array',
        ];
    }

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getUrlAttribute(): string
    {
        return $this->disk === 'public' ? asset('storage/'.$this->path) : $this->path;
    }
}
