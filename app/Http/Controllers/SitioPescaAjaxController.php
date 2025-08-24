<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitioPescaAjaxController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index(Request $request)
    {
        $resp = $this->apiService->get('/sitios-pesca', $request->query());
        return response()->json($resp->json(), $resp->status());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'captura_id' => ['required', 'integer'],
            'nombre' => ['nullable', 'string'],
            'latitud' => ['nullable'],
            'longitud' => ['nullable'],
        ]);

        // Validate uniqueness of captura_id
        $existing = $this->apiService->get('/sitios-pesca', ['captura_id' => $data['captura_id']]);
        if ($existing->successful() && !empty($existing->json())) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'captura_id' => ['Ya existe un sitio para esta captura.'],
                ],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $resp = $this->apiService->post('/sitios-pesca', $data);
        return response()->json($resp->json(), $resp->status());
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'captura_id' => ['required', 'integer'],
            'nombre' => ['nullable', 'string'],
            'latitud' => ['nullable'],
            'longitud' => ['nullable'],
        ]);

        $resp = $this->apiService->put("/sitios-pesca/{$id}", $data);
        return response()->json($resp->json(), $resp->status());
    }
}

