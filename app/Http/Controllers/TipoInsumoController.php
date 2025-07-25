<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class TipoInsumoController extends Controller
{
    public function __construct(private ApiService $apiService) {}

    public function index()
    {
        $response = $this->apiService->get('/tipos-insumo');
        $tipos = $response->successful() ? $response->json() : [];

        return view('tiposinsumo.index', [
            'tiposinsumo' => $tipos,
        ]);
    }

    public function create()
    {
        return view('tiposinsumo.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
        ]);

        $response = $this->apiService->post('/tipos-insumo', $data);

        if ($response->successful()) {
            return redirect()->route('tiposinsumo.index')->with('success', 'Tipo de Insumo creado correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/tipos-insumo/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $insumo = $response->json();

        return view('tiposinsumo.form', [
            'insumo' => $insumo,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
        ]);

        $response = $this->apiService->put("/tipos-insumo/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('tiposinsumo.index')->with('success', 'Tipo de Insumo actualizado correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/tipos-insumo/{$id}");

        if ($response->successful()) {
            return redirect()->route('tiposinsumo.index')->with('success', 'Tipo de Insumo eliminado');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}
