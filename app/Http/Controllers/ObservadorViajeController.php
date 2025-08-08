<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class ObservadorViajeController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index(Request $request)
    {
        $viajeId = $request->query('viaje_id');
        $observadores = [];
        if ($viajeId) {
            $resp = $this->apiService->get('/observadores-viaje', ['viaje_id' => $viajeId]);
            $observadores = $resp->successful() ? $resp->json() : [];
        }
        return view('observadores-viaje.index', [
            'observadores' => $observadores,
            'viajeId' => $viajeId,
        ]);
    }

    public function create(Request $request)
    {
        $viajeId = $request->query('viaje_id');
        return view('observadores-viaje.form', [
            'viajeId' => $viajeId,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'viaje_id' => ['required', 'integer'],
            'tipo_observador_id' => ['required', 'integer'],
            'persona_idpersona' => ['required', 'integer'],
        ]);

        $resp = $this->apiService->post('/observadores-viaje', $data);

        if ($resp->successful()) {
            return redirect()
                ->route('viajes.edit', ['viaje' => $data['viaje_id'], 'por_finalizar' => 1])
                ->with('success', 'Observador registrado correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $resp = $this->apiService->get("/observadores-viaje/{$id}");
        if (! $resp->successful()) {
            abort(404);
        }
        $observador = $resp->json();
        return view('observadores-viaje.form', [
            'observador' => $observador,
            'viajeId' => $observador['viaje_id'] ?? null,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'viaje_id' => ['required', 'integer'],
            'tipo_observador_id' => ['required', 'integer'],
            'persona_idpersona' => ['required', 'integer'],
        ]);

        $resp = $this->apiService->put("/observadores-viaje/{$id}", $data);

        if ($resp->successful()) {
            return redirect()
                ->route('viajes.edit', ['viaje' => $data['viaje_id'], 'por_finalizar' => 1])
                ->with('success', 'Observador actualizado correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(Request $request, string $id)
    {
        $viajeId = $request->query('viaje_id');
        $resp = $this->apiService->delete("/observadores-viaje/{$id}");

        if ($resp->successful()) {
            return redirect()
                ->route('viajes.edit', ['viaje' => $viajeId, 'por_finalizar' => 1])
                ->with('success', 'Observador eliminado');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}

