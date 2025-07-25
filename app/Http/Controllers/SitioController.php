<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class SitioController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index()
    {
        $response = $this->apiService->get('/sitios');
        $sitios = $response->successful() ? $response->json() : [];

        return view('sitios.index', [
            'sitios' => $sitios,
        ]);
    }

    public function create()
    {
        return view('sitios.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
        ]);

        $response = $this->apiService->post('/sitios', $data);

        if ($response->successful()) {
            return redirect()->route('sitios.index')->with('success', 'Sitio creado correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/sitios/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $sitio = $response->json();
        return view('sitios.form', [
            'sitio' => $sitio,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
        ]);

        $response = $this->apiService->put("/sitios/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('sitios.index')->with('success', 'Sitio actualizado correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/sitios/{$id}");

        if ($response->successful()) {
            return redirect()->route('sitios.index')->with('success', 'Sitio eliminado');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}
