<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use SoftDeletes;

    public const TYPES = ['guru', 'tendik'];

    protected $fillable = [
        'name', 'slug', 'type', 'position', 'subject', 'education',
        'photo', 'bio', 'order', 'is_active', 'is_public',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_public' => 'boolean',
        ];
    }

    public function scopePublic($query)
    {
        return $query->where('is_active', true)->where('is_public', true);
    }
}
