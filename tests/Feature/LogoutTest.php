<?php

namespace Tests\Feature;

use App\Http\Middleware\IsInstalled;
use App\User;
use App\Utils\BusinessUtil;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function test_post_logout_invalidates_the_session_and_redirects_to_login(): void
    {
        $user = new User;
        $user->id = 1;

        $businessUtil = Mockery::mock(BusinessUtil::class);
        $businessUtil->shouldReceive('activityLog')->once()->with($user, 'logout');
        $this->app->instance(BusinessUtil::class, $businessUtil);

        $this->actingAs($user);

        $response = $this->withoutMiddleware(IsInstalled::class)
            ->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
        $response->assertSessionMissing(Auth::guard('web')->getName());

        $this->get('/login')->assertOk();
    }
}
