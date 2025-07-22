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

    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }
}
