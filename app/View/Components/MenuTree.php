<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Collection;

class MenuTree extends Component
{
    /**
     * All menus available for rendering.
     *
     * @var \Illuminate\Support\Collection
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
     * @param  iterable  $menus
     * @param  int|null  $parentId
     * @return void
     */
    public function __construct(iterable $menus, $parentId = null)
    {
        $this->menus = collect($menus)->map(function ($item) {
            $item = (array) $item;

            return (object) [
                'id' => $item['id'] ?? $item['idmenu'] ?? null,
                'opcion' => $item['opcion'] ?? $item['opcion_menu'] ?? null,
                'url' => $item['url'] ?? $item['url_menu'] ?? null,
                'icono' => $item['icono'] ?? $item['icono_menu'] ?? null,
                'idmenupadre' => $item['idmenupadre'] ?? $item['idmenu_padre'] ?? null,
            ];
        });
        $this->parentId = $parentId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.menu-tree');
    }
}
