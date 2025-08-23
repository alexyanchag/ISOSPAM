<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

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
            'respuestas_multifinalitaria' => ['array'],
            'respuestas_multifinalitaria.*.tabla_multifinalitaria_id' => ['nullable', 'integer'],
            'respuestas_multifinalitaria.*.respuesta' => ['nullable'],
            'respuestas_multifinalitaria.*.id' => ['nullable', 'integer'],
            'respuestas_multifinalitaria.*.campania_id' => ['integer'],
            'respuestas_multifinalitaria.*.tabla_relacionada' => ['string'],
            'respuestas_multifinalitaria.*.nombre_pregunta' => ['string'],
            'respuestas_multifinalitaria.*.tipo_pregunta' => ['string'],
        ];

        $validator = Validator::make($request->all(), $rules);
        $data = $validator->validated();
        
        //return json_encode($data);
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
            'respuestas_multifinalitaria' => ['array'],
            'respuestas_multifinalitaria.*.tabla_multifinalitaria_id' => ['integer'],
            'respuestas_multifinalitaria.*.respuesta' => ['nullable'],
            'respuestas_multifinalitaria.*.id' => ['nullable', 'integer'],
        ];

        $validator = Validator::make($request->all(), $rules);
        $validator->after(function ($validator) use ($request, $campos) {
            $respuestas = collect($request->input('respuestas_multifinalitaria', []))->values();
            $map = $respuestas->keyBy('tabla_multifinalitaria_id');
            foreach ($campos as $campo) {
                if (!empty($campo['requerido'])) {
                    $resp = $map->get($campo['tabla_multifinalitaria_id'] ?? $campo['id']);
                    if (empty($resp) || ($resp['respuesta'] === null || $resp['respuesta'] === '')) {
                        $validator->errors()->add($campo['nombre_pregunta'], 'Este campo es obligatorio.');
                    }
                }
            }
        });

        if ($validator->fails()) {
            $errors = $validator->errors()->getMessages();
            $respuestas = collect($request->input('respuestas_multifinalitaria', []))->values();
            foreach ($validator->errors()->get('respuestas_multifinalitaria.*.respuesta') as $key => $msgs) {
                if (preg_match('/respuestas_multifinalitaria\.(\d+)\.respuesta/', $key, $m)) {
                    $idx = (int) $m[1];
                    $tablaId = $respuestas->get($idx)['tabla_multifinalitaria_id'] ?? null;
                    $campo = collect($campos)->firstWhere('tabla_multifinalitaria_id', $tablaId)
                        ?? collect($campos)->firstWhere('id', $tablaId);
                    $name = $campo['nombre_pregunta'] ?? $key;
                    unset($errors[$key]);
                    $errors[$name] = $msgs;
                }
            }

            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $errors,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data = $validator->validated();
        $respuestas = collect($request->input('respuestas_multifinalitaria', []))->values();

        $campoMap = collect($campos)->keyBy('tabla_multifinalitaria_id');
        $data['respuestas_multifinalitaria'] = $respuestas
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

