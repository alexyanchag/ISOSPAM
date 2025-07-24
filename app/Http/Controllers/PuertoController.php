<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class PuertoController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index()
    {
        $response = $this->apiService->get('/puertos');
        $puertos = $response->successful() ? $response->json() : [];

        return view('puertos.index', [
            'puertos' => $puertos,
        ]);
    }

    public function create()
    {
        return view('puertos.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
        ]);

        $response = $this->apiService->post('/puertos', $data);

        if ($response->successful()) {
            return redirect()->route('puertos.index')->with('success', 'Puerto creado correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/puertos/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $puerto = $response->json();
        return view('puertos.form', [
            'puerto' => $puerto,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
        ]);

        $response = $this->apiService->put("/puertos/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('puertos.index')->with('success', 'Puerto actualizado correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/puertos/{$id}");

        if ($response->successful()) {
            return redirect()->route('puertos.index')->with('success', 'Puerto eliminado');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}
