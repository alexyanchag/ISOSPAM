<?php

namespace Tests\Unit;

use App\Services\ApiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class LoginClearsActiveRoleTest extends TestCase
{
    public function test_active_role_is_cleared_on_login(): void
    {
        Session::start();
        Session::put('active_role', ['menus' => ['old']]);

        Http::fake([
            'http://localhost:9090/isospam/login' => Http::response([
                'persona' => ['name' => 'User'],
                'access_token' => 'token',
                'roles' => [],
            ], 200),
        ]);

        $service = new ApiService();
        $service->login(['email' => 'a', 'password' => 'b']);

        $this->assertFalse(Session::has('active_role'));
        $this->assertSame([], Session::get('roles'));
    }
}
