<?php

namespace Tests\Feature\Http\Controllers;

use App\Events\Subscribed;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use App\Mail\Subscribed as SubscribedMailable;
use App\Notifications\Subscribed as SubscribedNotification;

class SubscribeControllerTest extends TestCase
{
    public function testUserSubscribeBlog()
    {
        Mail::fake();
        Notification::fake();
        Event::fake();

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

        Mail::assertQueued(SubscribedMailable::class);
        Notification::assertSentTo($blog->user, SubscribedNotification::class);
        Event::assertDispatched(Subscribed::class);
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
