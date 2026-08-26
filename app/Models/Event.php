<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    public const STATUSES = ['draft', 'published'];
    public const CATEGORIES = ['akademik', 'kegiatan', 'ujian', 'libur', 'rapat', 'lomba'];

    protected $fillable = [
        'title', 'slug', 'description', 'cover', 'location',
        'start_date', 'end_date', 'start_time', 'end_time', 'category', 'status', 'author_id',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('end_date', '>=', now()->toDateString());
    }

    public function getIsUpcomingAttribute(): bool
    {
        return ($this->end_date ?? $this->start_date) >= now()->toDateString();
    }
}
