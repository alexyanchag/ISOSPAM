<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
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

        $response = Http::post('http://186.46.31.211:9090/isospam/login', $data);

        if ($response->successful()) {
            $json = $response->json();
            Session::put('user', $json['persona']);
            Session::put('token', $json['access_token']);
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
