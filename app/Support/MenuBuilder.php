<?php

namespace App\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/**
 * Build hierarchical menus and mark active items.
 */
class MenuBuilder
{
    /**
     * @param array<int, array<string, mixed>> $menus
     * @param int|null $parentId
     * @return array<int, array<string, mixed>>
     */
    public static function build(array $menus, ?int $parentId = null): array
    {
        $branch = [];
        foreach ($menus as $item) {
            $itemParent = $item['idmenupadre'] ?? null;
            if ($itemParent === $parentId) {
                $children = self::build($menus, $item['id']);
                if ($children !== []) {
                    $item['children'] = $children;
                }
                $current = self::isActive($item);
                $childActive = Arr::first($children, fn ($c) => $c['active'] ?? false, false);
                $item['active'] = $current || (bool) $childActive;
                $branch[] = $item;
            }
        }
        return $branch;
    }

    /**
     * Determine if the given menu item matches current request.
     *
     * @param array<string, mixed> $item
     */
    protected static function isActive(array $item): bool
    {
        $url = $item['url'] ?? '';
        if ($url === '' || $url === '#') {
            return false;
        }

        if (Str::startsWith($url, '/')) {
            return request()->is(ltrim($url, '/'));
        }

        return Route::has($url)
            ? request()->routeIs($url)
            : request()->is(trim($url, '/'));
    }
}
