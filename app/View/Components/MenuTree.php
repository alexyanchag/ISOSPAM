<?php

namespace App\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class MenuTree extends Component
{
    /**
     * All menus available for rendering.
     */
    public Collection $menus;

    /**
     * Parent menu id.
     *
     * @var int|null
     */
    public $parentId;

    /**
     * Create a new component instance.
     *
     * @param  int|null  $parentId
     * @return void
     */
    public function __construct(iterable $menus, $parentId = null)
    {
        $this->menus = collect();
        $this->flattenMenus($menus);
        $this->parentId = $parentId;
    }

    private function flattenMenus(iterable $menus, $parentId = null): void
    {
        foreach ($menus as $item) {
            $item = (array) $item;

            $id = isset($item['id']) ? (int) $item['id'] : (isset($item['idmenu']) ? (int) $item['idmenu'] : null);
            $parent = isset($item['idmenupadre'])
                ? (int) $item['idmenupadre']
                : (isset($item['idmenu_padre']) ? (int) $item['idmenu_padre'] : $parentId);
            $parent = $parent === 0 ? null : $parent;

            $menu = (object) [
                'id' => $id,
                'opcion' => $item['opcion'] ?? $item['opcion_menu'] ?? null,
                'url' => $item['url'] ?? $item['url_menu'] ?? null,
                'icono' => $item['icono'] ?? $item['icono_menu'] ?? null,
                'idmenupadre' => $parent,
            ];

            $this->menus->push($menu);

            $children = $item['children']
                ?? $item['hijos']
                ?? $item['menu_hijos']
                ?? $item['menu_hijo']
                ?? $item['submenu']
                ?? $item['submenus']
                ?? [];

            if (is_iterable($children)) {
                $this->flattenMenus($children, $id);
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.menu-tree');
    }
}
