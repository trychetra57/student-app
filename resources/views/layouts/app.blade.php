<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Management System')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3d8bfd;
            --secondary-color: #6c757d;
            --danger-color: #e74c3c;
            --success-color: #23632d;
            --light-bg: #f4f6f8;
        }
        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 70px;
        }
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, #2563eb 100%);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            color: white !important;
        }
        .navbar .nav-link {
            color: rgba(255,255,255,0.8) !important;
            transition: color 0.3s ease;
            font-weight: 500;
        }
        .navbar .nav-link:hover {
            color: white !important;
        }
        .navbar .nav-link.active {
            color: white !important;
            border-bottom: 3px solid white;
            padding-bottom: 0.5rem;
        }
        .user-menu {
            color: rgba(255,255,255,0.9);
            cursor: pointer;
        }
        .main-content {
            min-height: calc(100vh - 70px);
            padding: 30px 0;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e9ecef;
        }
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0;
        }
        .btn {
            font-weight: 600;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(61, 139, 253, 0.3);
        }
        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }
        .btn-danger:hover {
            background-color: #d63031;
            border-color: #d63031;
        }
        .table {
            margin-bottom: 0;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
            color: #495057;
        }
        .table tbody tr {
            transition: background-color 0.2s ease;
        }
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        .alert {
            border-radius: 8px;
            border: none;
            padding: 15px 20px;
            font-weight: 500;
        }
        .alert-success {
            background-color: #e8f7e9;
            color: var(--success-color);
        }
        .alert-danger {
            background-color: #fdecea;
            color: var(--danger-color);
        }
        .alert-warning {
            background-color: #fff3e0;
            color: #ff6f00;
        }
        .form-control {
            border-radius: 6px;
            border: 1px solid #d7dce1;
            padding: 0.7rem 1rem;
        }
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(61, 139, 253, 0.25);
        }
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.8rem;
        }
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            font-weight: 600;
        }
        .badge {
            padding: 0.5rem 0.8rem;
            font-weight: 600;
            border-radius: 20px;
        }
        .badge-active {
            background-color: #d4edda;
            color: var(--success-color);
        }
        .badge-inactive {
            background-color: #f8d7da;
            color: var(--danger-color);
        }
        .badge-graduated {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        .footer {
            background-color: #2c3e50;
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-top: 50px;
        }
        .spinner-border {
            width: 1.5rem;
            height: 1.5rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('students.index') }}">
                <i class="fas fa-graduation-cap"></i> Student Management
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('students.index') ? 'active' : '' }}" href="{{ route('students.index') }}">
                            <i class="fas fa-list"></i> Students
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('students.create') ? 'active' : '' }}" href="{{ route('students.create') }}">
                            <i class="fas fa-plus"></i> Add Student
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> Menu
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('audit.index') }}"><i class="fas fa-history"></i> Audit Logs</a></li>
                            <li><a class="dropdown-item" href="{{ route('api.docs') }}"><i class="fas fa-code"></i> API Docs</a></li>
                            <li><a class="dropdown-item" href="{{ route('backup.index') }}"><i class="fas fa-database"></i> Backups</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
                                    @csrf
                                </form>
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        @if ($errors->any())
            <div class="container">
                <div class="alert alert-danger">
                    <h5><i class="fas fa-exclamation-circle"></i> Validation Errors</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

                <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container-fluid">
            <p>&copy; 2026 Student Management System. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(event, form, message = "Delete this item?") {
            if (event) event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        function confirmAction(message, callback) {
            Swal.fire({
                title: 'Are you sure?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, proceed!'
            }).then((result) => {
                if (result.isConfirmed) {
                    callback();
                }
            });
        }
    </script>
</body>
</html>
