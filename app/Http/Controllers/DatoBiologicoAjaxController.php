<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class DatoBiologicoAjaxController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index(Request $request)
    {
        $resp = $this->apiService->get('/datos-biologicos', [
            'captura_id' => $request->query('captura_id'),
        ]);

        return response()->json($resp->json(), $resp->status());
    }

    public function show(string $id)
    {
        $resp = $this->apiService->get("/datos-biologicos/{$id}");

        return response()->json($resp->json(), $resp->status());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'captura_id' => ['required', 'integer'],
            'unidad_longitud_id' => ['nullable', 'integer'],
            'longitud' => ['nullable', 'numeric'],
            'peso' => ['nullable', 'numeric'],
            'sexo' => ['nullable', 'string'],
            'ovada' => ['nullable', 'boolean'],
            'estado_desarrollo_gonadal_id' => ['nullable', 'integer'],
        ]);

        $resp = $this->apiService->post('/datos-biologicos', $data);

        return response()->json($resp->json(), $resp->status());
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'captura_id' => ['required', 'integer'],
            'unidad_longitud_id' => ['nullable', 'integer'],
            'longitud' => ['nullable', 'numeric'],
            'peso' => ['nullable', 'numeric'],
            'sexo' => ['nullable', 'string'],
            'ovada' => ['nullable', 'boolean'],
            'estado_desarrollo_gonadal_id' => ['nullable', 'integer'],
        ]);

        $resp = $this->apiService->put("/datos-biologicos/{$id}", $data);

        return response()->json($resp->json(), $resp->status());
    }

    public function destroy(string $id)
    {
        $resp = $this->apiService->delete("/datos-biologicos/{$id}");

        return response()->json($resp->json(), $resp->status());
    }
}

