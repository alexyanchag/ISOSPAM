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

            $id = $this->firstValue($item, ['id', 'idmenu', 'id_menu', 'idMenu', 'menu_id']);
            $id = $id !== null ? (int) $id : null;

            $parent = $this->firstValue(
                $item,
                ['idmenupadre', 'idmenu_padre', 'idMenuPadre', 'id_menu_padre', 'parent_id', 'parentId']
            );
            $parent = $parent !== null ? (int) $parent : $parentId;
            $parent = $parent === 0 ? null : $parent;

            $menu = (object) [
                'id' => $id,
                'opcion' => $this->firstValue($item, ['opcion', 'opcion_menu']),
                'url' => $this->firstValue($item, ['url', 'url_menu', 'route']),
                'icono' => $this->firstValue($item, ['icono', 'icono_menu', 'icon', 'icon_class']),
                'idmenupadre' => $parent,
            ];

            $this->menus->push($menu);

            $children = $this->firstValue(
                $item,
                ['children', 'hijos', 'menu_hijos', 'menu_hijo', 'submenu', 'submenus']
            ) ?? [];

            if (is_iterable($children)) {
                $this->flattenMenus($children, $id);
            }
        }
    }

    private function firstValue(array $item, array $keys)
    {
        foreach ($keys as $key) {
            if (array_key_exists($key, $item)) {
                return $item[$key];
            }
        }

        return null;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.menu-tree');
    }
}
