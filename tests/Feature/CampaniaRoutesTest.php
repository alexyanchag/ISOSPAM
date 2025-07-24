<?php

namespace Tests\Feature;

use Tests\TestCase;

class CampaniaRoutesTest extends TestCase
{
    public function test_campania_edit_route_exists(): void
    {
        $url = route('campanias.edit', 1);
        $this->assertStringEndsWith('/campanias/1/edit', $url);
    }
}
