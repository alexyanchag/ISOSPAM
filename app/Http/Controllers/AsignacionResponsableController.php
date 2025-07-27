<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class AsignacionResponsableController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index()
    {
        $response = $this->apiService->get('/asignaciones-responsables');
        $asignaciones = $response->successful() ? $response->json() : [];

        return view('asignacionresponsable.index', [
            'asignaciones' => $asignaciones,
        ]);
    }

    public function create()
    {
        return view('asignacionresponsable.form', [
            'organizaciones' => $this->getOrganizaciones(),
            'personas' => $this->getPersonas(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'organizacion_pesquera_id' => ['required', 'integer'],
            'persona_idpersona' => ['required', 'integer'],
            'fecha_inicio' => ['nullable', 'date'],
            'fecha_fin' => ['nullable', 'date'],
            'estado' => ['nullable', 'string'],
        ]);

        $response = $this->apiService->post('/asignaciones-responsables', $data);

        if ($response->successful()) {
            return redirect()->route('asignacionresponsable.index')->with('success', 'Asignación creada correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/asignaciones-responsables/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $asignacion = $response->json();

        return view('asignacionresponsable.form', [
            'asignacion' => $asignacion,
            'organizaciones' => $this->getOrganizaciones(),
            'personas' => $this->getPersonas(),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'organizacion_pesquera_id' => ['required', 'integer'],
            'persona_idpersona' => ['required', 'integer'],
            'fecha_inicio' => ['nullable', 'date'],
            'fecha_fin' => ['nullable', 'date'],
            'estado' => ['nullable', 'string'],
        ]);

        $response = $this->apiService->put("/asignaciones-responsables/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('asignacionresponsable.index')->with('success', 'Asignación actualizada correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/asignaciones-responsables/{$id}");

        if ($response->successful()) {
            return redirect()->route('asignacionresponsable.index')->with('success', 'Asignación eliminada');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }

    private function getOrganizaciones(): array
    {
        $response = $this->apiService->get('/organizacion-pesquera');
        return $response->successful() ? $response->json() : [];
    }

    private function getPersonas(): array
    {
        $response = $this->apiService->get('/personas');
        return $response->successful() ? $response->json() : [];
    }
}
