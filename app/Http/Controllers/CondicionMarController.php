<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class CondicionMarController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index()
    {
        $response = $this->apiService->get('/condiciones-mar');
        $condiciones = $response->successful() ? $response->json() : [];

        return view('condicionesmar.index', [
            'condiciones' => $condiciones,
        ]);
    }

    public function create()
    {
        return view('condicionesmar.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'descripcion' => ['required', 'string'],
        ]);

        $response = $this->apiService->post('/condiciones-mar', $data);

        if ($response->successful()) {
            return redirect()->route('condicionesmar.index')->with('success', 'Condición del mar creada correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/condiciones-mar/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $condicion = $response->json();
        return view('condicionesmar.form', [
            'condicion' => $condicion,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'descripcion' => ['required', 'string'],
        ]);

        $response = $this->apiService->put("/condiciones-mar/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('condicionesmar.index')->with('success', 'Condición del mar actualizada correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/condiciones-mar/{$id}");

        if ($response->successful()) {
            return redirect()->route('condicionesmar.index')->with('success', 'Condición del mar eliminada');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}
