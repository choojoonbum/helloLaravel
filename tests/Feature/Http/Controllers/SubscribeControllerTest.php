<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscribeControllerTest extends TestCase
{
    public function testUserSubscribeBlog()
    {
        $user = User::factory()->create();
        $blog = Blog::factory()->create();

        $this->actingAs($user)
            ->post(route('subscribe'), [
                'blog_id' => $blog->id
            ])->assertRedirect();

        $this->assertDatabaseHas('blog_user', [
            'user_id' => $user->id,
            'blog_id' => $blog->id
        ]);
    }

    public function testUserUnsubscribeBlog()
    {
        $user = User::factory()->create();

        $blog = Blog::factory()->hasAttached(
            factory: $user,
            relationship: 'subscribers'
        )->create();

        $this->actingAs($user)
            ->post(route('unsubscribe'), [
                'blog_id' => $blog->id
            ])->assertRedirect();

        $this->assertDatabaseMissing('blog_user', [
            'user_id' => $user->id,
            'blog_id' => $blog->id
        ]);
    }
}
