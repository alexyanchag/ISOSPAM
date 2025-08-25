<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArtePescaAjaxController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index(Request $request)
    {
        $resp = $this->apiService->get('/artes-pesca', $request->query());
        return response()->json($resp->json(), $resp->status());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'captura_id' => ['required', 'integer'],
            'tipo_arte_id' => ['required', 'integer'],
            'lineas_madre' => ['nullable', 'integer'],
            'anzuelos' => ['nullable', 'integer'],
            'tamanio_anzuelo_pulg' => ['nullable', 'numeric'],
            'tipo_anzuelo_id' => ['nullable', 'integer'],
            'largo_red_m' => ['nullable', 'numeric'],
            'alto_red_m' => ['nullable', 'numeric'],
            'material_malla_id' => ['nullable', 'integer'],
            'ojo_malla_cm' => ['nullable', 'numeric'],
            'diametro' => ['nullable', 'numeric'],
            'carnadaviva' => ['nullable', 'boolean'],
            'especiecarnada' => ['nullable', 'string'],
        ]);

        $existing = $this->apiService->get('/artes-pesca', ['captura_id' => $data['captura_id']]);
        if ($existing->successful() && !empty($existing->json())) {
            return response()->json([
                'message' => 'Ya existe un arte de pesca para esta captura.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $resp = $this->apiService->post('/artes-pesca', [
            'captura_id' => $data['captura_id'],
            'tipo_arte_id' => $data['tipo_arte_id'],
            'lineas_madre' => $data['lineas_madre'] ?? null,
            'anzuelos' => $data['anzuelos'] ?? null,
            'tamanio_anzuelo_pulg' => $data['tamanio_anzuelo_pulg'] ?? null,
            'tipo_anzuelo_id' => $data['tipo_anzuelo_id'] ?? null,
            'largo_red_m' => $data['largo_red_m'] ?? null,
            'alto_red_m' => $data['alto_red_m'] ?? null,
            'material_malla_id' => $data['material_malla_id'] ?? null,
            'ojo_malla_cm' => $data['ojo_malla_cm'] ?? null,
            'diametro' => $data['diametro'] ?? null,
            'carnadaviva' => $data['carnadaviva'] ?? null,
            'especiecarnada' => $data['especiecarnada'] ?? null,
        ]);

        return response()->json($resp->json(), $resp->status());
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'captura_id' => ['required', 'integer'],
            'tipo_arte_id' => ['required', 'integer'],
            'lineas_madre' => ['nullable', 'integer'],
            'anzuelos' => ['nullable', 'integer'],
            'tamanio_anzuelo_pulg' => ['nullable', 'numeric'],
            'tipo_anzuelo_id' => ['nullable', 'integer'],
            'largo_red_m' => ['nullable', 'numeric'],
            'alto_red_m' => ['nullable', 'numeric'],
            'material_malla_id' => ['nullable', 'integer'],
            'ojo_malla_cm' => ['nullable', 'numeric'],
            'diametro' => ['nullable', 'numeric'],
            'carnadaviva' => ['nullable', 'boolean'],
            'especiecarnada' => ['nullable', 'string'],
        ]);

        $resp = $this->apiService->put("/artes-pesca/{$id}", [
            'captura_id' => $data['captura_id'],
            'tipo_arte_id' => $data['tipo_arte_id'],
            'lineas_madre' => $data['lineas_madre'] ?? null,
            'anzuelos' => $data['anzuelos'] ?? null,
            'tamanio_anzuelo_pulg' => $data['tamanio_anzuelo_pulg'] ?? null,
            'tipo_anzuelo_id' => $data['tipo_anzuelo_id'] ?? null,
            'largo_red_m' => $data['largo_red_m'] ?? null,
            'alto_red_m' => $data['alto_red_m'] ?? null,
            'material_malla_id' => $data['material_malla_id'] ?? null,
            'ojo_malla_cm' => $data['ojo_malla_cm'] ?? null,
            'diametro' => $data['diametro'] ?? null,
            'carnadaviva' => $data['carnadaviva'] ?? null,
            'especiecarnada' => $data['especiecarnada'] ?? null,
        ]);

        return response()->json($resp->json(), $resp->status());
    }
}
