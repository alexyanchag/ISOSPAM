@foreach($menus as $menu)
    <tr data-menu-id="{{ $menu->id }}" class="{{ isset($parent) ? 'd-none parent-'.$parent : '' }}">
        <td style="padding-left: {{ ($level ?? 0) * 20 }}px; white-space: nowrap;">
            @if($menu->children->isNotEmpty())
                <button class="btn btn-sm btn-link p-0 me-1 menu-toggle" data-id="{{ $menu->id }}"><i class="fa-solid fa-plus"></i></button>
            @else
                <span class="me-3"></span>
            @endif
            <span class="{{ $menu->activo ? '' : 'text-muted' }}">{{ $menu->opcion }}</span>
        </td>
        <td>{{ $menu->url }}</td>
        <td class="text-end" style="width: 200px;">
            <div class="btn-group">
                <a href="{{ route('menus.edit', $menu) }}" class="btn btn-secondary btn-xs">Editar</a>
                <form action="{{ route('menus.destroy', $menu) }}" method="POST" class="d-inline delete-menu-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-xs delete-menu-btn">Eliminar</button>
                </form>
                <form action="{{ route('menus.toggle', $menu) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-{{ $menu->activo ? 'warning' : 'success' }} btn-xs">{{ $menu->activo ? 'Desactivar' : 'Activar' }}</button>
                </form>
            </div>
        </td>
    </tr>
    @if($menu->children->isNotEmpty())
        @include('menus.tree', ['menus' => $menu->children, 'parent' => $menu->id, 'level' => ($level ?? 0) + 1])
    @endif
@endforeach
