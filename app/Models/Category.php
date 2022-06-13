<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
    ];

    protected $hidden = ['pivot'];

    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    public function child()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'posts_categories');
    }
}
