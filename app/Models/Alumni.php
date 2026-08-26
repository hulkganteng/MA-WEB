<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alumni extends Model
{
    use SoftDeletes;

    protected $table = 'alumni';

    public const STATUSES = ['pending', 'verified', 'hidden'];

    protected $fillable = [
        'name', 'slug', 'graduation_year', 'university', 'major', 'occupation',
        'company', 'photo', 'testimonial', 'status', 'is_public', 'order',
    ];

    protected function casts(): array
    {
        return ['is_public' => 'boolean'];
    }

    public function scopePublic($query)
    {
        return $query->where('status', 'verified')->where('is_public', true);
    }
}
