<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes;

    public const STATUSES = ['draft', 'published'];

    protected $fillable = [
        'title', 'slug', 'url', 'provider', 'thumbnail', 'category',
        'description', 'video_date', 'status',
    ];

    protected function casts(): array
    {
        return ['video_date' => 'date'];
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function getEmbedUrlAttribute(): ?string
    {
        if ($this->provider === 'youtube') {
            $id = $this->extractYouTubeId();

            return $id ? 'https://www.youtube.com/embed/'.$id : null;
        }

        return $this->url;
    }

    public function extractYouTubeId(): ?string
    {
        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([\w-]{11})/', $this->url, $m)) {
            return $m[1];
        }

        return null;
    }

    public function getThumbnailAttribute(?string $value): ?string
    {
        if ($value) {
            return str_starts_with($value, 'http://') || str_starts_with($value, 'https://')
                ? $value
                : asset('storage/'.$value);
        }
        if ($this->provider === 'youtube') {
            $id = $this->extractYouTubeId();

            return $id ? 'https://i.ytimg.com/vi/'.$id.'/hqdefault.jpg' : null;
        }

        return null;
    }
}
