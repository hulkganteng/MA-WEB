<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Extracurricular extends Model
{
    use SoftDeletes;

    public const STATUSES = ['active', 'inactive'];

    protected $fillable = [
        'name', 'slug', 'icon', 'photo', 'description', 'mentor', 'schedule',
        'achievements', 'status', 'order',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
