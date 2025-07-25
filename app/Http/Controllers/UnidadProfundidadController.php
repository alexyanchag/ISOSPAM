<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class UnidadProfundidadController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index()
    {
        $response = $this->apiService->get('/unidad-profundidad');
        $unidades = $response->successful() ? $response->json() : [];

        return view('unidadprofundidad.index', [
            'unidades' => $unidades,
        ]);
    }

    public function create()
    {
        return view('unidadprofundidad.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
            'abreviatura' => ['nullable', 'string'],
        ]);

        $response = $this->apiService->post('/unidad-profundidad', $data);

        if ($response->successful()) {
            return redirect()->route('unidadprofundidad.index')->with('success', 'Unidad de Profundidad creada correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/unidad-profundidad/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $unidad = $response->json();

        return view('unidadprofundidad.form', [
            'unidad' => $unidad,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
            'abreviatura' => ['nullable', 'string'],
        ]);

        $response = $this->apiService->put("/unidad-profundidad/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('unidadprofundidad.index')->with('success', 'Unidad de Profundidad actualizada correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/unidad-profundidad/{$id}");

        if ($response->successful()) {
            return redirect()->route('unidadprofundidad.index')->with('success', 'Unidad de Profundidad eliminada');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}
