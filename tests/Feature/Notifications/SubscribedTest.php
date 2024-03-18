<?php

namespace Tests\Feature\Notifications;

use App\Models\Blog;
use App\Models\User;
use App\Notifications\Subscribed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\AnonymousNotifiable;
use Tests\TestCase;
use App\Mail\Subscribed as SubscribedMailable;

class SubscribedTest extends TestCase
{
    use RefreshDatabase;

    public function testToMailReturnsSubscribedMailable(): void
    {
        $user = User::factory()->create();
        $blog = Blog::factory()->create();

        $notification = new Subscribed($user, $blog);

        $this->assertInstanceOf(SubscribedMailable::class, $notification->toMail($user));
        $this->assertInstanceOf(SubscribedMailable::class, $notification->toMail(new AnonymousNotifiable()));
    }

}
