<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed dark-mode">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            @if(session('user'))
                <li class="nav-item d-lg-none">
                    <a class="nav-link" href="{{ route('embarcaciones.index') }}">
                        <i class="fas fa-ship"></i> Embarcaciones
                    </a>
                </li>
                <li class="nav-item"><a class="nav-link" href="/logout">Logout</a></li>
            @else
                <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
            @endif
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="/" class="brand-link">
            <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <a href="/" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Inicio</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('campanias.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-bullhorn"></i>
                            <p>Campañas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('puertos.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-anchor"></i>
                            <p>Puertos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('muelles.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-water" ></i>
                            <p>Muelles</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('tipoartes.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-palette"></i>
                            <p>Tipos de Arte</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('tipoanzuelos.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-fish"></i>
                            <p>Tipos de Anzuelo</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('tiposinsumo.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-box"></i>
                            <p>Tipos de Insumo</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('materialesmalla.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-layer-group"></i>
                            <p>Materiales de Malla</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitios.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-map-marker-alt"></i>
                            <p>Sitios</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('unidadprofundidad.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-ruler-vertical"></i>
                            <p>Unidad Profundidad</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('unidadlongitud.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-ruler-horizontal"></i>
                            <p>Unidades de Longitud</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('tipotripulantes.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-friends"></i>
                            <p>Tipos de Tripulante</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('tipomotores.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-industry"></i>
                            <p>Tipos de Motor</p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-ship"></i>
                            <p>
                                Tipos de Embarcación
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('tipoembarcaciones.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tipos de Embarcación</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('embarcaciones.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Embarcaciones</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('tipoobservador.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-eye"></i>
                            <p>Tipos de Observador</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('unidadesinsumo.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-weight-hanging"></i>
                            <p>Unidades de Insumo</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('unidadventa.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-cash-register"></i>
                            <p>Unidades de Venta</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('condicionesmar.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-water"></i>
                            <p>Condiciones del Mar</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('estadosmarea.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-tint"></i>
                            <p>Estados de Marea</p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-sitemap"></i>
                            <p>
                                Organizaciones Pesqueras
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('organizacionpesquera.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Organizaciones</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('asignacionresponsable.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Asignar Responsable</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('estadodesarrollogonadal.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-heart"></i>
                            <p>Estado Des. Gonadal</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('personas.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-id-card"></i>
                            <p>Personas</p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-fish"></i>
                            <p>
                                Familias
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('familias.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Familias</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('especies.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Especies</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                Configuraci&oacute;n
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('roles.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Roles</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('menus.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Men&uacute;s</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('rolmenu.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Men&uacute;s por Rol</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('rolpersona.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Roles por Persona</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content pt-3">
            @yield('content')
        </section>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
