<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MenuTree extends Component
{
    /**
     * All menus available for rendering.
     */
    public array $menus;

    /**
     * Create a new component instance.
     */
    public function __construct(array $menus = [])
    {
        $this->menus = $menus;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.menu-tree');
    }
}
