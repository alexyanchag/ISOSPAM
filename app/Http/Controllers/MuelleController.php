<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class MuelleController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index()
    {
        $response = $this->apiService->get('/muelles');
        $muelles = $response->successful() ? $response->json() : [];

        return view('muelles.index', [
            'muelles' => $muelles,
        ]);
    }

    public function create()
    {
        return view('muelles.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
        ]);

        $response = $this->apiService->post('/muelles', $data);

        if ($response->successful()) {
            return redirect()->route('muelles.index')->with('success', 'Muelle creado correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/muelles/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $muelle = $response->json();
        return view('muelles.form', [
            'muelle' => $muelle,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
        ]);

        $response = $this->apiService->put("/muelles/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('muelles.index')->with('success', 'Muelle actualizado correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/muelles/{$id}");

        if ($response->successful()) {
            return redirect()->route('muelles.index')->with('success', 'Muelle eliminado');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}
