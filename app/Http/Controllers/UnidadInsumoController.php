<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class UnidadInsumoController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index()
    {
        $response = $this->apiService->get('/unidades-insumo');
        $unidades = $response->successful() ? $response->json() : [];

        return view('unidadesinsumo.index', [
            'unidades' => $unidades,
        ]);
    }

    public function create()
    {
        return view('unidadesinsumo.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
            'abreviatura' => ['nullable', 'string'],
        ]);

        $response = $this->apiService->post('/unidades-insumo', $data);

        if ($response->successful()) {
            return redirect()->route('unidadesinsumo.index')->with('success', 'Unidad de Insumo creada correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/unidades-insumo/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $unidad = $response->json();

        return view('unidadesinsumo.form', [
            'unidad' => $unidad,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
            'abreviatura' => ['nullable', 'string'],
        ]);

        $response = $this->apiService->put("/unidades-insumo/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('unidadesinsumo.index')->with('success', 'Unidad de Insumo actualizada correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/unidades-insumo/{$id}");

        if ($response->successful()) {
            return redirect()->route('unidadesinsumo.index')->with('success', 'Unidad de Insumo eliminada');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}
