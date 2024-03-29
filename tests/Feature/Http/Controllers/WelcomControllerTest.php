<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\WelcomeController;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WelcomControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testReturnsWelcomeView()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(action(WelcomeController::class))
            ->assertOk()
            ->assertViewIs('welcome');
    }

    public function testReturnsWelcomeViewWithSubscriptions()
    {
        $subscriptions = Blog::factory()->hasPosts(5)->create();
        $user = User::factory()->hasAttached(
            factory: $subscriptions,
            relationship: 'subscriptions'
        )->create();

        $this->actingAs($user)
            ->get(action(WelcomeController::class))
            ->assertOk()
            ->assertViewIs('welcome');
    }

}
