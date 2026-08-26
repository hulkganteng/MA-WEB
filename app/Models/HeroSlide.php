<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeroSlide extends Model
{
    use SoftDeletes;

    public const STATUSES = ['draft', 'published'];

    protected $fillable = [
        'title',
        'subtitle',
        'tagline',
        'image',
        'button_text',
        'button_url',
        'secondary_button_text',
        'secondary_button_url',
        'order',
        'status',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function getImageUrlAttribute(): string
    {
        if (! $this->image) {
            return '';
        }

        return str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')
            ? $this->image
            : asset('storage/'.$this->image);
    }
}
