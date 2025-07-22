<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Client\PendingRequest;

class ApiService
{
    /**
     * Base URL for API requests.
     */
    protected string $baseUrl = 'http://186.46.31.211:9090/isospam';

    /**
     * Perform login and store token in the session.
     */
    public function login(array $credentials)
    {
        $response = Http::post($this->baseUrl . '/login', $credentials);

        if ($response->successful()) {
            $json = $response->json();
            Session::put('user', $json['persona'] ?? null);
            Session::put('token', $json['access_token'] ?? null);
        }

        return $response;
    }

    /**
     * Create a request instance with the authorization token when available.
     */
    protected function withToken(): PendingRequest
    {
        $request = Http::baseUrl($this->baseUrl);

        if (Session::has('token')) {
            $request = $request->withToken(Session::get('token'));
        }

        return $request;
    }

    public function get(string $url, array $query = [])
    {
        return $this->withToken()->get($url, $query);
    }

    public function post(string $url, array $data = [])
    {
        return $this->withToken()->post($url, $data);
    }

    public function put(string $url, array $data = [])
    {
        return $this->withToken()->put($url, $data);
    }

    public function delete(string $url, array $data = [])
    {
        return $this->withToken()->delete($url, $data);
    }
}
