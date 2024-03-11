<?php

namespace Http\Controller\Dashboard;

use App\Http\Middleware\RequirePassword;
use App\Models\User;
use Tests\TestCase;

class BlogControllerTest extends TestCase
{
    public function testReturnsBlogsDashboardViewForListOfBlog()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->withoutMiddleware(RequirePassword::class)
            ->get(route('dashboard.blogs'))
            ->assertOk()
            ->assertViewIs('dashboard.blogs');
    }
}
