<?php

namespace Tests\Feature\Http\Controller\Auth;

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\ValidateSignature;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class EmailVerificationControllerTest extends TestCase
{
    public function testVerifyEmail()
    {
        $user = User::factory()->unverified()->create();

        $this->actingAs($user)
            ->withoutMiddleware(ValidateSignature::class)
            ->get(route('verification.verify',[
                'id' => $user->getkey(),
                'hash' => sha1($user->getEmailForVerification())
            ]))->assertRedirect(RouteServiceProvider::HOME);

        $this->assertTrue($user->hasVerifiedEmail());
    }

    public function testReturnsVerifyEmailViewForUnverifiedUser()
    {
        $this->withoutMiddleware(Authenticate::class)
            ->get(route('verification.notice'))
            ->assertOk()
            ->assertViewIs('auth.verify-email');
    }

    public function testSendEmailForEmailVerification()
    {
        Notification::fake();
        $user = User::factory()->unverified()->create();
        $this->actingAs($user)
            ->post(route('verification.send'))
            ->assertRedirect();
        Notification::assertSentTo($user, VerifyEmail::class);
    }

}
