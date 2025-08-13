<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class CapturaController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index(Request $request)
    {
        $viajeId = $request->query('viaje_id');
        $capturas = [];
        if ($viajeId) {
            $resp = $this->apiService->get('/capturas-viaje', ['viaje_id' => $viajeId]);
            $capturas = $resp->successful() ? $resp->json() : [];
        }
        return view('capturas.index', [
            'capturas' => $capturas,
            'viajeId' => $viajeId,
        ]);
    }

    public function create(Request $request)
    {
        $viajeId = $request->query('viaje_id');
        $camposDinamicos = [];

        if ($viajeId) {
            $respViaje = $this->apiService->get("/viajes/{$viajeId}");
            if ($respViaje->successful()) {
                $campaniaId = $respViaje->json()['campania_id'] ?? null;
                if ($campaniaId) {
                    $camposDinamicos = $this->getCamposDinamicosCaptura((int) $campaniaId);
                }
            }
        }

        return view('capturas.form', [
            'viajeId' => $viajeId,
            'camposDinamicos' => $camposDinamicos,
        ]);
    }

    public function store(Request $request)
    {
        $viajeId = (int) $request->input('viaje_id');
        $campos = [];
        if ($viajeId) {
            $respViaje = $this->apiService->get("/viajes/{$viajeId}");
            if ($respViaje->successful()) {
                $campaniaId = $respViaje->json()['campania_id'] ?? null;
                if ($campaniaId) {
                    $campos = $this->getCamposDinamicosCaptura((int) $campaniaId);
                }
            }
        }

        $rules = [
            'nombre_comun' => ['nullable', 'string'],
            'numero_individuos' => ['nullable', 'integer'],
            'peso_estimado' => ['nullable', 'numeric'],
            'peso_contado' => ['nullable', 'numeric'],
            'especie_id' => ['nullable', 'integer'],
            'viaje_id' => ['required', 'integer'],
            'es_incidental' => ['nullable', 'boolean'],
            'es_descartada' => ['nullable', 'boolean'],
        ];

        foreach ($campos as $i => $campo) {
            $rules["respuestas_multifinalitaria.$i.respuesta"] = !empty($campo['requerido'])
                ? ['required']
                : ['nullable'];
            $rules["respuestas_multifinalitaria.$i.tabla_multifinalitaria_id"] = ['nullable', 'integer'];
            $rules["respuestas_multifinalitaria.$i.id"] = ['nullable', 'integer'];
        }

        $data = $request->validate($rules);

        $campoMap = collect($campos)->keyBy('id');
        $data['respuestas_multifinalitaria'] = collect($data['respuestas_multifinalitaria'] ?? [])
            ->map(function ($resp) use ($campoMap) {
                $id = $resp['tabla_multifinalitaria_id'] ?? null;
                $campo = (array) $campoMap->get($id, []);
                $campo['tabla_multifinalitaria_id'] = $campo['id'] ?? $id;
                unset($campo['id']);

                return array_merge($campo, [
                    'id' => $resp['id'] ?? null,
                    'respuesta' => $resp['respuesta'] ?? null,
                    'tabla_relacionada_id' => null,
                ]);
            })
            ->all();

        $resp = $this->apiService->post('/capturas', $data);

        if ($resp->successful()) {
            return redirect()
                ->route('viajes.edit', ['viaje' => $data['viaje_id'], 'por_finalizar' => 1])
                ->with('success', 'Captura creada correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $resp = $this->apiService->get("/capturas/{$id}");
        if (!$resp->successful()) {
            abort(404);
        }
        $captura = $resp->json();
        $camposDinamicos = collect($captura['respuestas_multifinalitaria'] ?? [])
            ->map(fn($r) => [
                'id' => $r['tabla_multifinalitaria_id'] ?? null,
                'nombre_pregunta' => $r['nombre_pregunta'] ?? '',
                'tipo_pregunta' => $r['tipo_pregunta'] ?? 'INPUT',
                'opciones' => is_array($r['opciones'] ?? null)
                    ? json_encode($r['opciones'])
                    : ($r['opciones'] ?? '[]'),
                'requerido' => $r['requerido'] ?? false,
            ])->all();

        return view('capturas.form', [
            'captura' => $captura,
            'viajeId' => $captura['viaje_id'] ?? null,
            'camposDinamicos' => $camposDinamicos,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $respCaptura = $this->apiService->get("/capturas/{$id}");
        $campos = $respCaptura->successful()
            ? ($respCaptura->json()['respuestas_multifinalitaria'] ?? [])
            : [];

        $rules = [
            'nombre_comun' => ['nullable', 'string'],
            'numero_individuos' => ['nullable', 'integer'],
            'peso_estimado' => ['nullable', 'numeric'],
            'peso_contado' => ['nullable', 'numeric'],
            'especie_id' => ['nullable', 'integer'],
            'viaje_id' => ['required', 'integer'],
            'es_incidental' => ['nullable', 'boolean'],
            'es_descartada' => ['nullable', 'boolean'],
        ];

        foreach ($campos as $i => $campo) {
            $rules["respuestas_multifinalitaria.$i.respuesta"] = !empty($campo['requerido'])
                ? ['required']
                : ['nullable'];
            $rules["respuestas_multifinalitaria.$i.tabla_multifinalitaria_id"] = ['nullable', 'integer'];
            $rules["respuestas_multifinalitaria.$i.id"] = ['nullable', 'integer'];
        }

        $data = $request->validate($rules);

        $campoMap = collect($campos)->keyBy('tabla_multifinalitaria_id');
        $data['respuestas_multifinalitaria'] = collect($data['respuestas_multifinalitaria'] ?? [])
            ->map(function ($resp) use ($campoMap, $id) {
                $campo = (array) $campoMap->get($resp['tabla_multifinalitaria_id'], []);
                $campo['tabla_multifinalitaria_id'] = $campo['tabla_multifinalitaria_id']
                    ?? $resp['tabla_multifinalitaria_id'];

                return array_merge($campo, [
                    'id' => $resp['id'] ?? ($campo['id'] ?? null),
                    'respuesta' => $resp['respuesta'] ?? null,
                    'tabla_relacionada_id' => (int) $id,
                ]);
            })
            ->all();

        $resp = $this->apiService->put("/capturas/{$id}", $data);

        if ($resp->successful()) {
            return redirect()
                ->route('viajes.edit', ['viaje' => $data['viaje_id'], 'por_finalizar' => 1])
                ->with('success', 'Captura actualizada correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(Request $request, string $id)
    {
        $viajeId = $request->query('viaje_id');
        $resp = $this->apiService->delete("/capturas/{$id}");

        if ($resp->successful()) {
            return redirect()
                ->route('viajes.edit', ['viaje' => $viajeId, 'por_finalizar' => 1])
                ->with('success', 'Captura eliminada');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }

    private function getCamposDinamicosCaptura(int $campaniaId): array
    {
        $response = $this->apiService->get("/campanias/{$campaniaId}");
        if (! $response->successful()) {
            return [];
        }

        $campania = $response->json();
        $campos = $campania['campos'] ?? [];

        return collect($campos)
            ->filter(fn($c) => ($c['tabla_relacionada'] ?? '') === 'captura')
            ->map(function ($c) {
                $c['opciones'] = is_array($c['opciones'] ?? null)
                    ? json_encode($c['opciones'])
                    : ($c['opciones'] ?? '[]');
                return $c;
            })
            ->values()
            ->all();
    }
}
