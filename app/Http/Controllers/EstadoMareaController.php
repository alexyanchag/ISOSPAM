<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class EstadoMareaController extends Controller
{
    public function __construct(private ApiService $apiService) {}

    public function index()
    {
        $response = $this->apiService->get('/estados-marea');
        $estados = $response->successful() ? $response->json() : [];

        return view('estadosmarea.index', [
            'estados' => $estados,
        ]);
    }

    public function create()
    {
        return view('estadosmarea.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'descripcion' => ['required', 'string'],
        ]);

        $response = $this->apiService->post('/estados-marea', $data);

        if ($response->successful()) {
            return redirect()->route('estadosmarea.index')->with('success', 'Estado de Marea creado correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/estados-marea/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $estado = $response->json();
        return view('estadosmarea.form', [
            'estado' => $estado,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'descripcion' => ['required', 'string'],
        ]);

        $response = $this->apiService->put("/estados-marea/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('estadosmarea.index')->with('success', 'Estado de Marea actualizado correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/estados-marea/{$id}");

        if ($response->successful()) {
            return redirect()->route('estadosmarea.index')->with('success', 'Estado de Marea eliminado');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}
