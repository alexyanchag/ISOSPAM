<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\JsonResponse;

class ApiProxyController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function getEspecies(): JsonResponse
    {
        $resp = $this->apiService->get('/especies');
        return response()->json($resp->json(), $resp->status());
    }

    public function getTipoObservador(): JsonResponse
    {
        $resp = $this->apiService->get('/tipo-observador');
        return response()->json($resp->json(), $resp->status());
    }

    public function getTiposTripulante(): JsonResponse
    {
        $resp = $this->apiService->get('/tipos-tripulante');
        return response()->json($resp->json(), $resp->status());
    }

    public function getEstadosMarea(): JsonResponse
    {
        $resp = $this->apiService->get('/estados-marea');
        return response()->json($resp->json(), $resp->status());
    }

    public function getCondicionesMar(): JsonResponse
    {
        $resp = $this->apiService->get('/condiciones-mar');
        return response()->json($resp->json(), $resp->status());
    }

    public function getTiposArte(): JsonResponse
    {
        $resp = $this->apiService->get('/tipos-arte');
        return response()->json($resp->json(), $resp->status());
    }

    public function getTiposAnzuelo(): JsonResponse
    {
        $resp = $this->apiService->get('/tipos-anzuelo');
        return response()->json($resp->json(), $resp->status());
    }

    public function getMaterialesMalla(): JsonResponse
    {
        $resp = $this->apiService->get('/materiales-malla');
        return response()->json($resp->json(), $resp->status());
    }

    public function getTiposInsumo(): JsonResponse
    {
        $resp = $this->apiService->get('/tipos-insumo');
        return response()->json($resp->json(), $resp->status());
    }

    public function getUnidadesInsumo(): JsonResponse
    {
        $resp = $this->apiService->get('/unidades-insumo');
        return response()->json($resp->json(), $resp->status());
    }

    public function getUnidadesVenta(): JsonResponse
    {
        $resp = $this->apiService->get('/unidad-venta');
        return response()->json($resp->json(), $resp->status());
    }

    public function getUnidadesProfundidad(): JsonResponse
    {
        $resp = $this->apiService->get('/unidad-profundidad');
        return response()->json($resp->json(), $resp->status());
    }

    public function getUnidadesLongitud(): JsonResponse
    {
        $resp = $this->apiService->get('/unidad-longitud');
        return response()->json($resp->json(), $resp->status());
    }

    public function getEstadosDesarrolloGonadal(): JsonResponse
    {
        $resp = $this->apiService->get('/estado-desarrollo-gonadal');
        return response()->json($resp->json(), $resp->status());
    }

    public function getSitios(): JsonResponse
    {
        $resp = $this->apiService->get('/sitios');
        return response()->json($resp->json(), $resp->status());
    }

    public function getPersonas(): JsonResponse
    {
        $resp = $this->apiService->get('/personas');
        return response()->json($resp->json(), $resp->status());
    }

    public function getPersona(string $id): JsonResponse
    {
        $resp = $this->apiService->get("/personas/{$id}");
        return response()->json($resp->json(), $resp->status());
    }

    public function getOrganizacionesPesquera(): JsonResponse
    {
        $resp = $this->apiService->get('/organizacion-pesquera');
        return response()->json($resp->json(), $resp->status());
    }
}

