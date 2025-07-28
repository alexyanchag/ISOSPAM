<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index()
    {
        $response = $this->apiService->get('/menus');
        $menus = $response->successful() ? $response->json() : [];
        return view('menus.index', [
            'menus' => $menus,
        ]);
    }

    public function create()
    {
        return view('menus.form', [
            'menus' => $this->getMenus(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'url' => ['nullable', 'string'],
            'opcion' => ['required', 'string'],
            'nivel' => ['nullable', 'string'],
            'icono' => ['nullable', 'string'],
            'url2' => ['nullable', 'string'],
            'icono2' => ['nullable', 'string'],
            'idmenupadre' => ['nullable', 'integer'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $response = $this->apiService->post('/menus', $data);

        if ($response->successful()) {
            return redirect()->route('menus.index')->with('success', 'Menú creado correctamente');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(string $id)
    {
        $response = $this->apiService->get("/menus/{$id}");
        if (! $response->successful()) {
            abort(404);
        }
        $menu = $response->json();
        return view('menus.form', [
            'menu' => $menu,
            'menus' => $this->getMenus(),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'url' => ['nullable', 'string'],
            'opcion' => ['required', 'string'],
            'nivel' => ['nullable', 'string'],
            'icono' => ['nullable', 'string'],
            'url2' => ['nullable', 'string'],
            'icono2' => ['nullable', 'string'],
            'idmenupadre' => ['nullable', 'integer'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $response = $this->apiService->put("/menus/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('menus.index')->with('success', 'Menú actualizado correctamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/menus/{$id}");

        if ($response->successful()) {
            return redirect()->route('menus.index')->with('success', 'Menú eliminado');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }

    private function getMenus(): array
    {
        $response = $this->apiService->get('/menus');
        return $response->successful() ? $response->json() : [];
    }
}
