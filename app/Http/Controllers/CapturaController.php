<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class CapturaController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index(Request $request)
    {
        $viajeId = $request->query('viaje_id');
        $capturas = [];
        if ($viajeId) {
            $resp = $this->apiService->get('/capturas-viaje', ['viaje_id' => $viajeId]);
            $capturas = $resp->successful() ? $resp->json() : [];
        }
        return view('capturas.index', [
            'capturas' => $capturas,
            'viajeId' => $viajeId,
        ]);
    }

    public function create(Request $request)
    {
        $viajeId = $request->query('viaje_id');
        return view('capturas.form', [
            'viajeId' => $viajeId,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_comun' => ['nullable', 'string'],
            'numero_individuos' => ['nullable', 'integer'],
            'peso_estimado' => ['nullable', 'numeric'],
            'peso_contado' => ['nullable', 'numeric'],
            'especie_id' => ['nullable', 'integer'],
            'viaje_id' => ['required', 'integer'],
            'es_incidental' => ['nullable', 'boolean'],
            'es_descartada' => ['nullable', 'boolean'],
        ]);

        $resp = $this->apiService->post('/capturas', $data);

        if ($resp->successful()) {
            return redirect()
                ->route('viajes.edit', ['viaje' => $data['viaje_id'], 'por_finalizar' => 1])
                ->with('success', 'Captura creada correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $resp = $this->apiService->get("/capturas/{$id}");
        if (!$resp->successful()) {
            abort(404);
        }
        $captura = $resp->json();
        return view('capturas.form', [
            'captura' => $captura,
            'viajeId' => $captura['viaje_id'] ?? null,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombre_comun' => ['nullable', 'string'],
            'numero_individuos' => ['nullable', 'integer'],
            'peso_estimado' => ['nullable', 'numeric'],
            'peso_contado' => ['nullable', 'numeric'],
            'especie_id' => ['nullable', 'integer'],
            'viaje_id' => ['required', 'integer'],
            'es_incidental' => ['nullable', 'boolean'],
            'es_descartada' => ['nullable', 'boolean'],
        ]);

        $resp = $this->apiService->put("/capturas/{$id}", $data);

        if ($resp->successful()) {
            return redirect()
                ->route('viajes.edit', ['viaje' => $data['viaje_id'], 'por_finalizar' => 1])
                ->with('success', 'Captura actualizada correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(Request $request, string $id)
    {
        $viajeId = $request->query('viaje_id');
        $resp = $this->apiService->delete("/capturas/{$id}");

        if ($resp->successful()) {
            return redirect()
                ->route('viajes.edit', ['viaje' => $viajeId, 'por_finalizar' => 1])
                ->with('success', 'Captura eliminada');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }

}
