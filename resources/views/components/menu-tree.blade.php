@props(['menus', 'parentId' => null])

@php
    $children = $menus->where('idmenupadre', $parentId);
@endphp

@foreach ($children as $menu)
    @php
        $hasChildren = $menus->where('idmenupadre', $menu->id)->isNotEmpty();
        $href = $menu->url && $menu->url !== '#' ? url($menu->url) : '#';
    @endphp

    @if ($hasChildren)
        <li class="nav-item has-treeview">
            <a href="{{ $href }}" class="nav-link">
                <i class="nav-icon {{ $menu->icono }}"></i>
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
                <i class="nav-icon {{ $menu->icono }}"></i>
                <p>{{ $menu->opcion }}</p>
            </a>
        </li>
    @endif
@endforeach
