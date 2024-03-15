<?php

namespace App\Models;

use App\Castables\Link;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use HasFactory, Prunable;

    protected $fillable = [
        'original_name',
        'name'
    ];

    protected $casts = [
        'link' => Link::class
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function prunable()
    {
        return static::whereNull('post_id');
    }

    public function pruning()
    {
        Storage::disk('public')->delete($this->name);
    }
}
