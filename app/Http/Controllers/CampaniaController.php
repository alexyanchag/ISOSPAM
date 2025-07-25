<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class CampaniaController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index()
    {
        $response = $this->apiService->get('/campanias');
        $campanias = $response->successful() ? $response->json() : [];

        return view('campanias.index', [
            'campanias' => $campanias,
        ]);
    }

    public function create()
    {
        return view('campanias.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fechainicio' => ['nullable', 'date'],
            'fechafin' => ['nullable', 'date'],
            'descripcion' => ['nullable', 'string'],
        ]);

        $response = $this->apiService->post('/campanias', $data);

        if ($response->successful()) {
            return redirect()->route('campanias.index')->with('success', 'Campaña creada correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/campanias/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $campania = $response->json();
        return view('campanias.form', [
            'campania' => $campania,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'fechainicio' => ['nullable', 'date'],
            'fechafin' => ['nullable', 'date'],
            'descripcion' => ['nullable', 'string'],
        ]);

        $response = $this->apiService->put("/campanias/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('campanias.index')->with('success', 'Campaña actualizada correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/campanias/{$id}");

        if ($response->successful()) {
            return redirect()->route('campanias.index')->with('success', 'Campaña eliminada');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}
