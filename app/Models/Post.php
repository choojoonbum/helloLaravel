<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content'
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')
            ->withTrashed();
    }
}
