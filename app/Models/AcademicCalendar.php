<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicCalendar extends Model
{
    use SoftDeletes;

    public const CATEGORIES = ['akademik', 'ujian', 'libur', 'kegiatan', 'rapat', 'lomba'];

    protected $fillable = ['title', 'slug', 'category', 'start_date', 'end_date', 'description', 'academic_year'];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }
}
