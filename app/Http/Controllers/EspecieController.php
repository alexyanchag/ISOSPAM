<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class EspecieController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index(Request $request)
    {
        $familiaId = $request->query('familia_id');
        if ($familiaId) {
            $response = $this->apiService->get('/especies/por-familia', ['familia_id' => $familiaId]);
        } else {
            $response = $this->apiService->get('/especies');
        }
        $especies = $response->successful() ? $response->json() : [];
        $familia = null;
        if ($familiaId) {
            $respFamilia = $this->apiService->get("/familias/{$familiaId}");
            if ($respFamilia->successful()) {
                $familia = $respFamilia->json();
            }
        }
        return view('especies.index', [
            'especies' => $especies,
            'familiaId' => $familiaId,
            'familia' => $familia,
        ]);
    }

    public function create(Request $request)
    {
        $familias = $this->getFamilias();
        $familiaId = $request->query('familia_id');
        return view('especies.form', [
            'familias' => $familias,
            'familiaId' => $familiaId,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
            'familia_id' => ['required', 'integer'],
        ]);

        $response = $this->apiService->post('/especies', $data);

        if ($response->successful()) {
            $redirect = $data['familia_id']
                ? route('especies.index', ['familia_id' => $data['familia_id']])
                : route('especies.index');
            return redirect($redirect)->with('success', 'Especie creada correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/especies/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $especie = $response->json();
        $familias = $this->getFamilias();
        return view('especies.form', [
            'especie' => $especie,
            'familias' => $familias,
            'familiaId' => $especie['familia_id'] ?? null,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
            'familia_id' => ['required', 'integer'],
        ]);

        $response = $this->apiService->put("/especies/{$id}", $data);

        if ($response->successful()) {
            $redirect = $data['familia_id']
                ? route('especies.index', ['familia_id' => $data['familia_id']])
                : route('especies.index');
            return redirect($redirect)->with('success', 'Especie actualizada correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(Request $request, string $id)
    {
        $familiaId = $request->query('familia_id');
        $response = $this->apiService->delete("/especies/{$id}");

        if ($response->successful()) {
            $redirect = $familiaId
                ? route('especies.index', ['familia_id' => $familiaId])
                : route('especies.index');
            return redirect($redirect)->with('success', 'Especie eliminada');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }

    private function getFamilias(): array
    {
        $response = $this->apiService->get('/familias');
        return $response->successful() ? $response->json() : [];
    }
}
