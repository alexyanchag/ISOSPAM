<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class EstadoDesarrolloGonadalController extends Controller
{
    public function __construct(private ApiService $apiService) {}

    public function index()
    {
        $response = $this->apiService->get('/estado-desarrollo-gonadal');
        $estados = $response->successful() ? $response->json() : [];

        return view('estadodesarrollogonadal.index', [
            'estados' => $estados,
        ]);
    }

    public function create()
    {
        return view('estadodesarrollogonadal.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
        ]);

        $response = $this->apiService->post('/estado-desarrollo-gonadal', $data);

        if ($response->successful()) {
            return redirect()->route('estadodesarrollogonadal.index')->with('success', 'Estado de Desarrollo Gonadal creado correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/estado-desarrollo-gonadal/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $estado = $response->json();
        return view('estadodesarrollogonadal.form', [
            'estado' => $estado,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
        ]);

        $response = $this->apiService->put("/estado-desarrollo-gonadal/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('estadodesarrollogonadal.index')->with('success', 'Estado de Desarrollo Gonadal actualizado correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/estado-desarrollo-gonadal/{$id}");

        if ($response->successful()) {
            return redirect()->route('estadodesarrollogonadal.index')->with('success', 'Estado de Desarrollo Gonadal eliminado');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}
