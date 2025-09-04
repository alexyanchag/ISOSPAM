<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class HomeViewShowsPersonaTest extends TestCase
{
    public function test_home_displays_persona_when_logged_in(): void
    {
        Session::start();
        Session::put('persona', [
            'nombres' => 'John',
            'apellidos' => 'Doe',
            'email' => 'john@example.com',
        ]);

        $response = $this
            ->withoutMiddleware(\App\Http\Middleware\EnsureLoggedIn::class)
            ->get('/');

        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertSee('john@example.com');
        $response->assertDontSee('No has iniciado sesión.');
    }
}
