<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { overflow-x: hidden; }
        main { margin-top: 56px; }
        @media (min-width: 992px) {
            #sidebarMenu { --bs-offcanvas-width: 220px; }
            main { margin-left: 220px; }
        }
        body.sidebar-collapsed #sidebarMenu { --bs-offcanvas-width: 60px; }
        body.sidebar-collapsed main { margin-left: 60px; }
        body.sidebar-collapsed #sidebarMenu .offcanvas-title,
        body.sidebar-collapsed #sidebarMenu .menu-text { display: none; }
    </style>
</head>
<body class="bg-dark text-light">
<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <button id="collapseToggle" class="navbar-toggler d-none d-lg-block me-2" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>
        <button class="navbar-toggler d-lg-none me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="/">{{ config('app.name', 'Laravel') }}</a>
        <ul class="navbar-nav flex-row ms-auto">
            @if(session('user'))
                <li class="nav-item"><a class="nav-link px-2" href="/logout">Logout</a></li>
            @else
                <li class="nav-item"><a class="nav-link px-2" href="/login">Login</a></li>
            @endif
        </ul>
    </div>
</nav>
<div id="sidebarMenu" class="offcanvas offcanvas-start offcanvas-lg bg-dark text-light" tabindex="-1">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menú</h5>
        <button type="button" class="btn-close btn-close-white d-lg-none" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="/" class="nav-link text-white">
                    <i class="bi bi-house-fill"></i> <span class="menu-text">Inicio</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white">
                    <i class="bi bi-grid"></i> <span class="menu-text">Opción 1</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white">
                    <i class="bi bi-gear-fill"></i> <span class="menu-text">Opción 2</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white">
                    <i class="bi bi-info-circle-fill"></i> <span class="menu-text">Opción 3</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<main class="pt-3 pt-lg-5 px-3">
    @yield('content')
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('collapseToggle').addEventListener('click', () => {
        document.body.classList.toggle('sidebar-collapsed');
    });
</script>
</body>
</html>
