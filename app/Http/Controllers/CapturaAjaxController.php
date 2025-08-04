<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CapturaAjaxController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index(Request $request)
    {
        $resp = $this->apiService->get('/capturas-viaje', [
            'viaje_id' => $request->query('viaje_id'),
        ]);

        return response()->json($resp->json(), $resp->status());
    }

    public function show(string $id)
    {
        $resp = $this->apiService->get("/capturas/{$id}");

        return response()->json($resp->json(), $resp->status());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_comun' => ['nullable', 'string'],
            'numero_individuos' => ['nullable', 'integer'],
            'peso_estimado' => ['nullable', 'numeric'],
            'peso_contado' => ['nullable', 'numeric'],
            'especie_id' => ['nullable', 'integer'],
            'viaje_id' => ['required', 'integer'],
            'es_incidental' => ['nullable', 'boolean'],
            'es_descartada' => ['nullable', 'boolean'],
            'tipo_numero_individuos' => ['nullable', 'string'],
            'tipo_peso' => ['nullable', 'string'],
            'estado_producto' => ['nullable', 'string'],
        ]);

        $resp = $this->apiService->post('/capturas', $data);

        return response()->json($resp->json(), $resp->status());
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombre_comun' => ['nullable', 'string'],
            'numero_individuos' => ['nullable', 'integer'],
            'peso_estimado' => ['nullable', 'numeric'],
            'peso_contado' => ['nullable', 'numeric'],
            'especie_id' => ['nullable', 'integer'],
            'viaje_id' => ['required', 'integer'],
            'es_incidental' => ['nullable', 'boolean'],
            'es_descartada' => ['nullable', 'boolean'],
            'tipo_numero_individuos' => ['nullable', 'string'],
            'tipo_peso' => ['nullable', 'string'],
            'estado_producto' => ['nullable', 'string'],
        ]);

        $resp = $this->apiService->put("/capturas/{$id}", $data);

        return response()->json($resp->json(), $resp->status());
    }

    public function destroy(string $id)
    {
        $resp = $this->apiService->delete("/capturas/{$id}");

        return response()->json($resp->json(), $resp->status());
    }
}

