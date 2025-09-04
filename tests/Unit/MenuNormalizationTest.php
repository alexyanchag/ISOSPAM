<?php

namespace Tests\Unit;

use App\View\Components\MenuTree;
use App\Http\Controllers\LoginController;
use App\Services\ApiService;
use Mockery;
use ReflectionClass;
use Tests\TestCase;

class MenuNormalizationTest extends TestCase
{
    public function test_menu_tree_handles_new_attribute_names(): void
    {
        $menus = [
            [
                'id' => 1,
                'opcion' => 'Root',
                'route' => '/root',
                'icon_class' => 'root-icon',
                'parent_id' => 0,
                'children' => [
                    [
                        'id' => 2,
                        'opcion' => 'Child',
                        'route' => '/child',
                        'icon_class' => 'child-icon',
                        'parent_id' => 1,
                    ],
                ],
            ],
        ];

        $api = Mockery::mock(ApiService::class);
        $controller = new LoginController($api);
        $ref = new ReflectionClass(LoginController::class);
        $method = $ref->getMethod('normalizeMenus');
        $method->setAccessible(true);

        $normalized = $method->invoke($controller, $menus);

        // parent_id should be normalized to null when value is 0
        $this->assertNull($normalized[0]['parent_id']);
        $this->assertCount(1, $normalized[0]['children']);

        $tree = new MenuTree($normalized);
        $items = $tree->menus->all();

        $this->assertCount(2, $items);
        $this->assertSame(1, $items[0]->id);
        $this->assertNull($items[0]->idmenupadre);
        $this->assertSame('/root', $items[0]->url);
        $this->assertSame('root-icon', $items[0]->icono);

        $this->assertSame(2, $items[1]->id);
        $this->assertSame(1, $items[1]->idmenupadre);
        $this->assertSame('/child', $items[1]->url);
        $this->assertSame('child-icon', $items[1]->icono);
    }
}
