<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlumniSubmission extends Model
{
    public const STATUSES = ['pending', 'approved', 'rejected'];

    protected $fillable = [
        'name', 'graduation_year', 'email', 'phone', 'university', 'major',
        'occupation', 'company', 'photo', 'testimonial', 'status', 'ip_address',
    ];
}
