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
            <ul class="navbar-nav ml-auto align-items-center">
                @if(session('roles'))
                    <li class="nav-item">
                        <form id="role-switcher" method="POST" action="{{ url('roles/seleccionar') }}" class="mb-0">
                            @csrf
                            <select name="id" class="form-control form-control-sm" onchange="this.form.submit()">
                                @foreach(session('roles', []) as $rol)
                                    <option value="{{ $rol['id'] }}" {{ session('active_role.id') == $rol['id'] ? 'selected' : '' }}>
                                        {{ $rol['nombrerol'] ?? $rol['id'] }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </li>
                @endif
                @if(session('user'))
                    <li class="nav-item ml-2"><a class="btn btn-xs btn-primary" href="{{ url('/logout') }}">Cerrar sesión</a></li>
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
                        @if(session('active_role.menu'))
                            <x-menu-tree :menus="session('active_role.menu')" />
                        @endif
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
