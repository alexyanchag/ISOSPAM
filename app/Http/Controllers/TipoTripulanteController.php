<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class TipoTripulanteController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index()
    {
        $response = $this->apiService->get('/tipos-tripulante');
        $tipos = $response->successful() ? $response->json() : [];

        return view('tipotripulantes.index', [
            'tipostripulante' => $tipos,
        ]);
    }

    public function create()
    {
        return view('tipotripulantes.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'descripcion' => ['required', 'string'],
        ]);

        $response = $this->apiService->post('/tipos-tripulante', $data);

        if ($response->successful()) {
            return redirect()->route('tipotripulantes.index')->with('success', 'Tipo de Tripulante creado correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/tipos-tripulante/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $tipo = $response->json();
        return view('tipotripulantes.form', [
            'tipotripulante' => $tipo,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'descripcion' => ['required', 'string'],
        ]);

        $response = $this->apiService->put("/tipos-tripulante/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('tipotripulantes.index')->with('success', 'Tipo de Tripulante actualizado correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/tipos-tripulante/{$id}");

        if ($response->successful()) {
            return redirect()->route('tipotripulantes.index')->with('success', 'Tipo de Tripulante eliminado');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}
