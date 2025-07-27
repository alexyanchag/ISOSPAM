<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class UnidadLongitudController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index()
    {
        $response = $this->apiService->get('/unidad-longitud');
        $unidades = $response->successful() ? $response->json() : [];

        return view('unidadlongitud.index', [
            'unidades' => $unidades,
        ]);
    }

    public function create()
    {
        return view('unidadlongitud.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
        ]);

        $response = $this->apiService->post('/unidad-longitud', $data);

        if ($response->successful()) {
            return redirect()->route('unidadlongitud.index')->with('success', 'Unidad de Longitud creada correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/unidad-longitud/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $unidad = $response->json();

        return view('unidadlongitud.form', [
            'unidad' => $unidad,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
        ]);

        $response = $this->apiService->put("/unidad-longitud/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('unidadlongitud.index')->with('success', 'Unidad de Longitud actualizada correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/unidad-longitud/{$id}");

        if ($response->successful()) {
            return redirect()->route('unidadlongitud.index')->with('success', 'Unidad de Longitud eliminada');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}
