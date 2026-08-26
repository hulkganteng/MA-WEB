<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Download extends Model
{
    use SoftDeletes;

    public const STATUSES = ['draft', 'published'];

    protected $fillable = [
        'name', 'slug', 'download_category_id', 'file', 'file_name', 'file_size',
        'description', 'publish_date', 'downloads', 'status',
    ];

    protected function casts(): array
    {
        return ['publish_date' => 'date'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(DownloadCategory::class, 'download_category_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
