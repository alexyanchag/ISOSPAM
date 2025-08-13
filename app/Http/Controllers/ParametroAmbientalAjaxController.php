<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class ParametroAmbientalAjaxController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index(Request $request)
    {
        $resp = $this->apiService->get('/parametros-ambientales', [
            'viaje_id' => $request->query('viaje_id'),
        ]);

        return response()->json($resp->json(), $resp->status());
    }

    public function show(string $id)
    {
        $resp = $this->apiService->get("/parametros-ambientales/{$id}");

        return response()->json($resp->json(), $resp->status());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'viaje_id' => ['required', 'integer'],
            'hora' => ['nullable'],
            'sondeo_ppt' => ['nullable', 'numeric'],
            'tsmp' => ['nullable', 'numeric'],
            'estado_marea_id' => ['nullable', 'integer'],
            'condicion_mar_id' => ['nullable', 'integer'],
            'oxigeno_mg_l' => ['nullable', 'numeric'],
        ]);

        $resp = $this->apiService->post('/parametros-ambientales', $data);

        return response()->json($resp->json(), $resp->status());
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'viaje_id' => ['required', 'integer'],
            'hora' => ['nullable'],
            'sondeo_ppt' => ['nullable', 'numeric'],
            'tsmp' => ['nullable', 'numeric'],
            'estado_marea_id' => ['nullable', 'integer'],
            'condicion_mar_id' => ['nullable', 'integer'],
            'oxigeno_mg_l' => ['nullable', 'numeric'],
        ]);

        $resp = $this->apiService->put("/parametros-ambientales/{$id}", $data);

        return response()->json($resp->json(), $resp->status());
    }

    public function destroy(string $id)
    {
        $resp = $this->apiService->delete("/parametros-ambientales/{$id}");

        return response()->json($resp->json(), $resp->status());
    }
}
