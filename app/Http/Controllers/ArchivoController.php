<?php

namespace App\Http\Controllers;

use App\Services\ApiService;

class ArchivoController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function show(string $path)
    {
        $response = $this->apiService->getFile($path);

        $headers = array_map(fn ($v) => $v[0], $response->headers());

        return response($response->body(), $response->status())
            ->withHeaders($headers);
    }
}

