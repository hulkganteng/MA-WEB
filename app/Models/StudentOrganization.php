<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentOrganization extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'logo', 'description', 'structure', 'work_program',
        'activities', 'photo', 'status', 'order',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
