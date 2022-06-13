<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'cover',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'published_at',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'posts_categories');
    }
}
