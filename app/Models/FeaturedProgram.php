<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeaturedProgram extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'description', 'icon', 'cover', 'highlights', 'status', 'order'];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
