<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class EmbarcacionController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index()
    {
        $response = $this->apiService->get('/embarcaciones');
        $embarcaciones = $response->successful() ? $response->json() : [];

        return view('embarcaciones.index', [
            'embarcaciones' => $embarcaciones,
        ]);
    }

    public function create()
    {
        return view('embarcaciones.form', [
            'tipos' => $this->getTiposEmbarcacion(),
            'tiposMotor' => $this->getTiposMotor(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo' => ['nullable', 'string'],
            'nombre' => ['required', 'string'],
            'matricula' => ['nullable', 'string'],
            'tipo_embarcacion_id' => ['nullable', 'integer'],
            'eslora' => ['nullable', 'numeric'],
            'tipo_motor_id' => ['nullable', 'integer'],
        ]);

        $response = $this->apiService->post('/embarcaciones', $data);

        if ($response->successful()) {
            return redirect()->route('embarcaciones.index')->with('success', 'Embarcación creada correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/embarcaciones/{$id}");
        if (!$response->successful()) {
            abort(404);
        }
        $embarcacion = $response->json();
        return view('embarcaciones.form', [
            'embarcacion' => $embarcacion,
            'tipos' => $this->getTiposEmbarcacion(),
            'tiposMotor' => $this->getTiposMotor(),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'codigo' => ['nullable', 'string'],
            'nombre' => ['required', 'string'],
            'matricula' => ['nullable', 'string'],
            'tipo_embarcacion_id' => ['nullable', 'integer'],
            'eslora' => ['nullable', 'numeric'],
            'tipo_motor_id' => ['nullable', 'integer'],
        ]);

        $response = $this->apiService->put("/embarcaciones/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('embarcaciones.index')->with('success', 'Embarcación actualizada correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/embarcaciones/{$id}");

        if ($response->successful()) {
            return redirect()->route('embarcaciones.index')->with('success', 'Embarcación eliminada');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }

    private function getTiposEmbarcacion(): array
    {
        $response = $this->apiService->get('/tipo-embarcacion');

        return $response->successful() ? $response->json() : [];
    }

    private function getTiposMotor(): array
    {
        $response = $this->apiService->get('/tipo-motor');

        return $response->successful() ? $response->json() : [];
    }
}
