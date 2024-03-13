<?php

namespace App\Models;

use GuzzleHttp\Psr7\FnStream;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'parent_id',
        'content'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id')
            ->withTrashed();
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')
            ->withTrashed();
    }

}
