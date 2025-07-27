<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class TipoMotorController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index()
    {
        $response = $this->apiService->get('/tipo-motor');
        $tipos = $response->successful() ? $response->json() : [];

        return view('tipomotor.index', [
            'tiposmotores' => $tipos,
        ]);
    }

    public function create()
    {
        return view('tipomotor.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
            'motor_hp' => ['nullable', 'numeric'],
        ]);

        $response = $this->apiService->post('/tipo-motor', $data);

        if ($response->successful()) {
            return redirect()->route('tipomotores.index')->with('success', 'Tipo de Motor creado correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/tipo-motor/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $motor = $response->json();
        return view('tipomotor.form', [
            'tipomotor' => $motor,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
            'motor_hp' => ['nullable', 'numeric'],
        ]);

        $response = $this->apiService->put("/tipo-motor/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('tipomotores.index')->with('success', 'Tipo de Motor actualizado correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/tipo-motor/{$id}");

        if ($response->successful()) {
            return redirect()->route('tipomotores.index')->with('success', 'Tipo de Motor eliminado');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }
}
