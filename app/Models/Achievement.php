<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Achievement extends Model
{
    use SoftDeletes;

    public const LEVELS = ['madrasah', 'kecamatan', 'kabupaten', 'provinsi', 'nasional', 'internasional'];

    protected $fillable = [
        'title', 'slug', 'participant', 'category', 'level', 'organizer', 'rank',
        'achieved_date', 'year', 'description', 'cover', 'status', 'author_id',
    ];

    protected function casts(): array
    {
        return ['achieved_date' => 'date'];
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
