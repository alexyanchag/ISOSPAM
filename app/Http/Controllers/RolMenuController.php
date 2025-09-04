<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class RolMenuController extends Controller
{
    public function __construct(private ApiService $apiService)
    {
    }

    public function index(Request $request)
    {
        $roleId = $request->query('idrol');
        $query = $roleId ? ['idrol' => $roleId] : [];
        $response = $this->apiService->get('/rolmenu', $query);
        $items = $response->successful() ? $response->json() : [];
        if ($roleId) {
            $items = array_filter($items, fn($item) => ($item['idrol'] ?? null) == $roleId);
        }
        return view('rolmenu.index', [
            'items' => $items,
            'roles' => $this->getRoles(),
            'selectedRole' => $roleId,
        ]);
    }

    public function create()
    {
        return view('rolmenu.form', [
            'roles' => $this->getRoles(),
            'menus' => $this->getMenus(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'idrol' => ['required', 'integer'],
            'idmenu' => ['required', 'integer'],
            'acceso' => ['required', 'integer'],
        ]);

        $response = $this->apiService->post('/rolmenu', $data);

        if ($response->successful()) {
            return redirect()->route('rolmenu.index')->with('success', 'Asignación creada');
        }

        return back()->withErrors(['error' => 'Error al crear'])->withInput();
    }

    public function edit(int $idrol, int $idmenu)
    {
        $response = $this->apiService->get("/rolmenu/{$idrol}/{$idmenu}");
        if (! $response->successful()) {
            abort(404);
        }
        $item = $response->json();
        return view('rolmenu.form', [
            'item' => $item,
            'roles' => $this->getRoles(),
            'menus' => $this->getMenus(),
        ]);
    }

    public function update(Request $request, int $idrol, int $idmenu)
    {
        $data = $request->validate([
            'acceso' => ['required', 'integer'],
        ]);

        $response = $this->apiService->put("/rolmenu/{$idrol}/{$idmenu}", $data);

        if ($response->successful()) {
            return redirect()->route('rolmenu.index')->with('success', 'Asignación actualizada');
        }

        return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
    }

    public function destroy(int $idrol, int $idmenu)
    {
        $response = $this->apiService->delete("/rolmenu/{$idrol}/{$idmenu}");

        if ($response->successful()) {
            return redirect()->route('rolmenu.index')->with('success', 'Asignación eliminada');
        }

        return back()->withErrors(['error' => 'Error al eliminar']);
    }

    private function getRoles(): array
    {
        $response = $this->apiService->get('/roles');
        return $response->successful() ? $response->json() : [];
    }

    private function getMenus(): array
    {
        $response = $this->apiService->get('/menus');
        return $response->successful() ? $response->json() : [];
    }
}
