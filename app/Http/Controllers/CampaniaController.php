<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'fechainicio' => [
                'nullable',
                'date',
                Rule::when($request->filled('fechafin'), 'before_or_equal:fechafin'),
            ],
            'fechafin' => [
                'nullable',
                'date',
                Rule::when($request->filled('fechainicio'), 'after_or_equal:fechainicio'),
            ],
            'descripcion' => ['nullable', 'string'],
        ], [
            'fechainicio.before_or_equal' => 'La fecha de inicio no puede ser mayor a la fecha fin.',
            'fechafin.after_or_equal' => 'La fecha fin no puede ser menor a la fecha inicio.',
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
            'fechainicio' => [
                'nullable',
                'date',
                Rule::when($request->filled('fechafin'), 'before_or_equal:fechafin'),
            ],
            'fechafin' => [
                'nullable',
                'date',
                Rule::when($request->filled('fechainicio'), 'after_or_equal:fechainicio'),
            ],
            'descripcion' => ['nullable', 'string'],
        ], [
            'fechainicio.before_or_equal' => 'La fecha de inicio no puede ser mayor a la fecha fin.',
            'fechafin.after_or_equal' => 'La fecha fin no puede ser menor a la fecha inicio.',
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

    public function camposDinamicos(Request $request)
    {
        $campaniaId = $request->input('campania_id');
        $tabla = $request->input('tabla_relacionada');

        if (!$campaniaId || !$tabla) {
            return response()->json([]);
        }

        $response = $this->apiService->get("/campanias/{$campaniaId}");
        if (!$response->successful()) {
            return response()->json([]);
        }

        $campania = $response->json();
        $campos = $campania['campos'] ?? [];

        $filtrados = collect($campos)
            ->filter(fn($c) => ($c['tabla_relacionada'] ?? '') === $tabla)
            ->map(function ($c) {
                $c['opciones'] = is_array($c['opciones'] ?? null)
                    ? json_encode($c['opciones'])
                    : ($c['opciones'] ?? '[]');
                return $c;
            })
            ->values()
            ->all();

        return response()->json($filtrados);
    }
}
