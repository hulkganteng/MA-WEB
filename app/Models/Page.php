<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;

    public const STATUSES = ['draft', 'published'];

    protected $fillable = [
        'title', 'slug', 'cover', 'body', 'status', 'template', 'order',
        'author_id', 'seo_title', 'seo_description',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
