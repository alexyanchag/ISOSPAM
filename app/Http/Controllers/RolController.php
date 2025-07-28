<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index()
    {
        $response = $this->apiService->get('/roles');
        $roles = $response->successful() ? $response->json() : [];
        return view('roles.index', [
            'roles' => $roles,
        ]);
    }

    public function create()
    {
        return view('roles.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombrerol' => ['required', 'string'],
            'codigo' => ['required', 'string'],
        ]);

        $response = $this->apiService->post('/roles', $data);

        if ($response->successful()) {
            return redirect()->route('roles.index')->with('success', 'Rol creado correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/roles/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $rol = $response->json();
        return view('roles.form', [
            'rol' => $rol,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombrerol' => ['required', 'string'],
            'codigo' => ['required', 'string'],
        ]);

        $response = $this->apiService->put("/roles/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/roles/{$id}");

        if ($response->successful()) {
            return redirect()->route('roles.index')->with('success', 'Rol eliminado');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}
