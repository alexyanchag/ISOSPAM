<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class TripulanteViajeAjaxController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index(Request $request)
    {
        $resp = $this->apiService->get('/tripulantes-viaje', [
            'viaje_id' => $request->query('viaje_id'),
        ]);

        return response()->json($resp->json(), $resp->status());
    }

    public function show(string $id)
    {
        $resp = $this->apiService->get("/tripulantes-viaje/{$id}");

        return response()->json($resp->json(), $resp->status());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'viaje_id' => ['required', 'integer'],
            'tipo_tripulante_id' => ['required', 'integer'],
            'persona_idpersona' => ['required', 'integer'],
            'organizacion_pesquera_id' => ['required', 'integer'],
        ]);

        $resp = $this->apiService->post('/tripulantes-viaje', $data);

        return response()->json($resp->json(), $resp->status());
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'viaje_id' => ['required', 'integer'],
            'tipo_tripulante_id' => ['required', 'integer'],
            'persona_idpersona' => ['required', 'integer'],
            'organizacion_pesquera_id' => ['required', 'integer'],
        ]);

        $resp = $this->apiService->put("/tripulantes-viaje/{$id}", $data);

        return response()->json($resp->json(), $resp->status());
    }

    public function destroy(string $id)
    {
        $resp = $this->apiService->delete("/tripulantes-viaje/{$id}");

        return response()->json($resp->json(), $resp->status());
    }
}
