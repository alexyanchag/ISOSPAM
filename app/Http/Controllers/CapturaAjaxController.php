<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CapturaAjaxController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index(Request $request)
    {
        $resp = $this->apiService->get('/capturas-viaje', [
            'viaje_id' => $request->query('viaje_id'),
        ]);

        return response()->json($resp->json(), $resp->status());
    }

    public function show(string $id)
    {
        $resp = $this->apiService->get("/capturas/{$id}");

        return response()->json($resp->json(), $resp->status());
    }

    /**
     * Crea una captura.
     *
     * Además de los campos estándar se aceptan campos dinámicos en el
     * arreglo `respuestas_multifinalitaria`, donde cada elemento debe tener
     * la forma `{"tabla_multifinalitaria_id": int, "respuesta": mixed, "id"?: int}`.
     */
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
            'tipo_numero_individuos' => ['nullable', 'string'],
            'tipo_peso' => ['nullable', 'string'],
            'estado_producto' => ['nullable', 'string'],
        ];

        foreach ($campos as $i => $campo) {
            $rules["respuestas_multifinalitaria.$i.respuesta"] = !empty($campo['requerido'])
                ? ['required']
                : ['nullable'];
            $rules["respuestas_multifinalitaria.$i.tabla_multifinalitaria_id"] = ['nullable', 'integer'];
            $rules["respuestas_multifinalitaria.$i.id"] = ['nullable', 'integer'];
        }

        $request->merge([
            'respuestas_multifinalitaria' => array_values(
                $request->input('respuestas_multifinalitaria', [])
            ),
        ]);

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

        return response()->json($resp->json(), $resp->status());
    }

    /**
     * Actualiza una captura existente.
     *
     * Se aceptan los mismos campos dinámicos descritos en `store`.
     */
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
            'tipo_numero_individuos' => ['nullable', 'string'],
            'tipo_peso' => ['nullable', 'string'],
            'estado_producto' => ['nullable', 'string'],
        ];

        foreach ($campos as $i => $campo) {
            $rules["respuestas_multifinalitaria.$i.respuesta"] = !empty($campo['requerido'])
                ? ['required']
                : ['nullable'];
            $rules["respuestas_multifinalitaria.$i.tabla_multifinalitaria_id"] = ['nullable', 'integer'];
            $rules["respuestas_multifinalitaria.$i.id"] = ['nullable', 'integer'];
        }

        $request->merge([
            'respuestas_multifinalitaria' => array_values(
                $request->input('respuestas_multifinalitaria', [])
            ),
        ]);

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

        return response()->json($resp->json(), $resp->status());
    }

    public function destroy(string $id)
    {
        $resp = $this->apiService->delete("/capturas/{$id}");

        return response()->json($resp->json(), $resp->status());
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

