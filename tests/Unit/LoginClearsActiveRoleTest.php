<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class LoginClearsActiveRoleTest extends TestCase
{
    public function test_active_role_is_cleared_on_login(): void
    {
        Session::start();
        Session::put('active_role', ['menus' => ['old']]);

        $roles = [
            ['id' => 1],
            ['id' => 2],
        ];

        Http::fake([
            'http://localhost:9090/isospam/login' => Http::response([
                'persona' => ['name' => 'User'],
                'access_token' => 'token',
                'roles' => $roles,
            ], 200),
        ]);

        $response = $this->post('/login', [
            'username' => 'a',
            'password' => 'b',
            '_token' => csrf_token(),
        ]);

        $response->assertRedirect('/');

        $this->assertSame($roles, Session::get('roles'));
        $this->assertSame($roles[0], Session::get('active_role'));
    }
}
