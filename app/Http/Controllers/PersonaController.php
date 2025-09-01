<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index(Request $request)
    {
        $filtro = $request->query('filtro');
        if ($filtro) {
            $response = $this->apiService->get('/personas/buscar', ['filtro' => $filtro]);
        } else {
            $response = $this->apiService->get('/personas');
        }
        $personas = $response->successful() ? $response->json() : [];

        return view('personas.index', [
            'personas' => $personas,
            'filtro' => $filtro,
        ]);
    }

    public function create()
    {
        return view('personas.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'identificacion' => ['required', 'string'],
            'nombres' => ['required', 'string'],
            'apellidos' => ['required', 'string'],
            'direccion' => ['nullable', 'string'],
            'celular' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'estadocivil' => ['nullable', 'integer'],
            'fechanacimiento' => ['nullable', 'date'],
        ]);

        $response = $this->apiService->post('/personas', $data);

        if ($response->successful()) {
            return redirect()->route('personas.index')->with('success', 'Persona creada correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/personas/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $persona = $response->json();
        return view('personas.form', [
            'persona' => $persona,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'identificacion' => ['required', 'string'],
            'nombres' => ['required', 'string'],
            'apellidos' => ['required', 'string'],
            'direccion' => ['nullable', 'string'],
            'celular' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'estadocivil' => ['nullable', 'integer'],
            'fechanacimiento' => ['nullable', 'date'],
        ]);

        $response = $this->apiService->put("/personas/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('personas.index')->with('success', 'Persona actualizada correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/personas/{$id}");

        if ($response->successful()) {
            return redirect()->route('personas.index')->with('success', 'Persona eliminada');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }

    public function buscarPorRol(Request $request)
    {
        $rol = $request->query('rol');
        $filtro = $request->query('filtro');
        if (! $rol) {
            return response()->json([]);
        }

        $resp = $this->apiService->get("/buscar-personas/{$rol}", [
            'filtro' => $filtro,
        ]);

        $data = $resp->successful() ? $resp->json() : [];

        return response()->json($data);
    }

    public function buscar(Request $request)
    {
        $filtro = $request->query('filtro');

        $resp = $this->apiService->get('/personas/buscar', [
            'filtro' => $filtro,
        ]);

        $data = $resp->successful() ? $resp->json() : [];

        return response()->json($data);
    }
}
