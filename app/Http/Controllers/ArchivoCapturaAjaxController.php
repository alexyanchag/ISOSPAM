<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class ArchivoCapturaAjaxController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index(int $capturaId)
    {
        $resp = $this->apiService->get("/capturas/{$capturaId}/archivos");

        return response()->json($resp->json(), $resp->status());
    }

    public function store(Request $request, int $capturaId)
    {
        $request->validate([
            'archivos' => ['required'],
            'archivos.*' => ['file'],
        ]);

        $files = $request->file('archivos');
        $files = is_array($files) ? $files : [$files];

        $resp = $this->apiService->postFiles(
            "/capturas/{$capturaId}/archivos-form",
            $files,
            $request->except('archivos')
        );

        return response()->json($resp->json(), $resp->status());
    }

    public function destroy(int $id)
    {
        $resp = $this->apiService->delete("/archivos/{$id}");

        return response()->json($resp->json(), $resp->status());
    }
}

