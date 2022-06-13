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

    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    public function child()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
