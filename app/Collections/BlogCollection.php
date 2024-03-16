<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;

class BlogCollection extends Collection
{
    public function feed()
    {
        return $this->flatMap->posts->sortByDesc('created_at');
    }
}
