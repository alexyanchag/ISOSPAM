<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TablaMultifinalitariaController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index($campania)
    {
        $response = $this->apiService->get("/tabla-multifinalitaria/campania/{$campania}");
        $campos = $response->successful() ? $response->json() : [];

        $campos = collect($campos)->map(function ($c) {
            $c['opciones'] = $c['opciones']
                ? json_decode($c['opciones'], true)
                : [];
            return $c;
        })->toArray();

        return view('campanias.tabla-multifinalitaria', [
            'campaniaId' => $campania,
            'campos' => $campos,
        ]);
    }

    public function store(Request $request, $campania)
    {
        $data = $this->validateData($request);
        $data['campania_id'] = $campania;

        $response = $this->apiService->post('/tabla-multifinalitaria', $data);

        if ($response->successful()) {
            return redirect()->route('campanias.tabla-multifinalitaria.index', $campania)
                ->with('success', 'Campo creado correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function update(Request $request, $campania, $id)
    {
        $data = $this->validateData($request);

        $response = $this->apiService->put("/tabla-multifinalitaria/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('campanias.tabla-multifinalitaria.index', $campania)
                ->with('success', 'Campo actualizado correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy($campania, $id)
    {
        $response = $this->apiService->delete("/tabla-multifinalitaria/{$id}");

        if ($response->successful()) {
            return redirect()->route('campanias.tabla-multifinalitaria.index', $campania)
                ->with('success', 'Campo eliminado');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }

    protected function validateData(Request $request): array
    {
        $data = $request->validate([
            'tabla_relacionada' => ['required', 'string'],
            'nombre_pregunta' => ['required', 'string'],
            'tipo_pregunta' => ['required', Rule::in(['COMBO','INTEGER','DATE','TIME','INPUT'])],
            'opciones' => ['nullable', 'string'],
        ]);

        if (($data['tipo_pregunta'] ?? '') === 'COMBO') {
            $opciones = json_decode($data['opciones'] ?? '[]', true) ?: [];
            $data['opciones'] = json_encode(array_map(fn($o) => ['key' => $o, 'value' => $o], $opciones));
        } else {
            unset($data['opciones']);
        }

        return $data;
    }
}

