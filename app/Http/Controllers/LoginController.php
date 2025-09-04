<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Services\ApiService;

class LoginController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $response = $this->apiService->login($data);

        if ($response->successful()) {
            return redirect('/');
        }

        return back()->withErrors(['username' => 'Credenciales incorrectas'])->withInput();
    }

    public function selectRole(Request $request)
    {
        $id = $request->input('id');
        $roles = session('roles', []);
        $selected = collect($roles)->firstWhere('id', $id);

        if ($selected) {
            $menuResponse = $this->apiService->get('/rolmenu', ['idrol' => $id]);
            if ($menuResponse->successful()) {
                $selected['menu'] = $menuResponse->json();
            }

            session(['active_role' => $selected]);
        }

        return redirect('/');
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }
}
