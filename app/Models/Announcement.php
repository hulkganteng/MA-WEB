<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use SoftDeletes;

    public const STATUSES = ['draft', 'published'];

    protected $fillable = [
        'title', 'slug', 'body', 'attachment', 'attachment_name', 'publish_date',
        'start_date', 'end_date', 'is_important', 'status', 'author_id',
        'seo_title', 'seo_description',
    ];

    protected function casts(): array
    {
        return [
            'is_important' => 'boolean',
            'publish_date' => 'date',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            $q->whereNull('end_date')->orWhere('end_date', '>=', now()->toDateString());
        });
    }
}
