<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class TripulanteViajeController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index(Request $request)
    {
        $viajeId = $request->query('viaje_id');
        $tripulantes = [];
        if ($viajeId) {
            $resp = $this->apiService->get('/tripulantes-viaje', ['viaje_id' => $viajeId]);
            $tripulantes = $resp->successful() ? $resp->json() : [];
        }
        return view('tripulantes-viaje.index', [
            'tripulantes' => $tripulantes,
            'viajeId' => $viajeId,
        ]);
    }

    public function create(Request $request)
    {
        $viajeId = $request->query('viaje_id');
        return view('tripulantes-viaje.form', [
            'viajeId' => $viajeId,
        ]);
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

        if ($resp->successful()) {
            return redirect()
                ->route('viajes.edit', ['viaje' => $data['viaje_id'], 'por_finalizar' => 1])
                ->with('success', 'Tripulante registrado correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $resp = $this->apiService->get("/tripulantes-viaje/{$id}");
        if (! $resp->successful()) {
            abort(404);
        }
        $tripulante = $resp->json();
        return view('tripulantes-viaje.form', [
            'tripulante' => $tripulante,
            'viajeId' => $tripulante['viaje_id'] ?? null,
        ]);
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

        if ($resp->successful()) {
            return redirect()
                ->route('viajes.edit', ['viaje' => $data['viaje_id'], 'por_finalizar' => 1])
                ->with('success', 'Tripulante actualizado correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(Request $request, string $id)
    {
        $viajeId = $request->query('viaje_id');
        $resp = $this->apiService->delete("/tripulantes-viaje/{$id}");

        if ($resp->successful()) {
            return redirect()
                ->route('viajes.edit', ['viaje' => $viajeId, 'por_finalizar' => 1])
                ->with('success', 'Tripulante eliminado');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}
