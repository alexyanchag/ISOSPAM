<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class TipoArteController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index()
    {
        $response = $this->apiService->get('/tipos-arte');
        $tipoartes = $response->successful() ? $response->json() : [];

        return view('tipoartes.index', [
            'tipoartes' => $tipoartes,
        ]);
    }

    public function create()
    {
        return view('tipoartes.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
            'tipo' => ['nullable', 'string'],
        ]);

        $response = $this->apiService->post('/tipos-arte', $data);

        if ($response->successful()) {
            return redirect()->route('tipoartes.index')->with('success', 'Tipo de Arte creado correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/tipos-arte/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $tipoarte = $response->json();
        return view('tipoartes.form', [
            'tipoarte' => $tipoarte,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
            'tipo' => ['nullable', 'string'],
        ]);

        $response = $this->apiService->put("/tipos-arte/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('tipoartes.index')->with('success', 'Tipo de Arte actualizado correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/tipos-arte/{$id}");

        if ($response->successful()) {
            return redirect()->route('tipoartes.index')->with('success', 'Tipo de Arte eliminado');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}
