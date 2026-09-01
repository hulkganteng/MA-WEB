<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use SoftDeletes;

    public const TYPES = ['guru', 'tendik'];

    protected $fillable = [
        'name', 'slug', 'type', 'position', 'subject', 'education',
        'photo', 'bio', 'order', 'is_active', 'is_public',
        'is_in_structure', 'structure_parent_id', 'structure_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_public' => 'boolean',
            'is_in_structure' => 'boolean',
        ];
    }

    public function scopePublic($query)
    {
        return $query->where('is_active', true)->where('is_public', true);
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'structure_parent_id')->orderBy('structure_order');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'structure_parent_id');
    }
}
