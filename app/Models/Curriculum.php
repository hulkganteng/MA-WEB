<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Curriculum extends Model
{
    use SoftDeletes;

    protected $table = 'curriculums';

    protected $fillable = ['title', 'slug', 'academic_year', 'description', 'document', 'document_name', 'status', 'order'];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
