<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Services\ApiService;

class LoginController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }
    public function showLoginForm(): View
    {
        return view('login');
    }

    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        Session::forget('current_role_id');

        $response = $this->apiService->login($data);

        if ($response->successful()) {
            $json = $response->json();
            $roles = $json['roles'] ?? [];
            Session::put('roles', $roles);
            if ($roles !== []) {
                Session::put('current_role_id', $roles[0]['id'] ?? null);
            }

            return redirect('/');
        }

        return back()->withErrors(['username' => 'Credenciales incorrectas'])->withInput();
    }

    public function selectRole(Request $request): RedirectResponse
    {
        $id = (int) $request->input('id');
        $roles = session('roles', []);
        $exists = collect($roles)->contains(fn ($r) => ($r['id'] ?? null) === $id);

        if ($exists) {
            Session::put('current_role_id', $id);
        }

        return redirect('/');
    }

    public function logout(): RedirectResponse
    {
        Session::flush();
        return redirect('/login');
    }
}
