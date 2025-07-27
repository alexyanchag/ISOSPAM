<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class UnidadVentaController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index()
    {
        $response = $this->apiService->get('/unidad-venta');
        $unidades = $response->successful() ? $response->json() : [];

        return view('unidadventa.index', [
            'unidades' => $unidades,
        ]);
    }

    public function create()
    {
        return view('unidadventa.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
        ]);

        $response = $this->apiService->post('/unidad-venta', $data);

        if ($response->successful()) {
            return redirect()->route('unidadventa.index')->with('success', 'Unidad de Venta creada correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/unidad-venta/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $unidad = $response->json();

        return view('unidadventa.form', [
            'unidad' => $unidad,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
        ]);

        $response = $this->apiService->put("/unidad-venta/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('unidadventa.index')->with('success', 'Unidad de Venta actualizada correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/unidad-venta/{$id}");

        if ($response->successful()) {
            return redirect()->route('unidadventa.index')->with('success', 'Unidad de Venta eliminada');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}
