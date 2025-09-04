@php
    $children = $menus->where('idmenupadre', $parentId);
@endphp

@foreach ($children as $menu)
    @php
        $hasChildren = $menus->where('idmenupadre', $menu->id)->isNotEmpty();
        $href = $menu->url && $menu->url !== '#' ? url($menu->url) : '#';
    @endphp
    <li class="nav-item {{ $hasChildren ? 'has-treeview' : '' }}">
        <a href="{{ $href }}" class="nav-link">
            <i class="nav-icon {{ $menu->icono }}"></i>
            <p>
                {{ $menu->opcion }}
                @if ($hasChildren)
                    <i class="right fas fa-angle-left"></i>
                @endif
            </p>
        </a>
        @if ($hasChildren)
            <ul class="nav nav-treeview">
                <x-menu-tree :menus="$menus" :parent-id="$menu->id" />
            </ul>
        @endif
    </li>
@endforeach
