<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class TipoEmbarcacionController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index()
    {
        $response = $this->apiService->get('/tipo-embarcacion');
        $tipos = $response->successful() ? $response->json() : [];

        return view('tipoembarcacion.index', [
            'tiposembarcacion' => $tipos,
        ]);
    }

    public function create()
    {
        return view('tipoembarcacion.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
        ]);

        $response = $this->apiService->post('/tipo-embarcacion', $data);

        if ($response->successful()) {
            return redirect()->route('tipoembarcaciones.index')->with('success', 'Tipo de Embarcación creado correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/tipo-embarcacion/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $tipo = $response->json();
        return view('tipoembarcacion.form', [
            'tipoembarcacion' => $tipo,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
        ]);

        $response = $this->apiService->put("/tipo-embarcacion/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('tipoembarcaciones.index')->with('success', 'Tipo de Embarcación actualizado correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/tipo-embarcacion/{$id}");

        if ($response->successful()) {
            return redirect()->route('tipoembarcaciones.index')->with('success', 'Tipo de Embarcación eliminado');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}
