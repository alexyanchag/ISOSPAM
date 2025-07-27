<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class OrganizacionPesqueraController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index()
    {
        $response = $this->apiService->get('/organizacion-pesquera');
        $organizaciones = $response->successful() ? $response->json() : [];

        return view('organizacionpesquera.index', [
            'organizaciones' => $organizaciones,
        ]);
    }

    public function create()
    {
        return view('organizacionpesquera.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
            'zona' => ['required', 'string'],
            'es_red_issopam' => ['required', 'boolean'],
        ]);

        $data['es_red_issopam'] = (bool) $data['es_red_issopam'];

        $response = $this->apiService->post('/organizacion-pesquera', $data);

        if ($response->successful()) {
            return redirect()->route('organizacionpesquera.index')->with('success', 'Organización creada correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/organizacion-pesquera/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $organizacion = $response->json();
        $asignacionesResponse = $this->apiService->get("/asignaciones-responsables/organizacion/{$id}");
        $asignaciones = $asignacionesResponse->successful() ? $asignacionesResponse->json() : [];

        return view('organizacionpesquera.form', [
            'organizacion' => $organizacion,
            'asignaciones' => $asignaciones,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
            'zona' => ['required', 'string'],
            'es_red_issopam' => ['required', 'boolean'],
        ]);

        $data['es_red_issopam'] = (bool) $data['es_red_issopam'];

        $response = $this->apiService->put("/organizacion-pesquera/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('organizacionpesquera.index')->with('success', 'Organización actualizada correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/organizacion-pesquera/{$id}");

        if ($response->successful()) {
            return redirect()->route('organizacionpesquera.index')->with('success', 'Organización eliminada');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}
