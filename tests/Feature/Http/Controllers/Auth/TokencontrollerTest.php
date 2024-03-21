<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Enums\Ability;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TokencontrollerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testReturnsCreateViewForToken()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('tokens.create'))
            ->assertOk()
            ->assertViewIs('tokens.create');
    }

    public function testCreateToken()
    {
        $user = User::factory()->create();

        $ablities = $this->faker->randomElements(
            collect(Ability::cases())->pluck('value')->toArray()
        );

        $name = $this->faker->word();

        $this->actingAs($user)
            ->post(route('tokens.store'), [
                'name' => $name,
                'abilities' => $ablities
            ])->assertRedirect();

        $this->assertDatabaseHas('personal_access_tokens', [
            'name' => $name,
            'abilities' => json_encode($ablities)
        ]);
    }

    public function testDeleteToken()
    {
        $user = User::factory()->create();

        $name = $this->faker->word();
        $user->createToken($name);

        $token = $user->tokens()->first();

        $this->actingAs($user)
            ->delete(route('tokens.destroy', $token))
            ->assertRedirect();

        $this->assertDatabaseMissing('personal_access_tokens', ['name' => $name]);
    }
}
