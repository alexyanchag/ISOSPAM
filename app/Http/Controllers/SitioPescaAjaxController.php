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
            'latitud' => ['required', 'numeric'],
            'longitud' => ['required', 'numeric'],
            'profundidad' => ['required', 'numeric'],
            'unidad_profundidad_id' => ['required', 'integer'],
            'sitio_id' => ['required', 'integer'],
        ]);

        // Validate uniqueness of captura_id
        $existing = $this->apiService->get('/sitios-pesca', ['captura_id' => $data['captura_id']]);
        if ($existing->successful() && !empty($existing->json())) {
            return response()->json([
                'message' => 'Los datos proporcionados no son válidos.',
                'errors' => [
                    'captura_id' => ['Ya existe un sitio de pesca para esta captura.'],
                ],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $resp = $this->apiService->post('/sitios-pesca', [
            'captura_id' => $data['captura_id'],
            'nombre' => $data['nombre'] ?? null,
            'latitud' => $data['latitud'],
            'longitud' => $data['longitud'],
            'profundidad' => $data['profundidad'],
            'unidad_profundidad_id' => $data['unidad_profundidad_id'],
            'sitio_id' => $data['sitio_id'],
        ]);
        return response()->json($resp->json(), $resp->status());
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'captura_id' => ['required', 'integer'],
            'nombre' => ['nullable', 'string'],
            'latitud' => ['required', 'numeric'],
            'longitud' => ['required', 'numeric'],
            'profundidad' => ['required', 'numeric'],
            'unidad_profundidad_id' => ['required', 'integer'],
            'sitio_id' => ['required', 'integer'],
        ]);

        $resp = $this->apiService->put("/sitios-pesca/{$id}", [
            'captura_id' => $data['captura_id'],
            'nombre' => $data['nombre'] ?? null,
            'latitud' => $data['latitud'],
            'longitud' => $data['longitud'],
            'profundidad' => $data['profundidad'],
            'unidad_profundidad_id' => $data['unidad_profundidad_id'],
            'sitio_id' => $data['sitio_id'],
        ]);
        return response()->json($resp->json(), $resp->status());
    }
}

