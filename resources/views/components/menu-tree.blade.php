@props(['menus', 'parentId' => null])

@php
    use Illuminate\Support\Str;

    $children = $menus->where('idmenupadre', $parentId);
@endphp

@foreach ($children as $menu)
    @php
        $hasChildren = $menus->where('idmenupadre', $menu->id)->isNotEmpty();

        $href = '#';
        if ($menu->url && $menu->url !== '#') {
            $href = Route::has($menu->url) ? route($menu->url) : url($menu->url);
        }

        $icon = trim($menu->icono);
        if ($icon) {
            if (!Str::contains($icon, 'fa-')) {
                $icon = 'fas fa-' . $icon;
            } elseif (!Str::startsWith($icon, ['fas', 'far', 'fab', 'fal', 'fad'])) {
                $icon = 'fas ' . $icon;
            }
        }
    @endphp

    @if ($hasChildren)
        <li class="nav-item has-treeview">
            <a href="{{ $href }}" class="nav-link">
                <i class="nav-icon {{ $icon }}"></i>
                <p>
                    {{ $menu->opcion }}
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <x-menu-tree :menus="$menus" :parent-id="$menu->id" />
            </ul>
        </li>
    @else
        <li class="nav-item">
            <a href="{{ $href }}" class="nav-link">
                <i class="nav-icon {{ $icon }}"></i>
                <p>{{ $menu->opcion }}</p>
            </a>
        </li>
    @endif
@endforeach
