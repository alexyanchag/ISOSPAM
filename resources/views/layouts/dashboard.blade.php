<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed dark-mode">
    @yield('spinner')
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
                    <li class="nav-item"><a class="btn btn-xs btn-primary" href="{{ url('/logout') }}">Cerrar sesión</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Login</a></li>
                @endif
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ url('/') }}" class="brand-link text-center">
                <img src="{{ asset('images/Isospam-Logotipo_Blanco_Celeste.png') }}"
                    alt="{{ config('app.name', 'Laravel') }}" class="img-fluid" style="max-height: 40px;">
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="nav-link">
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
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-route"></i>
                                <p>
                                    Gesti&oacute;n de Viajes
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('viajes.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Viaje</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('viajes.pendientes') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Viajes pendientes</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('viajes.mis-por-finalizar') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Mis viajes por finalizar</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('puertos.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-anchor"></i>
                                <p>Puertos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('muelles.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-water"></i>
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
                                    Embarcaciones
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
                                        <p>Asignar Presidente</p>
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




                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>
                                    Reportes
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <!-- Operativos -->
                                <li class="nav-header">OPERATIVOS</li>
                                <li class="nav-item"><a href="{{ route('operativos.viajes') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Viajes por periodo</p>
                                    </a></li>
                                <li class="nav-item"><a href="{{ route('operativos.esfuerzo') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Mapa de esfuerzo</p>
                                    </a></li>
                                <li class="nav-item"><a href="{{ route('operativos.productividad') }}"
                                        class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Productividad usuarios</p>
                                    </a></li>

                                <!-- Capturas -->
                                <li class="nav-header">CAPTURAS</li>
                                <li class="nav-item"><a href="{{ route('capturas.top') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Top-N por especie</p>
                                    </a></li>
                                <li class="nav-item"><a href="{{ route('capturas.composicion') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Composición por viaje</p>
                                    </a></li>
                                <li class="nav-item"><a href="{{ route('capturas.tallas') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Capturas por tamaño</p>
                                    </a></li>

                                <!-- Biología -->
                                <li class="nav-header">BIOLOGÍA</li>
                                <li class="nav-item"><a href="{{ route('biologia.tallas') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Estructura de tallas</p>
                                    </a></li>
                                <li class="nav-item"><a href="{{ route('biologia.madurez') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Madurez gonadal</p>
                                    </a></li>
                                <li class="nav-item"><a href="{{ route('biologia.rel_lw') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Relación L–W</p>
                                    </a></li>

                                <!-- Zonas -->
                                <li class="nav-header">ZONAS</li>
                                <li class="nav-item"><a href="{{ route('zonas.sitios') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Sitios más frecuentes</p>
                                    </a></li>

                                <!-- Economía -->
                                <li class="nav-header">ECONOMÍA</li>
                                <li class="nav-item"><a href="{{ route('economia.viaje') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Resumen por viaje</p>
                                    </a></li>
                                <li class="nav-item"><a href="{{ route('economia.precios') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Precio promedio</p>
                                    </a></li>
                                <li class="nav-item"><a href="{{ route('economia.margen') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Margen por arte/zona</p>
                                    </a></li>
                                <li class="nav-item"><a href="{{ route('economia.destino') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Destino de venta</p>
                                    </a></li>
                                <li class="nav-item"><a href="{{ route('economia.insumos') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Insumos por viaje</p>
                                    </a></li>
                                <li class="nav-item"><a href="{{ route('reportes.costos_ingresos') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Costos e ingresos</p>
                                    </a></li>

                                <!-- Flota -->
                                <li class="nav-header">FLOTA</li>
                                <li class="nav-item"><a href="{{ route('flota.inventario') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Inventario</p>
                                    </a></li>
                                <li class="nav-item"><a href="{{ route('flota.productividad') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Productividad</p>
                                    </a></li>
                                <li class="nav-item"><a href="{{ route('flota.tripulacion') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Tripulación</p>
                                    </a></li>
                                <li class="nav-item"><a href="{{ route('flota.seguridad') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Seguridad</p>
                                    </a></li>

                                <!-- Ejecutivos -->
                                <li class="nav-header">EJECUTIVOS</li>
                                <li class="nav-item"><a href="{{ route('kpi.mensual') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>KPI mensual</p>
                                    </a></li>
                                <li class="nav-item"><a href="{{ route('kpi.top_valor') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Top 10 especies por valor</p>
                                    </a></li>
                                <li class="nav-item"><a href="{{ route('kpi.sostenibilidad') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Sostenibilidad</p>
                                    </a></li>
                                <li class="nav-item"><a href="{{ route('kpi.operativo') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Desempeño operativo</p>
                                    </a></li>
                                <li class="nav-item"><a href="{{ route('kpi.interanual') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Comparativo interanual</p>
                                    </a></li>
                                <li class="nav-item"><a href="{{ route('kpi.alertas') }}" class="nav-link"><i
                                            class="far fa-circle nav-icon"></i>
                                        <p>Alertas</p>
                                    </a></li>

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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        const sidebar = document.querySelector('.main-sidebar .sidebar');
        if (sidebar) {
            const savedScroll = sessionStorage.getItem('sidebar-scroll');
            if (savedScroll !== null) {
                sidebar.scrollTop = parseInt(savedScroll, 10);
            }
            sidebar.addEventListener('scroll', () => {
                sessionStorage.setItem('sidebar-scroll', sidebar.scrollTop);
            });

            const treeviews = Array.from(sidebar.querySelectorAll('.nav-item.has-treeview'));
            const openMenuIndexes = JSON.parse(sessionStorage.getItem('sidebar-open-menus') || '[]');

            openMenuIndexes.forEach(index => {
                const element = treeviews[index];
                if (element) {
                    element.classList.add('menu-open');
                    const link = element.querySelector(':scope > a');
                    if (link) {
                        link.classList.add('active');
                    }
                }
            });

            treeviews.forEach((element, idx) => {
                const link = element.querySelector(':scope > a');
                if (link) {
                    link.addEventListener('click', () => {
                        requestAnimationFrame(() => {
                            const openIndexes = treeviews
                                .map((tv, index) => tv.classList.contains('menu-open') ? index : null)
                                .filter(i => i !== null);
                            sessionStorage.setItem('sidebar-open-menus', JSON.stringify(openIndexes));
                        });
                    });
                }
            });
        }

        $(document).on('submit', 'form', function () {
            $('.spinner-overlay').removeClass('d-none');
        });

        $(document).ajaxComplete(function () {
            $('.spinner-overlay').addClass('d-none');
        });

        $(window).on('pageshow', function () {
            $('.spinner-overlay').addClass('d-none');
        });
    </script>
    @yield('scripts')
</body>

</html>
