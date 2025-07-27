<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class TipoObservadorController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index()
    {
        $response = $this->apiService->get('/tipo-observador');
        $tipos = $response->successful() ? $response->json() : [];

        return view('tipoobservador.index', [
            'tiposobservador' => $tipos,
        ]);
    }

    public function create()
    {
        return view('tipoobservador.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'descripcion' => ['required', 'string'],
        ]);

        $response = $this->apiService->post('/tipo-observador', $data);

        if ($response->successful()) {
            return redirect()->route('tipoobservador.index')->with('success', 'Tipo de Observador creado correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/tipo-observador/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $tipo = $response->json();
        return view('tipoobservador.form', [
            'tipoobservador' => $tipo,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'descripcion' => ['required', 'string'],
        ]);

        $response = $this->apiService->put("/tipo-observador/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('tipoobservador.index')->with('success', 'Tipo de Observador actualizado correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/tipo-observador/{$id}");

        if ($response->successful()) {
            return redirect()->route('tipoobservador.index')->with('success', 'Tipo de Observador eliminado');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}
