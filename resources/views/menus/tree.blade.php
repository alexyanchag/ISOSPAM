@foreach($menus as $menu)
    <li>
        <div class="d-flex align-items-center mb-1">
            @if($menu->children->isNotEmpty())
                <button class="btn btn-sm btn-link p-0 me-1 menu-toggle" data-target="#children-{{ $menu->id }}">-</button>
            @else
                <span class="me-3"></span>
            @endif
            <span class="flex-grow-1 {{ $menu->activo ? '' : 'text-muted' }}">{{ $menu->opcion }}</span>
            <div class="btn-group btn-group-sm">
                <a href="{{ route('menus.edit', $menu) }}" class="btn btn-secondary">Editar</a>
                <form action="{{ route('menus.destroy', $menu) }}" method="POST" class="d-inline delete-menu-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger delete-menu-btn">Eliminar</button>
                </form>
                <form action="{{ route('menus.toggle', $menu) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-{{ $menu->activo ? 'warning' : 'success' }}">{{ $menu->activo ? 'Desactivar' : 'Activar' }}</button>
                </form>
            </div>
        </div>
        @if($menu->children->isNotEmpty())
            <ul id="children-{{ $menu->id }}" class="ms-4">
                @include('menus.tree', ['menus' => $menu->children])
            </ul>
        @endif
    </li>
@endforeach
