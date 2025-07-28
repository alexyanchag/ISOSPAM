<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class RolPersonaController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index(Request $request)
    {
        $personaId = $request->query('persona_id');
        $roles = [];
        $persona = null;
        if ($personaId) {
            $resp = $this->apiService->get("/rolpersona/{$personaId}");
            $roles = $resp->successful() ? $resp->json() : [];
            $persona = $this->getPersona($personaId);
        }
        return view('rolpersona.index', [
            'roles' => $roles,
            'personas' => $this->getPersonas(),
            'personaId' => $personaId,
            'persona' => $persona,
        ]);
    }

    public function create(Request $request)
    {
        $personaId = $request->query('persona_id');
        return view('rolpersona.form', [
            'roles' => $this->getRoles(),
            'personas' => $this->getPersonas(),
            'personaId' => $personaId,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'idpersona' => ['required', 'integer'],
            'idrol' => ['required', 'integer'],
        ]);

        $response = $this->apiService->post('/rolpersona', $data);

        if ($response->successful()) {
            return redirect()->route('rolpersona.index', ['persona_id' => $data['idpersona']])->with('success', 'Asignación creada');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function destroy(int $idpersona, int $idrol)
    {
        $response = $this->apiService->delete("/rolpersona/{$idpersona}/{$idrol}");

        if ($response->successful()) {
            return redirect()->route('rolpersona.index', ['persona_id' => $idpersona])->with('success', 'Asignación eliminada');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }

    private function getRoles(): array
    {
        $response = $this->apiService->get('/roles');
        return $response->successful() ? $response->json() : [];
    }

    private function getPersonas(): array
    {
        $response = $this->apiService->get('/personas');
        return $response->successful() ? $response->json() : [];
    }

    private function getPersona(int $id)
    {
        $resp = $this->apiService->get("/personas/{$id}");
        return $resp->successful() ? $resp->json() : null;
    }
}
