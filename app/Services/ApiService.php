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
    protected string $baseUrl = 'http://179.49.62.100:9090/isospam';

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
            Session::put('roles', $json['roles'] ?? []);
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

    public function postFiles(string $url, array $files, array $data = [])
    {
        $request = $this->withToken()->asMultipart();

        foreach ($files as $name => $file) {
            $request = $request->attach(
                is_string($name) ? $name : 'archivos',
                fopen($file->getRealPath(), 'r'),
                $file->getClientOriginalName()
            );
        }

        $response = $request->post($url, $data);

        if ($response->failed()) {
            $response->throw();
        }

        return $response;
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
