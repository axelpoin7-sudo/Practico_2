<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CapacitaTech') - Centro de Capacitación y Formación Continua</title>
    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --bg-main: #0b0f19;
            --bg-card: rgba(23, 31, 51, 0.75);
            --bg-card-hover: rgba(30, 41, 67, 0.9);
            --border-glass: rgba(255, 255, 255, 0.08);
            --border-accent: rgba(56, 189, 248, 0.3);
            --primary: #38bdf8;
            --primary-hover: #0284c7;
            --secondary: #818cf8;
            --accent: #a855f7;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --text-dim: #64748b;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-main);
            background-image: 
                radial-gradient(at 0% 0%, rgba(56, 189, 248, 0.12) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(139, 92, 246, 0.12) 0px, transparent 50%),
                radial-gradient(at 50% 100%, rgba(16, 185, 129, 0.08) 0px, transparent 50%);
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        h1, h2, h3, h4, .brand-font {
            font-family: 'Outfit', sans-serif;
        }

        /* Glassmorphism Classes */
        .glass-panel {
            background: var(--bg-card);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-glass);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        }

        .glass-header {
            background: rgba(11, 15, 25, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-glass);
        }

        /* Layout Grid */
        .app-container {
            display: flex;
            flex: 1;
            min-height: calc(100vh - 70px);
        }

        .sidebar {
            width: 270px;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(16px);
            border-right: 1px solid var(--border-glass);
            padding: 1.5rem 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        .main-content {
            flex: 1;
            padding: 2rem 2.5rem;
            overflow-y: auto;
            max-width: 1440px;
            margin: 0 auto;
            width: 100%;
        }

        /* Navigation Links */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.75rem 1rem;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 12px;
            font-weight: 500;
            font-size: 0.925rem;
            transition: all 0.2s ease;
            position: relative;
        }

        .nav-item i {
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
            color: var(--text-dim);
            transition: color 0.2s ease;
        }

        .nav-item:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
            transform: translateX(4px);
        }

        .nav-item:hover i {
            color: var(--primary);
        }

        .nav-item.active {
            color: #ffffff;
            background: linear-gradient(135deg, rgba(56, 189, 248, 0.2) 0%, rgba(99, 102, 241, 0.2) 100%);
            border: 1px solid rgba(56, 189, 248, 0.3);
            font-weight: 600;
        }

        .nav-item.active i {
            color: var(--primary);
        }

        .nav-section-title {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-dim);
            padding: 1rem 1rem 0.5rem;
        }

        /* Buttons & Badges */
        .btn-modern {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.65rem 1.25rem;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 10px;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.25s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%);
            color: #ffffff;
        }
        .btn-primary:hover {
            box-shadow: 0 6px 20px rgba(56, 189, 248, 0.4);
            transform: translateY(-2px);
        }

        .btn-accent {
            background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
            color: #ffffff;
        }
        .btn-accent:hover {
            box-shadow: 0 6px 20px rgba(168, 85, 247, 0.4);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            border: 1px solid var(--border-glass);
        }
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .btn-success {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            color: #ffffff;
        }
        .btn-danger {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            color: #ffffff;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.25rem 0.65rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
        .badge-warning { background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); }
        .badge-danger { background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); }
        .badge-info { background: rgba(56, 189, 248, 0.15); color: #7dd3fc; border: 1px solid rgba(56, 189, 248, 0.3); }
        .badge-purple { background: rgba(168, 85, 247, 0.15); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.3); }

        /* Tables */
        .table-container {
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid var(--border-glass);
        }

        table.modern-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.9rem;
        }

        table.modern-table th {
            background: rgba(15, 23, 42, 0.85);
            padding: 1rem 1.25rem;
            font-weight: 600;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-glass);
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        table.modern-table td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            color: #e2e8f0;
        }

        table.modern-table tbody tr {
            transition: background 0.15s ease;
        }

        table.modern-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        /* Forms */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .form-control, .form-select {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid var(--border-glass);
            border-radius: 10px;
            color: #ffffff;
            font-size: 0.925rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            outline: none;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.25);
        }

        .form-select option {
            background-color: #0f172a;
            color: #ffffff;
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.925rem;
        }

        .alert-success { background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.4); color: #34d399; }
        .alert-warning { background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.4); color: #fbbf24; }
        .alert-danger { background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.4); color: #f87171; }

        /* Progress Bars */
        .progress-bar-bg {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 9999px;
            height: 8px;
            overflow: hidden;
            width: 100%;
        }

        .progress-bar-fill {
            height: 100%;
            border-radius: 9999px;
            transition: width 0.4s ease;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--bg-main);
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Top Navbar -->
    <header class="glass-header sticky top-0 z-50">
        <div style="max-width: 1440px; margin: 0 auto; padding: 0.9rem 2.5rem; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 42px; height: 42px; border-radius: 12px; background: linear-gradient(135deg, #0284c7, #8b5cf6); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(56, 189, 248, 0.4);">
                    <i class="fa-solid fa-graduation-cap" style="font-size: 1.3rem; color: #ffffff;"></i>
                </div>
                <div>
                    <a href="{{ route('dashboard') }}" style="text-decoration: none; color: inherit;">
                        <h2 style="font-size: 1.3rem; font-weight: 800; letter-spacing: -0.02em; background: linear-gradient(90deg, #38bdf8, #818cf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">CapacitaTech</h2>
                    </a>
                    <span style="font-size: 0.75rem; color: var(--text-dim); letter-spacing: 0.05em; text-transform: uppercase;">Gestión Integral de Capacitación</span>
                </div>
            </div>

            <!-- Quick Action & Status Badges -->
            <div style="display: flex; align-items: center; gap: 1rem;">
                <span class="badge badge-purple" style="padding: 0.4rem 0.85rem; font-size: 0.8rem;">
                    <i class="fa-solid fa-layer-group"></i> Actividad 2: Eloquent & Tinker
                </span>
                <a href="{{ route('inscripciones.create') }}" class="btn-modern btn-primary">
                    <i class="fa-solid fa-plus-circle"></i> Nueva Inscripción
                </a>
            </div>
        </div>
    </header>

    <div class="app-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="nav-section-title">Principal</div>
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i>
                <span>Panel General</span>
            </a>

            <div class="nav-section-title">Catálogo & Academia</div>
            <a href="{{ route('categorias.index') }}" class="nav-item {{ request()->routeIs('categorias.*') ? 'active' : '' }}">
                <i class="fa-solid fa-tags"></i>
                <span>Categorías</span>
            </a>
            <a href="{{ route('instructores.index') }}" class="nav-item {{ request()->routeIs('instructores.*') ? 'active' : '' }}">
                <i class="fa-solid fa-chalkboard-user"></i>
                <span>Instructores</span>
            </a>
            <a href="{{ route('cursos.index') }}" class="nav-item {{ request()->routeIs('cursos.*') ? 'active' : '' }}">
                <i class="fa-solid fa-book-open"></i>
                <span>Cursos Cortos</span>
            </a>
            <a href="{{ route('paralelos.index') }}" class="nav-item {{ request()->routeIs('paralelos.*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Paralelos & Cupos</span>
            </a>

            <div class="nav-section-title">Inscripciones & Alumnos</div>
            <a href="{{ route('participantes.index') }}" class="nav-item {{ request()->routeIs('participantes.*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-graduate"></i>
                <span>Participantes</span>
            </a>
            <a href="{{ route('inscripciones.index') }}" class="nav-item {{ request()->routeIs('inscripciones.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-signature"></i>
                <span>Inscripciones</span>
            </a>

            <div class="nav-section-title">Reportes & Validación</div>
            <a href="{{ route('reportes.ingresos') }}" class="nav-item {{ request()->routeIs('reportes.ingresos') ? 'active' : '' }}">
                <i class="fa-solid fa-file-invoice-dollar"></i>
                <span>Ingresos por Curso</span>
            </a>
            <a href="{{ route('reportes.tinker') }}" class="nav-item {{ request()->routeIs('reportes.tinker') ? 'active' : '' }}">
                <i class="fa-solid fa-terminal"></i>
                <span>10 Consultas Tinker</span>
            </a>

            <div style="margin-top: auto; padding: 1rem; background: rgba(255, 255, 255, 0.02); border-radius: 12px; border: 1px solid var(--border-glass);">
                <div style="font-size: 0.75rem; color: var(--text-dim); margin-bottom: 0.25rem;">Estado de Base de Datos</div>
                <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8rem; color: #34d399; font-weight: 600;">
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: #10b981; display: inline-block; box-shadow: 0 0 8px #10b981;"></span>
                    SQLite Activo & Validado
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Flash Notifications -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check" style="font-size: 1.25rem;"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning">
                    <i class="fa-solid fa-triangle-exclamation" style="font-size: 1.25rem;"></i>
                    <div>{{ session('warning') }}</div>
                </div>
            @endif

            @if(session('error') || $errors->any())
                <div class="alert alert-danger">
                    <i class="fa-solid fa-circle-xmark" style="font-size: 1.25rem;"></i>
                    <div>
                        @if(session('error'))
                            <div>{{ session('error') }}</div>
                        @endif
                        @if($errors->any())
                            <ul style="margin-left: 1.25rem; margin-top: 0.25rem;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
