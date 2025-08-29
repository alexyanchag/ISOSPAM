<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class ViajeController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index(Request $request)
    {
        $fechaInicio = $request->query('fecha_inicio', now()->startOfMonth()->format('Y-m-d'));
        $fechaFin = $request->query('fecha_fin', now()->format('Y-m-d'));

        $response = $this->apiService->get('/viajes', [
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
        ]);
        $viajes = $response->successful() ? $response->json() : [];

        return view('viajes.index', [
            'viajes' => $viajes,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
        ]);
    }

    public function create(Request $request)
    {
        $campaniaId = $request->query('campania_id');
        $camposDinamicos = $campaniaId ? $this->getCamposDinamicos((int) $campaniaId) : [];

        return view('viajes.form', [
            'muelles' => $this->getMuelles(),
            'puertos' => $this->getPuertos(),
            'embarcaciones' => $this->getEmbarcaciones(),
            'campanias' => $this->getCampanias(),
            'responsables' => $this->getPersonasPorRol('RESPVJ'),
            'digitadores' => $this->getPersonasPorRol('CTF'),
            'camposDinamicos' => $camposDinamicos,
        ]);
    }

    public function store(Request $request)
    {
        $campos = $this->getCamposDinamicos((int) $request->input('campania_id'));

        $rules = [
            'fecha_zarpe' => ['required', 'date'],
            'hora_zarpe' => ['required'],
            'fecha_arribo' => ['nullable', 'date', 'after_or_equal:fecha_zarpe'],
            'hora_arribo' => ['nullable'],
            'observaciones' => ['required', 'string'],
            'muelle_id' => ['nullable', 'integer'],
            'puerto_zarpe_id' => ['nullable', 'integer'],
            'puerto_arribo_id' => ['nullable', 'integer'],
            'persona_idpersona' => ['required', 'integer'],
            'embarcacion_id' => ['required', 'integer'],
            'digitador_id' => ['required', 'integer'],
            'campania_id' => ['required', 'integer'],
        ];

        foreach ($campos as $i => $campo) {
            $rules["respuestas_multifinalitaria.$i.respuesta"] = !empty($campo['requerido'])
                ? ['required']
                : ['nullable'];
            $rules["respuestas_multifinalitaria.$i.tabla_multifinalitaria_id"] = ['nullable', 'integer'];
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

        if (($data['fecha_arribo'] ?? null) && ($data['hora_arribo'] ?? null)
            && $data['fecha_arribo'] === $data['fecha_zarpe']
            && $data['hora_arribo'] <= $data['hora_zarpe']) {
            return back()->withErrors([
                'error' => 'La hora de arribo debe ser mayor que la hora de zarpe cuando las fechas son iguales.',
            ])->withInput();
        }

        $response = $this->apiService->post('/viajes', $data);

        if ($response->successful()) {
            return redirect()->route('viajes.index')->with('success', 'Viaje creado correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/viajes/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $viaje = $response->json();

        $respTripulantes = $this->apiService->get('/tripulantes-viaje', ['viaje_id' => $id]);
        $tripulantes = $respTripulantes->successful() ? $respTripulantes->json() : [];

        $respCapturas = $this->apiService->get('/capturas-viaje', ['viaje_id' => $id]);
        $capturas = $respCapturas->successful() ? $respCapturas->json() : [];

        $campanias = $this->getCampanias();
        $responsables = $this->getPersonasPorRol('RESPVJ');
        $digitadores = $this->getPersonasPorRol('CTF');
        $embarcaciones = $this->getEmbarcaciones();
        $puertos = $this->getPuertos();
        $muelles = $this->getMuelles();

        $respObservadores = $this->apiService->get('/observadores-viaje', ['viaje_id' => $id]);
        $observadores = $respObservadores->successful() ? $respObservadores->json() : [];

        $respParametros = $this->apiService->get('/parametros-ambientales', ['viaje_id' => $id]);
        $parametrosAmbientales = $respParametros->successful() ? $respParametros->json() : [];

        $respEconomia = $this->apiService->get("/economia-insumo-viaje/{$id}");
        $economiaInsumos = $respEconomia->successful() ? $respEconomia->json() : [];

        $respuestasMulti = $viaje['respuestas_multifinalitaria'] ?? [];

        $camposDinamicos = collect($respuestasMulti)
            ->map(fn($r) => [
                'id' => $r['tabla_multifinalitaria_id'] ?? null,
                'nombre_pregunta' => $r['nombre_pregunta'] ?? '',
                'tipo_pregunta' => $r['tipo_pregunta'] ?? 'INPUT',
                'opciones' => is_array($r['opciones'] ?? null)
                    ? json_encode($r['opciones'])
                    : ($r['opciones'] ?? '[]'),
                'requerido' => $r['requerido'] ?? false,
            ])->all();

        return view('viajes.form', [
            'viaje' => $viaje,
            'tripulantes' => $tripulantes,
            'capturas' => $capturas,
            'observadores' => $observadores,
            'parametrosAmbientales' => $parametrosAmbientales,
            'economiaInsumos' => $economiaInsumos,
            'muelles' => $this->getMuelles(),
            'puertos' => $this->getPuertos(),
            'embarcaciones' => $this->getEmbarcaciones(),
            'campanias' => $this->getCampanias(),
            'responsables' => $this->getPersonasPorRol('RESPVJ'),
            'digitadores' => $this->getPersonasPorRol('CTF'),
            'camposDinamicos' => $camposDinamicos,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $respViaje = $this->apiService->get("/viajes/{$id}");
        $campos = $respViaje->successful()
            ? ($respViaje->json()['respuestas_multifinalitaria'] ?? [])
            : [];

        $rules = [
            'fecha_zarpe' => ['required', 'date'],
            'hora_zarpe' => ['required'],
            'fecha_arribo' => ['nullable', 'date', 'after_or_equal:fecha_zarpe'],
            'hora_arribo' => ['nullable'],
            'observaciones' => ['required', 'string'],
            'muelle_id' => ['nullable', 'integer'],
            'puerto_zarpe_id' => ['required', 'integer'],
            'puerto_arribo_id' => ['nullable', 'integer'],
            'persona_idpersona' => ['required', 'integer'],
            'embarcacion_id' => ['required', 'integer'],
            'digitador_id' => ['required', 'integer'],
            'campania_id' => ['required', 'integer'],
        ];

        foreach ($campos as $i => $campo) {
            $rules["respuestas_multifinalitaria.$i.respuesta"] = !empty($campo['requerido'])
                ? ['required']
                : ['nullable'];
            $rules["respuestas_multifinalitaria.$i.tabla_multifinalitaria_id"] = ['nullable', 'integer'];
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

        if (($data['fecha_arribo'] ?? null) && ($data['hora_arribo'] ?? null)
            && $data['fecha_arribo'] === $data['fecha_zarpe']
            && $data['hora_arribo'] <= $data['hora_zarpe']) {
            return back()->withErrors([
                'error' => 'La hora de arribo debe ser mayor que la hora de zarpe cuando las fechas son iguales.',
            ])->withInput();
        }

        $response = $this->apiService->put("/viajes/{$id}", $data);

        if ($response->successful()) {
            if ($request->boolean('por_finalizar')) {
                return redirect()->route('viajes.edit', ['viaje' => $id, 'por_finalizar' => 1])
                    ->with('success', 'Viaje actualizado correctamente');
            }

            return redirect()->route('viajes.index')->with('success', 'Viaje actualizado correctamente');
        }

        if ($request->boolean('por_finalizar')) {
            return redirect()->route('viajes.edit', ['viaje' => $id, 'por_finalizar' => 1])
                ->withErrors(['error' => 'Error al actualizar'])
                ->withInput();
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/viajes/{$id}");

        if ($response->successful()) {
            return redirect()->route('viajes.index')->with('success', 'Viaje eliminado');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }

    public function misPorFinalizar(Request $request)
    {
        $digitadorId = $request->query('digitador_id', session('user.idpersona'));

        $digitadores = $this->getPersonasPorRol('CTF');

        $viajes = [];
        if ($digitadorId) {
            $response = $this->apiService->get("/viajes/por-finalizar/{$digitadorId}");
            $viajes = $response->successful() ? $response->json() : [];
        }

        return view('viajes.mis-por-finalizar', [
            'viajes' => $viajes,
            'digitadores' => $digitadores,
            'digitadorId' => $digitadorId,
        ]);
    }

    public function updatePorFinalizar(Request $request, string $id)
    {
        $data = $request->validate([
            'fecha_zarpe' => ['required', 'date', 'before_or_equal:fecha_arribo'],
            'hora_zarpe' => ['required'],
            'fecha_arribo' => ['required', 'date', 'after_or_equal:fecha_zarpe'],
            'hora_arribo' => ['required'],
            'observaciones' => ['required', 'string'],
            'muelle_id' => ['nullable', 'integer'],
            'puerto_zarpe_id' => ['required', 'integer'],
            'puerto_arribo_id' => ['required', 'integer'],
            'persona_idpersona' => ['required', 'integer'],
            'embarcacion_id' => ['required', 'integer'],
            'digitador_id' => ['required', 'integer'],
            'campania_id' => ['required', 'integer'],
        ]);

        if ($data['fecha_arribo'] === $data['fecha_zarpe'] && $data['hora_arribo'] <= $data['hora_zarpe']) {
            return redirect()
                ->route('viajes.edit', ['viaje' => $id, 'por_finalizar' => 1])
                ->withErrors([
                    'error' => 'La hora de arribo debe ser mayor que la hora de zarpe cuando las fechas son iguales.',
                ])
                ->withInput();
        }

        $response = $this->apiService->put("/viajes/{$id}", $data);
        if ($response->failed()) {
            return redirect()
                ->route('viajes.edit', ['viaje' => $id, 'por_finalizar' => 1])
                ->with('error', 'Error al actualizar')
                ->withErrors(['error' => 'Error al actualizar'])
                ->withInput();
        }

        $final = $this->apiService->post("/viajes/{$id}/finalizar");
        if ($final->successful()) {
            return redirect()
                ->route('viajes.mis-por-finalizar', ['digitador_id' => $data['digitador_id']])
                ->with('success', 'Viaje finalizado correctamente');
        }

        return redirect()
            ->route('viajes.edit', ['viaje' => $id, 'por_finalizar' => 1])
            ->with('error', 'Error al finalizar')
            ->withErrors(['error' => 'Error al finalizar'])
            ->withInput();
    }

    public function pendientes()
    {
        $response = $this->apiService->get('/viajes/pendientes');
        $viajes = $response->successful() ? $response->json() : [];

        return view('viajes.pendientes', [
            'viajes' => $viajes,
        ]);
    }

    public function mostrar(string $id)
    {
        $response = $this->apiService->get("/viajes/{$id}");
        if (! $response->successful()) {
            abort(404);
        }

        $viaje = $response->json();

        $respTripulantes = $this->apiService->get('/tripulantes-viaje', ['viaje_id' => $id]);
        $tripulantes = $respTripulantes->successful() ? $respTripulantes->json() : [];

        $respCapturas = $this->apiService->get('/capturas-viaje', ['viaje_id' => $id]);
        $capturas = $respCapturas->successful() ? $respCapturas->json() : [];

        foreach ($capturas as &$c) {
            if (empty($c['id'])) {
                continue;
            }

            $capturaId = $c['id'];

            $respSitios = $this->apiService->get('/sitios-pesca', ['captura_id' => $capturaId]);
            $c['sitios_pesca'] = $respSitios->successful() ? $respSitios->json() : [];

            $respArtes = $this->apiService->get('/artes-pesca', ['captura_id' => $capturaId]);
            $c['artes_pesca'] = $respArtes->successful() ? $respArtes->json() : [];

            $respEconomiaVentas = $this->apiService->get('/economia-ventas', ['captura_id' => $capturaId]);
            $c['economia_ventas'] = $respEconomiaVentas->successful() ? $respEconomiaVentas->json() : [];

            $respDatosBio = $this->apiService->get('/datos-biologicos', ['captura_id' => $capturaId]);
            $c['datos_biologicos'] = $respDatosBio->successful() ? $respDatosBio->json() : [];

            $respArchivos = $this->apiService->get("/capturas/{$capturaId}/archivos");
            $c['archivos'] = $respArchivos->successful() ? $respArchivos->json() : [];
        }
        unset($c);

        $campanias = $this->getCampanias();
        $responsables = $this->getPersonasPorRol('RESPVJ');
        $digitadores = $this->getPersonasPorRol('CTF');
        $embarcaciones = $this->getEmbarcaciones();
        $puertos = $this->getPuertos();
        $muelles = $this->getMuelles();

        $respObservadores = $this->apiService->get('/observadores-viaje', ['viaje_id' => $id]);
        $observadores = $respObservadores->successful() ? $respObservadores->json() : [];

        $respParametros = $this->apiService->get('/parametros-ambientales', ['viaje_id' => $id]);
        $parametrosAmbientales = $respParametros->successful() ? $respParametros->json() : [];

        $respEconomia = $this->apiService->get("/economia-insumo-viaje/{$id}");
        $economiaInsumos = $respEconomia->successful() ? $respEconomia->json() : [];

        $respuestasMulti = $viaje['respuestas_multifinalitaria'] ?? [];

        $camposDinamicos = collect($respuestasMulti)
            ->map(fn($r) => [
                'id' => $r['tabla_multifinalitaria_id'] ?? null,
                'nombre_pregunta' => $r['nombre_pregunta'] ?? '',
                'tipo_pregunta' => $r['tipo_pregunta'] ?? 'INPUT',
                'opciones' => is_array($r['opciones'] ?? null)
                    ? json_encode($r['opciones'])
                    : ($r['opciones'] ?? '[]'),
                'requerido' => $r['requerido'] ?? false,
            ])->all();

        return view('viajes.mostrar', [
            'viaje' => $viaje,
            'tripulantes' => $tripulantes,
            'capturas' => $capturas,
            'campanias' => $campanias,
            'responsables' => $responsables,
            'digitadores' => $digitadores,
            'embarcaciones' => $embarcaciones,
            'puertos' => $puertos,
            'muelles' => $muelles,
            'observadores' => $observadores,
            'parametrosAmbientales' => $parametrosAmbientales,
            'economiaInsumos' => $economiaInsumos,
            'camposDinamicos' => $camposDinamicos,
        ]);
    }

    public function seleccionar(string $id)
    {
        $digitadorId = session('user.idpersona');

        $response = $this->apiService->post(
            "/viajes/{$id}/seleccionar?viaje_id={$id}&digitador_id={$digitadorId}"
        );

        if ($response->successful()) {
            return redirect()
                ->route('viajes.pendientes')
                ->with('success', 'Viaje asignado correctamente');
        }

        return back()->withErrors(['error' => 'Error al seleccionar el viaje']);
    }

    private function getMuelles(): array
    {
        $response = $this->apiService->get('/muelles');
        return $response->successful() ? $response->json() : [];
    }

    private function getPuertos(): array
    {
        $response = $this->apiService->get('/puertos');
        return $response->successful() ? $response->json() : [];
    }

    private function getEmbarcaciones(): array
    {
        $response = $this->apiService->get('/embarcaciones');
        return $response->successful() ? $response->json() : [];
    }

    private function getCampanias(): array
    {
        $response = $this->apiService->get('/campanias');
        return $response->successful() ? $response->json() : [];
    }

    private function getPersonasPorRol(string $codigoRol): array
    {
        $response = $this->apiService->get("/buscar-personas/{$codigoRol}");
        return $response->successful() ? $response->json() : [];
    }

    private function getCamposDinamicos(int $campaniaId): array
    {
        $response = $this->apiService->get("/campanias/{$campaniaId}");
        if (! $response->successful()) {
            return [];
        }

        $campania = $response->json();
        $campos = $campania['campos'] ?? [];

        return collect($campos)
            ->filter(fn($c) => ($c['tabla_relacionada'] ?? '') === 'viaje')
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
