<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
    public function deleted(Post $post)
    {
        $post->comments()->forceDelete();
    }
}
