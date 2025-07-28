<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class AsignacionResponsableController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index(Request $request)
    {
        $organizacionId = $request->query('organizacion_pesquera_id');
        if ($organizacionId) {
            $response = $this->apiService->get("/asignaciones-responsables/organizacion/{$organizacionId}");
        } else {
            $response = $this->apiService->get('/asignaciones-responsables');
        }
        $asignaciones = $response->successful() ? $response->json() : [];

        $organizacion = null;
        if ($organizacionId) {
            $respOrg = $this->apiService->get("/organizacion-pesquera/{$organizacionId}");
            if ($respOrg->successful()) {
                $organizacion = $respOrg->json();
            }
        }

        return view('asignacionresponsable.index', [
            'asignaciones' => $asignaciones,
            'organizacionId' => $organizacionId,
            'organizacion' => $organizacion,
        ]);
    }

    public function create(Request $request)
    {
        $orgId = $request->query('organizacion_pesquera_id');
        return view('asignacionresponsable.form', [
            'organizaciones' => $this->getOrganizaciones(),
            'personas' => $this->getPersonas(),
            'selectedOrganizacion' => $orgId,
            'organizacionId' => $orgId,
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
            $redirect = $data['organizacion_pesquera_id']
                ? route('asignacionresponsable.index', ['organizacion_pesquera_id' => $data['organizacion_pesquera_id']])
                : route('asignacionresponsable.index');
            return redirect($redirect)->with('success', 'Asignación creada correctamente');
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
        if (isset($asignacion[0]) && is_array($asignacion[0])) {
            $asignacion = $asignacion[0];
        }
        if (! is_array($asignacion)) {
            abort(404);
        }

        return view('asignacionresponsable.form', [
            'asignacion' => $asignacion,
            'organizaciones' => $this->getOrganizaciones(),
            'personas' => $this->getPersonas(),
            'organizacionId' => $asignacion['organizacion_pesquera_id'] ?? null,
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
            $redirect = $data['organizacion_pesquera_id']
                ? route('asignacionresponsable.index', ['organizacion_pesquera_id' => $data['organizacion_pesquera_id']])
                : route('asignacionresponsable.index');
            return redirect($redirect)->with('success', 'Asignación actualizada correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(Request $request, string $id)
    {
        $organizacionId = $request->query('organizacion_pesquera_id');
        $response = $this->apiService->delete("/asignaciones-responsables/{$id}");

        if ($response->successful()) {
            $redirect = $organizacionId
                ? route('asignacionresponsable.index', ['organizacion_pesquera_id' => $organizacionId])
                : route('asignacionresponsable.index');
            return redirect($redirect)->with('success', 'Asignación eliminada');
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
