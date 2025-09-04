<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class LoginStoresRolesTest extends TestCase
{
    public function test_roles_and_tokens_are_stored_on_login(): void
    {
        Session::start();
        Session::put('current_role_id', 99);

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
        $this->assertSame($roles[0]['id'], Session::get('current_role_id'));
        $this->assertSame(['name' => 'User'], Session::get('persona'));
        $this->assertSame('token', Session::get('access_token'));
    }
}
