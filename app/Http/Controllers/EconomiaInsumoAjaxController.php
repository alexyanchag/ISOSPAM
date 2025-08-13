<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class EconomiaInsumoAjaxController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index(Request $request)
    {
        $viajeId = $request->query('viaje_id');
        $resp = $this->apiService->get("/economia-insumo-viaje/{$viajeId}");
        return response()->json($resp->json(), $resp->status());
    }

    public function show(string $id)
    {
        $resp = $this->apiService->get("/economia-insumo/{$id}");
        return response()->json($resp->json(), $resp->status());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'viaje_id' => ['required', 'integer'],
            'unidad_insumo_id' => ['required', 'integer'],
            'tipo_insumo_id' => ['required', 'integer'],
            'cantidad' => ['required', 'numeric'],
        ]);
        $resp = $this->apiService->post('/economia-insumo', $data);
        return response()->json($resp->json(), $resp->status());
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'viaje_id' => ['required', 'integer'],
            'unidad_insumo_id' => ['required', 'integer'],
            'tipo_insumo_id' => ['required', 'integer'],
            'cantidad' => ['required', 'numeric'],
        ]);
        $resp = $this->apiService->put("/economia-insumo/{$id}", $data);
        return response()->json($resp->json(), $resp->status());
    }

    public function destroy(string $id)
    {
        $resp = $this->apiService->delete("/economia-insumo/{$id}");
        return response()->json($resp->json(), $resp->status());
    }
}

