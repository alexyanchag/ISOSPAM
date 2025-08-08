<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class ObservadorViajeAjaxController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index(Request $request)
    {
        $resp = $this->apiService->get('/observadores-viaje', [
            'viaje_id' => $request->query('viaje_id'),
        ]);

        return response()->json($resp->json(), $resp->status());
    }

    public function show(string $id)
    {
        $resp = $this->apiService->get("/observadores-viaje/{$id}");

        return response()->json($resp->json(), $resp->status());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'viaje_id' => ['required', 'integer'],
            'tipo_observador_id' => ['required', 'integer'],
            'persona_idpersona' => ['required', 'integer'],
        ]);

        $resp = $this->apiService->post('/observadores-viaje', $data);

        return response()->json($resp->json(), $resp->status());
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'viaje_id' => ['required', 'integer'],
            'tipo_observador_id' => ['required', 'integer'],
            'persona_idpersona' => ['required', 'integer'],
        ]);

        $resp = $this->apiService->put("/observadores-viaje/{$id}", $data);

        return response()->json($resp->json(), $resp->status());
    }

    public function destroy(string $id)
    {
        $resp = $this->apiService->delete("/observadores-viaje/{$id}");

        return response()->json($resp->json(), $resp->status());
    }
}

