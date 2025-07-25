<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class TipoAnzueloController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index()
    {
        $response = $this->apiService->get('/tipos-anzuelo');
        $tiposanzuelo = $response->successful() ? $response->json() : [];

        return view('tipoanzuelos.index', [
            'tiposanzuelo' => $tiposanzuelo,
        ]);
    }

    public function create()
    {
        return view('tipoanzuelos.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
        ]);

        $response = $this->apiService->post('/tipos-anzuelo', $data);

        if ($response->successful()) {
            return redirect()->route('tipoanzuelos.index')->with('success', 'Tipo de Anzuelo creado correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/tipos-anzuelo/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $tipoanzuelo = $response->json();
        return view('tipoanzuelos.form', [
            'tipoanzuelo' => $tipoanzuelo,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
        ]);

        $response = $this->apiService->put("/tipos-anzuelo/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('tipoanzuelos.index')->with('success', 'Tipo de Anzuelo actualizado correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/tipos-anzuelo/{$id}");

        if ($response->successful()) {
            return redirect()->route('tipoanzuelos.index')->with('success', 'Tipo de Anzuelo eliminado');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}
