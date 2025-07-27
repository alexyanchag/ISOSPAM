<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class FamiliaController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index()
    {
        $response = $this->apiService->get('/familias');
        $familias = $response->successful() ? $response->json() : [];

        return view('familias.index', [
            'familias' => $familias,
        ]);
    }

    public function create()
    {
        return view('familias.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
        ]);

        $response = $this->apiService->post('/familias', $data);

        if ($response->successful()) {
            return redirect()->route('familias.index')->with('success', 'Familia creada correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/familias/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $familia = $response->json();
        $respEspecies = $this->apiService->get('/especies/por-familia', [
            'familia_id' => $id,
        ]);
        $especies = $respEspecies->successful() ? $respEspecies->json() : [];

        return view('familias.form', [
            'familia' => $familia,
            'especies' => $especies,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
        ]);

        $response = $this->apiService->put("/familias/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('familias.index')->with('success', 'Familia actualizada correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/familias/{$id}");

        if ($response->successful()) {
            return redirect()->route('familias.index')->with('success', 'Familia eliminada');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}
