<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class ViajeController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index(Request $request)
    {
        $fechaInicio = $request->query('fecha_inicio', now()->startOfMonth()->format('Y-m-d'));
        $fechaFin = $request->query('fecha_fin', now()->format('Y-m-d'));

        $response = $this->apiService->get('/viajes', [
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
        ]);
        $viajes = $response->successful() ? $response->json() : [];

        return view('viajes.index', [
            'viajes' => $viajes,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
        ]);
    }

    public function create()
    {
        return view('viajes.form', [
            'muelles' => $this->getMuelles(),
            'puertos' => $this->getPuertos(),
            'embarcaciones' => $this->getEmbarcaciones(),
            'campanias' => $this->getCampanias(),
            'responsables' => $this->getPersonasPorRol('RESPVJ'),
            'digitadores' => $this->getPersonasPorRol('CTF'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fecha_zarpe' => ['nullable', 'date'],
            'hora_zarpe' => ['nullable'],
            'fecha_arribo' => ['nullable', 'date'],
            'hora_arribo' => ['nullable'],
            'observaciones' => ['nullable', 'string'],
            'muelle_id' => ['nullable', 'integer'],
            'puerto_zarpe_id' => ['nullable', 'integer'],
            'puerto_arribo_id' => ['nullable', 'integer'],
            'persona_idpersona' => ['nullable', 'integer'],
            'embarcacion_id' => ['nullable', 'integer'],
            'digitador_id' => ['nullable', 'integer'],
            'campania_id' => ['nullable', 'integer'],
        ]);

        $response = $this->apiService->post('/viajes', $data);

        if ($response->successful()) {
            return redirect()->route('viajes.index')->with('success', 'Viaje creado correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/viajes/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $viaje = $response->json();

        return view('viajes.form', [
            'viaje' => $viaje,
            'muelles' => $this->getMuelles(),
            'puertos' => $this->getPuertos(),
            'embarcaciones' => $this->getEmbarcaciones(),
            'campanias' => $this->getCampanias(),
            'responsables' => $this->getPersonasPorRol('RESPVJ'),
            'digitadores' => $this->getPersonasPorRol('CTF'),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'fecha_zarpe' => ['nullable', 'date'],
            'hora_zarpe' => ['nullable'],
            'fecha_arribo' => ['nullable', 'date'],
            'hora_arribo' => ['nullable'],
            'observaciones' => ['nullable', 'string'],
            'muelle_id' => ['nullable', 'integer'],
            'puerto_zarpe_id' => ['nullable', 'integer'],
            'puerto_arribo_id' => ['nullable', 'integer'],
            'persona_idpersona' => ['nullable', 'integer'],
            'embarcacion_id' => ['nullable', 'integer'],
            'digitador_id' => ['nullable', 'integer'],
            'campania_id' => ['nullable', 'integer'],
        ]);

        $response = $this->apiService->put("/viajes/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('viajes.index')->with('success', 'Viaje actualizado correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/viajes/{$id}");

        if ($response->successful()) {
            return redirect()->route('viajes.index')->with('success', 'Viaje eliminado');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }

    public function misPorFinalizar(Request $request)
    {
        $digitadorId = $request->query('digitador_id');

        $digitadores = $this->getPersonasPorRol('CTF');

        $viajes = [];
        if ($digitadorId) {
            $response = $this->apiService->get("/viajes/por-finalizar/{$digitadorId}");
            $viajes = $response->successful() ? $response->json() : [];
        }

        return view('viajes.mis-por-finalizar', [
            'viajes' => $viajes,
            'digitadores' => $digitadores,
            'digitadorId' => $digitadorId,
        ]);
    }

    public function updatePorFinalizar(Request $request, string $id)
    {
        $data = $request->validate([
            'fecha_zarpe' => ['required', 'date'],
            'hora_zarpe' => ['required'],
            'fecha_arribo' => ['required', 'date'],
            'hora_arribo' => ['required'],
            'observaciones' => ['required', 'string'],
            'muelle_id' => ['nullable', 'integer'],
            'puerto_zarpe_id' => ['required', 'integer'],
            'puerto_arribo_id' => ['required', 'integer'],
            'persona_idpersona' => ['required', 'integer'],
            'embarcacion_id' => ['required', 'integer'],
            'digitador_id' => ['required', 'integer'],
            'campania_id' => ['required', 'integer'],
        ]);

        $response = $this->apiService->put("/viajes/{$id}", $data);
        if ($response->failed()) {
            return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
        }

        $final = $this->apiService->post("/viajes/{$id}/finalizar");
        if ($final->successful()) {
            return redirect()
                ->route('viajes.mis-por-finalizar', ['digitador_id' => $data['digitador_id']])
                ->with('success', 'Viaje finalizado correctamente');
        }

        return back()->withErrors(['error' => 'Error al finalizar'])->withInput();
    }

    private function getMuelles(): array
    {
        $response = $this->apiService->get('/muelles');
        return $response->successful() ? $response->json() : [];
    }

    private function getPuertos(): array
    {
        $response = $this->apiService->get('/puertos');
        return $response->successful() ? $response->json() : [];
    }

    private function getEmbarcaciones(): array
    {
        $response = $this->apiService->get('/embarcaciones');
        return $response->successful() ? $response->json() : [];
    }

    private function getCampanias(): array
    {
        $response = $this->apiService->get('/campanias');
        return $response->successful() ? $response->json() : [];
    }

    private function getPersonasPorRol(string $codigoRol): array
    {
        $response = $this->apiService->get("/buscar-personas/{$codigoRol}");
        return $response->successful() ? $response->json() : [];
    }
}
