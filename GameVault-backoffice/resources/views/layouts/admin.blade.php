<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameVault Admin &mdash; @yield('title', 'Pannello')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark px-3 py-2">
        <div class="navigation d-flex align-items-center gap-5">
            <a class="navbar-brand fw-bold" href="{{ route('admin.videogames.index') }}">
                Gamevault Admin
            </a>

            <div class="d-flex text-white gap-4">
                <a class="nav-link" href="{{ route('admin.videogames.index') }}">Videogiochi</a>
                <a class="nav-link" href="{{ route('admin.consoles.index') }}">Consoles</a>
                <a class="nav-link" href="{{ route('admin.developers.index') }}">Sviluppatori</a>
                <a class="nav-link" href="{{ route('admin.genres.index') }}">Generi</a>
                <a class="nav-link" href="{{ route('admin.multiplayer_modes.index') }}">Modalità multiplayer</a>
            </div>
        </div>



        <div class="user-field d-flex align-items-center">
            <span class="text-white me-3">
                <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
            </span>
            <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-box-arrow-right me-1"></i>Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="container mt-4 mb-5">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i><strong>Correggi i seguenti errori:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
