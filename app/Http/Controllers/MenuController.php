<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::whereNull('idmenupadre')->with('children')->get();
        return view('menus.index', compact('menus'));
    }

    public function create()
    {
        return view('menus.form', [
            'menus' => Menu::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'url' => ['nullable', 'string'],
            'opcion' => ['required', 'string'],
            'icono' => ['nullable', 'string'],
            'idmenupadre' => ['nullable', 'integer', Rule::exists('menu', 'id')->connection('reportes')],
            'activo' => ['nullable', 'boolean'],
        ]);
        $data['activo'] = $request->boolean('activo');

        Menu::create($data);

        return redirect()->route('menus.index')->with('success', 'Menú creado correctamente');
    }

    public function edit(Menu $menu)
    {
        return view('menus.form', [
            'menu' => $menu,
            'menus' => Menu::where('id', '!=', $menu->id)->get(),
        ]);
    }

    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'url' => ['nullable', 'string'],
            'opcion' => ['required', 'string'],
            'icono' => ['nullable', 'string'],
            'idmenupadre' => ['nullable', 'integer', Rule::exists('menu', 'id')->connection('reportes')],
            'activo' => ['nullable', 'boolean'],
        ]);
        $data['activo'] = $request->boolean('activo');

        if (! empty($data['idmenupadre'])) {
            $menu->load('children');
            if ($data['idmenupadre'] == $menu->id || $this->isDescendant($data['idmenupadre'], $menu)) {
                return back()->withErrors(['idmenupadre' => 'El menú padre no puede ser el mismo ni un descendiente'])->withInput();
            }
        }

        $menu->update($data);

        return redirect()->route('menus.index')->with('success', 'Menú actualizado correctamente');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->children()->exists()) {
            return back()->withErrors(['error' => 'No se puede eliminar un menú con hijos']);
        }
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menú eliminado');
    }

    public function toggle(Menu $menu)
    {
        $menu->activo = ! $menu->activo;
        $menu->save();
        return back()->with('success', 'Estado actualizado');
    }

    private function isDescendant(int $parentId, Menu $menu): bool
    {
        foreach ($menu->children as $child) {
            if ($child->id == $parentId || $this->isDescendant($parentId, $child)) {
                return true;
            }
        }
        return false;
    }
}

