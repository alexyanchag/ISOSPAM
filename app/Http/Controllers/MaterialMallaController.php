<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class MaterialMallaController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index()
    {
        $response = $this->apiService->get('/materiales-malla');
        $materiales = $response->successful() ? $response->json() : [];

        return view('materialesmalla.index', [
            'materialesmalla' => $materiales,
        ]);
    }

    public function create()
    {
        return view('materialesmalla.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
        ]);

        $response = $this->apiService->post('/materiales-malla', $data);

        if ($response->successful()) {
            return redirect()->route('materialesmalla.index')->with('success', 'Material de Malla creado correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/materiales-malla/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $materialmalla = $response->json();
        return view('materialesmalla.form', [
            'materialmalla' => $materialmalla,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
        ]);

        $response = $this->apiService->put("/materiales-malla/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('materialesmalla.index')->with('success', 'Material de Malla actualizado correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/materiales-malla/{$id}");

        if ($response->successful()) {
            return redirect()->route('materialesmalla.index')->with('success', 'Material de Malla eliminado');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}
