<?php

namespace Tests\Feature\Observers;

use App\Models\Post;
use App\Observers\PostObserver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostObserverTest extends TestCase
{
    use RefreshDatabase;

    public function testDeleteingAssociatedCommentsOnPostDeleteion()
    {
        $post = Post::factory()->hasComments()->create();
        $observer = new PostObserver();
        $observer->deleted($post);
        $this->assertCount(0, $post->comments);
    }

}
