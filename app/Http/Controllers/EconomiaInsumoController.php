<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class EconomiaInsumoController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index(Request $request)
    {
        $viajeId = $request->query('viaje_id');
        $economias = [];
        if ($viajeId) {
            $resp = $this->apiService->get("/economia-insumo-viaje/{$viajeId}");
            $economias = $resp->successful() ? $resp->json() : [];
        }
        return view('economia-insumo.index', [
            'economiaInsumos' => $economias,
            'viajeId' => $viajeId,
        ]);
    }

    public function create(Request $request)
    {
        $viajeId = $request->query('viaje_id');
        return view('economia-insumo.form', [
            'viajeId' => $viajeId,
        ]);
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

        if ($resp->successful()) {
            return redirect()
                ->route('viajes.edit', ['viaje' => $data['viaje_id'], 'por_finalizar' => 1])
                ->with('success', 'Economía de insumo registrada correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $resp = $this->apiService->get("/economia-insumo/{$id}");
        if (! $resp->successful()) {
            abort(404);
        }
        $economia = $resp->json();
        return view('economia-insumo.form', [
            'economia' => $economia,
            'viajeId' => $economia['viaje_id'] ?? null,
        ]);
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

        if ($resp->successful()) {
            return redirect()
                ->route('viajes.edit', ['viaje' => $data['viaje_id'], 'por_finalizar' => 1])
                ->with('success', 'Economía de insumo actualizada correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(Request $request, string $id)
    {
        $viajeId = $request->query('viaje_id');
        $resp = $this->apiService->delete("/economia-insumo/{$id}");

        if ($resp->successful()) {
            return redirect()
                ->route('viajes.edit', ['viaje' => $viajeId, 'por_finalizar' => 1])
                ->with('success', 'Economía de insumo eliminada');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}

