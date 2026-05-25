<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BelTei University Admin — Student Management System">
    <title>@yield('title', 'Student Management System')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 260px;
            --topbar-height: 64px;
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --primary-light: #e0e7ff;
            --sidebar-bg: #0f172a;
            --sidebar-text: rgba(255,255,255,0.7);
            --sidebar-active: #4f46e5;
            --danger: #e11d48;
            --success: #16a34a;
            --warning: #d97706;
            --surface: #ffffff;
            --bg: #f0f2f8;
            --border: #e2e8f0;
            --text: #1e293b;
            --text-muted: #94a3b8;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            margin: 0;
            overflow-x: hidden;
        }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
            overflow-y: auto;
        }
        .sidebar-brand {
            padding: 22px 24px 18px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        .sidebar-brand .brand-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--primary), #818cf8);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            color: white;
            flex-shrink: 0;
        }
        .sidebar-brand .brand-text {
            font-size: 0.95rem;
            font-weight: 700;
            color: white;
            line-height: 1.2;
        }
        .sidebar-brand .brand-sub {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.4);
            font-weight: 400;
        }
        .sidebar-nav {
            padding: 16px 0;
            flex: 1;
        }
        .nav-section {
            padding: 8px 20px 4px;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.25);
            margin-top: 8px;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 20px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
            margin: 2px 10px;
            border-radius: 10px;
        }
        .sidebar-link:hover {
            background: rgba(255,255,255,0.08);
            color: white;
        }
        .sidebar-link.active {
            background: rgba(79,70,229,0.2);
            color: #818cf8;
            border-left: 3px solid #818cf8;
        }
        .sidebar-link .sl-icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.85rem;
            flex-shrink: 0;
            background: rgba(255,255,255,0.06);
        }
        .sidebar-link.active .sl-icon { background: rgba(79,70,229,0.3); }
        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar-user .su-avatar {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg,#4f46e5,#818cf8);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 0.85rem;
            flex-shrink: 0;
        }
        .sidebar-user .su-name {
            font-size: 0.8rem;
            font-weight: 600;
            color: white;
        }
        .sidebar-user .su-role {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.4);
        }
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1039;
        }

        /* ── Topbar ── */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: white;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            z-index: 1030;
            transition: left 0.3s ease;
        }
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .sidebar-toggle {
            width: 38px; height: 38px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: white;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            font-size: 1rem;
            color: #64748b;
            transition: all 0.2s;
        }
        .sidebar-toggle:hover { background: var(--primary-light); color: var(--primary); }
        .topbar-breadcrumb {
            font-size: 0.82rem;
            color: var(--text-muted);
        }
        .topbar-breadcrumb strong { color: var(--text); }
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .topbar-btn {
            width: 38px; height: 38px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: white;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.9rem;
            color: #64748b;
            cursor: pointer;
            position: relative;
            transition: all 0.2s;
            text-decoration: none;
        }
        .topbar-btn:hover { background: var(--primary-light); color: var(--primary); border-color: #bfdbfe; }
        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 14px 6px 8px;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: white;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }
        .topbar-user:hover { background: var(--primary-light); border-color: #bfdbfe; }
        .topbar-user .tu-avatar {
            width: 30px; height: 30px;
            border-radius: 8px;
            background: linear-gradient(135deg,#4f46e5,#818cf8);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 0.75rem;
        }
        .topbar-user .tu-name {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text);
        }

        /* ── Main Content ── */
        .main-wrap {
            margin-left: var(--sidebar-width);
            padding-top: var(--topbar-height);
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        .main-content { padding: 28px; }

        /* ── Cards / Common ── */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            margin-bottom: 20px;
        }
        .card-header {
            background: white;
            border-bottom: 1px solid var(--border);
            border-radius: 16px 16px 0 0 !important;
            font-weight: 700;
            padding: 18px 24px;
            color: var(--text);
            font-size: 0.92rem;
        }
        .card-header i { color: var(--primary); margin-right: 8px; }
        .card-body { padding: 24px; }
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
        }
        .page-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--text);
            margin: 0;
            letter-spacing: -0.5px;
        }
        .page-title i { color: var(--primary); margin-right: 10px; }

        /* ── Buttons ── */
        .btn {
            font-weight: 600;
            border-radius: 10px;
            font-size: 0.875rem;
            padding: 9px 18px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 4px 14px rgba(79,70,229,0.35); }
        .btn-secondary { background: #f1f5f9; border-color: #e2e8f0; color: #475569; }
        .btn-secondary:hover { background: #e2e8f0; color: #1e293b; }
        .btn-danger { background: var(--danger); border-color: var(--danger); }
        .btn-danger:hover { background: #be123c; border-color: #be123c; transform: translateY(-1px); }
        .btn-outline-primary { color: var(--primary); border-color: var(--primary); }
        .btn-outline-primary:hover { background: var(--primary); color: white; }
        .btn-success { background: var(--success); border-color: var(--success); color: white; }
        .btn-success:hover { background: #15803d; border-color: #15803d; color: white; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(22,163,74,0.35); }
        .btn-outline-danger { color: var(--danger); border-color: var(--danger); }
        .btn-outline-danger:hover { background: var(--danger); color: white; }

        /* ── Forms ── */
        .form-control, .form-select {
            border-radius: 10px;
            border: 1.5px solid var(--border);
            padding: 9px 14px;
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79,70,229,0.12);
        }
        .form-label {
            font-weight: 600;
            font-size: 0.82rem;
            color: #475569;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        /* ── Table ── */
        .table { margin-bottom: 0; font-size: 0.875rem; }
        .table th {
            background: #f8fafc;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            border-bottom: 2px solid var(--border);
            padding: 13px 16px;
        }
        .table td { padding: 13px 16px; vertical-align: middle; border-color: var(--border); }
        .table tbody tr { transition: background 0.15s; }
        .table tbody tr:hover { background: #f8fafc; }

        /* ── Badges ── */
        .badge { padding: 5px 11px; font-weight: 600; border-radius: 20px; font-size: 0.75rem; }
        .badge-active  { background: #dcfce7; color: #15803d; }
        .badge-inactive { background: #ffe4e6; color: #be123c; }
        .badge-graduated { background: #ede9fe; color: #5b21b6; }

        /* ── Alerts ── */
        .alert { border: none; border-radius: 12px; padding: 14px 20px; font-weight: 500; font-size: 0.875rem; }
        .alert-success { background: #f0fdf4; color: #15803d; border-left: 4px solid #16a34a; }
        .alert-danger  { background: #fff1f2; color: #be123c; border-left: 4px solid #e11d48; }
        .alert-warning { background: #fffbeb; color: #92400e; border-left: 4px solid #d97706; }
        .invalid-feedback { font-size: 0.78rem; }

        /* ── Footer ── */
        .footer {
            background: white;
            border-top: 1px solid var(--border);
            padding: 16px 28px;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.8rem;
        }

        /* ── Responsive ── */
        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay.open { display: block; }
            .topbar { left: 0; }
            .main-wrap { margin-left: 0; }
        }

        /* ── Desktop Sidebar Collapsed ── */
        @media (min-width: 992px) {
            body.sidebar-collapsed .sidebar { transform: translateX(-100%); }
            body.sidebar-collapsed .topbar  { left: 0; }
            body.sidebar-collapsed .main-wrap { margin-left: 0; }
        }

        @media (max-width: 576px) {
            .main-content { padding: 16px; }
            .page-title { font-size: 1.2rem; }
            .topbar { padding: 0 16px; }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ── Sidebar ── -->
    <aside class="sidebar" id="sidebar">
        <a class="sidebar-brand" href="{{ route('dashboard') }}">
            <div class="brand-icon"><i class="fas fa-graduation-cap"></i></div>
            <div>
                <div class="brand-text">BelTei University</div>
                <div class="brand-sub">Admin Panel</div>
            </div>
        </a>

        <nav class="sidebar-nav">
            <div class="nav-section">Main</div>
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="sl-icon"><i class="fas fa-chart-pie"></i></span> Dashboard
            </a>
            <a href="{{ route('students.index') }}" class="sidebar-link {{ request()->routeIs('students.*') && !request()->routeIs('students.create') ? 'active' : '' }}">
                <span class="sl-icon"><i class="fas fa-users"></i></span> All Students
            </a>
            <a href="{{ route('students.create') }}" class="sidebar-link {{ request()->routeIs('students.create') ? 'active' : '' }}">
                <span class="sl-icon"><i class="fas fa-user-plus"></i></span> Add Student
            </a>
            <a href="{{ route('teachers.index') }}" class="sidebar-link {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
                <span class="sl-icon"><i class="fas fa-chalkboard-teacher"></i></span> Teachers
            </a>
            <a href="{{ route('classes.index') }}" class="sidebar-link {{ request()->routeIs('classes.*') ? 'active' : '' }}">
                <span class="sl-icon"><i class="fas fa-door-open"></i></span> Classes
            </a>
            <a href="{{ route('students.export') }}" class="sidebar-link">
                <span class="sl-icon"><i class="fas fa-file-csv"></i></span> Export CSV
            </a>

            <div class="nav-section">System</div>
            @if(Auth::user()->isSuperAdmin())
            <a href="{{ route('audit.index') }}" class="sidebar-link {{ request()->routeIs('audit.*') ? 'active' : '' }}">
                <span class="sl-icon"><i class="fas fa-history"></i></span> Audit Logs
            </a>
            <a href="{{ route('backup.index') }}" class="sidebar-link {{ request()->routeIs('backup.*') ? 'active' : '' }}">
                <span class="sl-icon"><i class="fas fa-database"></i></span> Backups
            </a>
            @endif
            @if(Auth::user()->isAdmin())
            <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <span class="sl-icon"><i class="fas fa-user-shield"></i></span> User Management
            </a>
            @endif
            <a href="{{ route('api.docs') }}" class="sidebar-link {{ request()->routeIs('api.docs') ? 'active' : '' }}">
                <span class="sl-icon"><i class="fas fa-code"></i></span> API Docs
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="su-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                <div>
                    <div class="su-name">{{ Auth::user()->name }}</div>
                    <div class="su-role">{{ ucwords(str_replace('_', ' ', Auth::user()->role ?? 'staff')) }}</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- ── Topbar ── -->
    <header class="topbar">
        <div class="topbar-left">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="topbar-breadcrumb d-none d-md-block">
                <strong>@yield('title', 'Dashboard')</strong>
            </div>
        </div>
        <div class="topbar-right">
            <a href="{{ route('students.create') }}" class="topbar-btn" title="Add Student">
                <i class="fas fa-plus"></i>
            </a>
            <a href="{{ route('students.export') }}" class="topbar-btn" title="Export CSV">
                <i class="fas fa-download"></i>
            </a>
            <div class="dropdown">
                <a class="topbar-user dropdown-toggle" href="#" data-bs-toggle="dropdown" style="text-decoration:none;">
                    <div class="tu-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                    <span class="tu-name d-none d-md-inline">
                        {{ Auth::user()->name }} 
                        <span class="text-muted" style="font-size: 0.75rem;">({{ ucwords(str_replace('_', ' ', Auth::user()->role ?? 'staff')) }})</span>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-1">
                    <li><h6 class="dropdown-header">{{ Auth::user()->email }}</h6></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- ── Main Wrap ── -->
    <div class="main-wrap">
        <main class="main-content">

            {{-- Alerts --}}
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="footer">
            &copy; {{ date('Y') }} BelTei University Admin &mdash; Student Management System
        </footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggle  = document.getElementById('sidebarToggle');
        const isMobile = () => window.innerWidth < 992;

        toggle.addEventListener('click', () => {
            if (isMobile()) {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('open');
            } else {
                document.body.classList.toggle('sidebar-collapsed');
            }
        });
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('open');
        });

        // Confirm delete helper
        function confirmDelete(event, form, message = 'Delete this item?') {
            if (event) event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete it!',
                borderRadius: '16px'
            }).then(result => { if (result.isConfirmed) form.submit(); });
        }

        function confirmAction(message, callback) {
            Swal.fire({
                title: 'Are you sure?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, proceed!'
            }).then(result => { if (result.isConfirmed) callback(); });
        }
    </script>
    @yield('scripts')
</body>
</html>
