@props(['menus'])

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Route;
@endphp

@foreach ($menus as $menu)
    @php
        $menu = (array) $menu;
        $children = (array) ($menu['children'] ?? []);
        $hasChildren = !empty($children);
        $url = $menu['url'] ?? '#';
        $href = '#';
        if ($url !== '#') {
            if (Str::startsWith($url, '/')) {
                $href = $url;
            } else {
                $href = Route::has($url) ? route($url) : url($url);
            }
        }
        $isActive = $menu['active'] ?? false;
    @endphp

    @if ($hasChildren)
        <li class="nav-item has-treeview {{ $isActive ? 'menu-open' : '' }}">
            <a href="{{ $href }}" class="nav-link {{ $isActive ? 'active' : '' }}">
                @if(!empty($menu['icono']))
                    <i class="nav-icon {{ $menu['icono'] }}"></i>
                @endif
                <p>
                    {{ $menu['opcion'] }}
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <x-menu-tree :menus="$children" />
            </ul>
        </li>
    @else
        <li class="nav-item">
            <a href="{{ $href }}" class="nav-link {{ $isActive ? 'active' : '' }}">
                @if(!empty($menu['icono']))
                    <i class="nav-icon {{ $menu['icono'] }}"></i>
                @endif
                <p>{{ $menu['opcion'] }}</p>
            </a>
        </li>
    @endif
@endforeach
