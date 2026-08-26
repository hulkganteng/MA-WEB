<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationProgram extends Model
{
    use SoftDeletes;

    public const STATUSES = ['active', 'inactive'];

    protected $fillable = ['name', 'slug', 'description', 'category', 'icon', 'cover', 'status', 'order'];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
