<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use HasFactory, Searchable;

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

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
