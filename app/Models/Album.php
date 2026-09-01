<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use SoftDeletes;

    public const STATUSES = ['draft', 'published'];

    protected $fillable = ['name', 'slug', 'description', 'cover', 'category', 'album_date', 'status'];

    protected function casts(): array
    {
        return [
            'album_date' => 'date',
        ];
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class)->orderBy('order');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function getCoverUrlAttribute(): ?string
    {
        if (! $this->cover) {
            return null;
        }

        return str_starts_with($this->cover, 'http://') || str_starts_with($this->cover, 'https://')
            ? $this->cover
            : asset('storage/'.$this->cover);
    }
}
