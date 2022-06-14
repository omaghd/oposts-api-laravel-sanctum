<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    const APPROVED     = 1;
    const NOT_APPROVED = 0;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'ip',
        'user_agent',
        'body',
        'post_id',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
