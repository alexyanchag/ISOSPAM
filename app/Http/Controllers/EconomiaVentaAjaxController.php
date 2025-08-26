<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class EconomiaVentaAjaxController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index(Request $request)
    {
        $capturaId = $request->query('captura_id');
        $resp = $this->apiService->get('/economia-ventas', ['captura_id' => $capturaId]);
        return response()->json($resp->json(), $resp->status());
    }

    public function show(string $id)
    {
        $resp = $this->apiService->get("/economia-ventas/{$id}");
        return response()->json($resp->json(), $resp->status());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vendido_a' => ['required', 'string'],
            'destino' => ['required', 'string'],
            'precio' => ['required', 'numeric'],
            'unidad_venta_id' => ['required', 'integer'],
            'captura_id' => ['required', 'integer'],
        ]);
        $resp = $this->apiService->post('/economia-ventas', $data);
        return response()->json($resp->json(), $resp->status());
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'vendido_a' => ['required', 'string'],
            'destino' => ['required', 'string'],
            'precio' => ['required', 'numeric'],
            'unidad_venta_id' => ['required', 'integer'],
            'captura_id' => ['required', 'integer'],
        ]);
        $resp = $this->apiService->put("/economia-ventas/{$id}", $data);
        return response()->json($resp->json(), $resp->status());
    }
}
