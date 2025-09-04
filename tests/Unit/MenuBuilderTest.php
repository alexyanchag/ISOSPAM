<?php

namespace Tests\Unit;

use App\Support\MenuBuilder;
use Tests\TestCase;

class MenuBuilderTest extends TestCase
{
    public function test_builds_nested_structure(): void
    {
        $menus = [
            ['id' => 1, 'opcion' => 'Root', 'url' => '#', 'idmenupadre' => null],
            ['id' => 2, 'opcion' => 'Child', 'url' => '/child', 'idmenupadre' => 1],
            ['id' => 3, 'opcion' => 'Leaf', 'url' => '/child/leaf', 'idmenupadre' => 2],
        ];

        $tree = MenuBuilder::build($menus);

        $this->assertCount(1, $tree);
        $this->assertArrayHasKey('children', $tree[0]);
        $this->assertCount(1, $tree[0]['children']);
        $this->assertCount(1, $tree[0]['children'][0]['children']);
        $this->assertSame('Leaf', $tree[0]['children'][0]['children'][0]['opcion']);
    }
}
