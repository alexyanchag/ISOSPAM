<?php

namespace Tests\Unit;

use Tests\TestCase;

class MenuTreeViewTest extends TestCase
{
    public function test_renders_with_arrays_and_objects(): void
    {
        $arrayMenus = [
            [
                'opcion' => 'Parent',
                'url' => '#',
                'children' => [
                    ['opcion' => 'Child', 'url' => '/child']
                ],
            ],
        ];

        $child = new \stdClass();
        $child->opcion = 'Child';
        $child->url = '/child';

        $parent = new \stdClass();
        $parent->opcion = 'Parent';
        $parent->url = '#';
        $parent->children = [$child];

        $objectMenus = [$parent];

        $arrayHtml = view('components.menu-tree', ['menus' => $arrayMenus])->render();
        $objectHtml = view('components.menu-tree', ['menus' => $objectMenus])->render();

        $this->assertSame($arrayHtml, $objectHtml);
    }

    public function test_renders_sublevels_when_menu_has_children(): void
    {
        $menus = [
            [
                'opcion' => 'Parent',
                'url' => '#',
                'children' => [
                    ['opcion' => 'Child', 'url' => '/child'],
                ],
            ],
        ];

        $html = view('components.menu-tree', ['menus' => $menus])->render();

        $this->assertStringContainsString('<ul class="nav nav-treeview">', $html);
    }
}
