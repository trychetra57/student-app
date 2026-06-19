<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LEARN Academy — Premium English Language Education Programs, Placement Testing, and Academic Success Services.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LEARN Academy — Premium English Education')</title>
    
    <!-- CSS libraries -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&family=Battambang:wght@300;400;700;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #125875;
            --primary-dark: #0d3f54;
            --primary-light: #e6f2f7;
            --accent: #ff7350;
            --accent-hover: #e05e3c;
            --success: #01aa59;
            --success-hover: #018f4a;
            --bg-light: #f8fafc;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Open Sans', 'Battambang', sans-serif;
            color: var(--text-dark);
            background-color: #ffffff;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ── Header / Navigation ── */
        .navbar-custom {
            background-color: var(--primary);
            padding: 15px 0;
            box-shadow: 0 4px 20px rgba(18, 88, 117, 0.15);
            transition: var(--transition);
            z-index: 1050;
        }
        .navbar-custom .navbar-brand {
            color: white;
            font-weight: 800;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .navbar-custom .navbar-brand i {
            color: var(--accent);
            font-size: 1.8rem;
            animation: pulse 2s infinite;
        }
        .navbar-custom .nav-link {
            color: rgba(255, 255, 255, 0.85);
            font-weight: 600;
            font-size: 0.95rem;
            padding: 8px 16px !important;
            border-radius: 6px;
            transition: var(--transition);
        }
        .navbar-custom .nav-link:hover, 
        .navbar-custom .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .navbar-custom .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            background-color: white;
            padding: 10px;
        }
        .navbar-custom .dropdown-item {
            font-weight: 600;
            padding: 10px 16px;
            border-radius: 8px;
            color: var(--text-dark);
            transition: var(--transition);
        }
        .navbar-custom .dropdown-item:hover {
            background-color: var(--primary-light);
            color: var(--primary);
        }
        .navbar-custom .btn-portal {
            background-color: #ff7350;
            color: white;
            border: none;
            font-weight: 700;
            padding: 10px 24px;
            border-radius: 4px;
            box-shadow: 0 4px 10px rgba(255, 115, 80, 0.2);
            transition: var(--transition);
            text-transform: uppercase;
            font-size: 0.85rem;
        }
        .navbar-custom .btn-portal:hover {
            background-color: #e05e3c;
            color: white;
            transform: translateY(-1px);
        }
        .navbar-custom .btn-enroll {
            background-color: #01aa59;
            color: white;
            border: none;
            font-weight: 700;
            padding: 10px 24px;
            border-radius: 4px;
            box-shadow: 0 4px 10px rgba(1, 170, 89, 0.2);
            transition: var(--transition);
            text-transform: uppercase;
            font-size: 0.85rem;
        }
        .navbar-custom .btn-enroll:hover {
            background-color: #018f4a;
            color: white;
            transform: translateY(-1px);
        }

        /* ── Animations ── */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.08); }
            100% { transform: scale(1); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease forwards;
        }

        /* ── Page Section styling ── */
        main {
            flex: 1;
        }
        .section-padding {
            padding: 80px 0;
        }
        .bg-light-custom {
            background-color: var(--bg-light);
        }
        .section-title {
            font-weight: 800;
            font-size: 2.2rem;
            color: var(--primary);
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }
        .section-title::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background-color: var(--accent);
            margin: 10px auto 0;
            border-radius: 2px;
        }
        .text-center .section-title::after {
            margin-left: auto;
            margin-right: auto;
        }
        .section-subtitle {
            color: var(--text-muted);
            font-size: 1.1rem;
            max-width: 700px;
            margin: 0 auto 50px;
            font-weight: 500;
        }

        /* ── Footer ── */
        .footer-custom {
            background-color: var(--primary-dark);
            color: rgba(255, 255, 255, 0.7);
            padding: 80px 0 30px;
            font-size: 0.95rem;
            border-top: 5px solid var(--accent);
        }
        .footer-custom h5 {
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 25px;
            position: relative;
        }
        .footer-custom h5::after {
            content: '';
            display: block;
            width: 30px;
            height: 2px;
            background-color: var(--accent);
            margin-top: 8px;
        }
        .footer-custom .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .footer-custom .footer-links li {
            margin-bottom: 12px;
        }
        .footer-custom .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: var(--transition);
            display: inline-block;
        }
        .footer-custom .footer-links a:hover {
            color: var(--accent);
            transform: translateX(5px);
        }
        .footer-custom .social-icons {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }
        .footer-custom .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.08);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: var(--transition);
        }
        .footer-custom .social-btn:hover {
            background-color: var(--accent);
            color: white;
            transform: translateY(-3px);
        }
        .footer-custom .contact-info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .footer-custom .contact-info-list li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 15px;
        }
        .footer-custom .contact-info-list i {
            color: var(--accent);
            margin-top: 4px;
        }
        .footer-bottom {
            padding-top: 30px;
            margin-top: 50px;
            border-top: 1px solid rgba(255,255,255,0.08);
            text-align: center;
            font-size: 0.85rem;
        }

        /* ── Responsive adjustments ── */
        @media (max-width: 991px) {
            .navbar-custom .btn-portal, .navbar-custom .btn-enroll {
                width: 100%;
                text-align: center;
                margin-top: 8px;
            }
            .navbar-custom .navbar-nav {
                margin-bottom: 15px;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- ── Header Top Bar (Matches IFA exactly) ── -->
    <div class="header-top d-none d-md-block" style="background-color: var(--primary-dark); border-bottom: 1px solid rgba(255,255,255,0.08); padding: 10px 0;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex gap-3 align-items-center text-white-50" style="font-size: 0.85rem;">
                        <a href="https://facebook.com" target="_blank" class="text-white-50" style="text-decoration:none;"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://instagram.com" target="_blank" class="text-white-50" style="text-decoration:none;"><i class="fab fa-instagram"></i></a>
                        <a href="https://twitter.com" target="_blank" class="text-white-50" style="text-decoration:none;"><i class="fab fa-twitter"></i></a>
                        <a href="https://linkedin.com" target="_blank" class="text-white-50" style="text-decoration:none;"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://youtube.com" target="_blank" class="text-white-50" style="text-decoration:none;"><i class="fab fa-youtube"></i></a>
                        <a href="https://t.me" target="_blank" class="text-white-50" style="text-decoration:none;"><i class="fab fa-telegram"></i></a>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <div class="d-flex justify-content-end gap-4 text-white" style="font-size: 0.85rem; font-weight: 600;">
                        <div>
                            <i class="fas fa-phone-alt text-warning me-2"></i>
                            <a href="tel:+85523888777" class="text-white" style="text-decoration:none;">+855 (0) 23 888 777 / +855 (0) 12 345 678</a>
                        </div>
                        <div>
                            <i class="fas fa-envelope text-warning me-2"></i>
                            <a href="mailto:info@learnacademy.edu.kh" class="text-white" style="text-decoration:none;">info@learnacademy.edu.kh</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ── Header Navigation ── -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-graduation-cap"></i>
                <div>
                    <span style="letter-spacing: 0.5px;">LEARN</span>
                    <span style="font-weight: 300; font-size: 0.85em; display: block; letter-spacing: 1px; color: var(--accent);">ACADEMY</span>
                </div>
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#publicNavbar" aria-controls="publicNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars text-white" style="font-size: 1.5rem;"></i>
            </button>
            
            <div class="collapse navbar-collapse" id="publicNavbar">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('programs') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Programs
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('programs') }}#survival-english">Survival English</a></li>
                            <li><a class="dropdown-item" href="{{ route('programs') }}#nextgen-english">NextGen English</a></li>
                            <li><a class="dropdown-item" href="{{ route('programs') }}#anytime-english">English Anytime Anywhere</a></li>
                            <li><a class="dropdown-item" href="{{ route('programs') }}#academic-writing">Academic Writing</a></li>
                            <li><a class="dropdown-item" href="{{ route('programs') }}#business-english">English for Business</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('programs') }}">All Programs Overview</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tuition') ? 'active' : '' }}" href="{{ route('tuition') }}">Tuition & Dates</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('services') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Services
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('services') }}#language-support">Language Support</a></li>
                            <li><a class="dropdown-item" href="{{ route('services') }}#self-access">Self-access Center</a></li>
                            <li><a class="dropdown-item" href="{{ route('services') }}#internships">Internship Program</a></li>
                            <li><a class="dropdown-item" href="{{ route('services') }}#staff-development">Staff Development</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('events') ? 'active' : '' }}" href="{{ route('events') }}">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('success-hub') ? 'active' : '' }}" href="{{ route('success-hub') }}">Success Hub</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('placement-test') ? 'active' : '' }}" href="{{ route('placement-test') }}">Test English</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="{{ route('placement-test') }}" class="btn btn-enroll">ENROLL</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-portal">PORTAL</a>
                    @else
                        @if(app()->environment('local'))
                            <form action="{{ route('quick-login') }}" method="POST" class="d-inline m-0">
                                @csrf
                                <input type="hidden" name="role" value="super_admin">
                                <button type="submit" class="btn btn-success fw-bold px-3 py-2 text-white border-0 rounded" style="background-color: var(--success); font-size: 0.85rem; font-weight: 700; transition: var(--transition);" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                    QUICK DASHBOARD
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('login') }}" class="btn btn-portal">LOGIN</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- ── Content ── -->
    <main>
        @if(session('success'))
            <div class="container mt-4">
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:12px; border-left: 5px solid var(--success);">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container mt-4">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius:12px; border-left: 5px solid var(--accent);">
                    <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- ── Footer (Matches IFA exactly) ── -->
    <footer class="footer-custom" style="background-color: var(--primary); color: rgba(255, 255, 255, 0.85); padding: 80px 0 0; border-top: 5px solid var(--accent);">
        <div class="container pb-5">
            <div class="row justify-content-between g-4">
                <div class="col-xl-4 col-lg-4 col-sm-12">
                    <h5 class="text-white" style="font-weight: 700; font-size: 1.25rem; margin-bottom: 25px; border-bottom:none;">Follow Us</h5>
                    <div class="d-flex gap-2 mt-3">
                        <a href="https://facebook.com" target="_blank" class="social-btn" style="width: 40px; height: 40px; border-radius: 50%; background-color: rgba(255, 255, 255, 0.08); color: white; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: var(--transition);"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://instagram.com" target="_blank" class="social-btn" style="width: 40px; height: 40px; border-radius: 50%; background-color: rgba(255, 255, 255, 0.08); color: white; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: var(--transition);"><i class="fab fa-instagram"></i></a>
                        <a href="https://twitter.com" target="_blank" class="social-btn" style="width: 40px; height: 40px; border-radius: 50%; background-color: rgba(255, 255, 255, 0.08); color: white; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: var(--transition);"><i class="fab fa-twitter"></i></a>
                        <a href="https://linkedin.com" target="_blank" class="social-btn" style="width: 40px; height: 40px; border-radius: 50%; background-color: rgba(255, 255, 255, 0.08); color: white; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: var(--transition);"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://youtube.com" target="_blank" class="social-btn" style="width: 40px; height: 40px; border-radius: 50%; background-color: rgba(255, 255, 255, 0.08); color: white; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: var(--transition);"><i class="fab fa-youtube"></i></a>
                        <a href="https://t.me" target="_blank" class="social-btn" style="width: 40px; height: 40px; border-radius: 50%; background-color: rgba(255, 255, 255, 0.08); color: white; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: var(--transition);"><i class="fab fa-telegram"></i></a>
                    </div>
                </div>
                
                <div class="col-xl-4 col-lg-4 col-sm-6">
                    <h5 class="text-white" style="font-weight: 700; font-size: 1.25rem; margin-bottom: 25px; border-bottom:none;">Our Links</h5>
                    <ul class="footer-links mt-3" style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 12px;"><a href="{{ route('placement-test') }}" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; transition: var(--transition); display: inline-block;">Admission</a></li>
                        <li style="margin-bottom: 12px;"><a href="{{ route('programs') }}" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; transition: var(--transition); display: inline-block;">Our learning program</a></li>
                        @foreach($publicFooterPages as $pPage)
                            <li style="margin-bottom: 12px;"><a href="{{ route('public.pages.show', $pPage->slug) }}" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; transition: var(--transition); display: inline-block;">{{ $pPage->title }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="col-xl-4 col-lg-4 col-sm-6">
                    <h5 class="text-white" style="font-weight: 700; font-size: 1.25rem; margin-bottom: 25px; border-bottom:none;">Contact Us</h5>
                    <ul class="contact-info-list mt-3" style="list-style: none; padding: 0; color: rgba(255, 255, 255, 0.8);">
                        <li style="display: flex; gap: 12px; margin-bottom: 15px;"><i class="fas fa-phone-alt text-warning mt-1"></i> <span><a href="tel:+85523888777" style="color: inherit; text-decoration: none;">+855 (0) 23 888 777 / +855 (0) 12 345 678</a></span></li>
                        <li style="display: flex; gap: 12px; margin-bottom: 15px;"><i class="fas fa-envelope text-warning mt-1"></i> <span><a href="mailto:info@learnacademy.edu.kh" style="color: inherit; text-decoration: none;">info@learnacademy.edu.kh</a></span></li>
                        <li style="display: flex; gap: 12px; margin-bottom: 15px;"><i class="fas fa-map-marker-alt text-warning mt-1"></i> <span>#125, Street 2004, Sangkat Kakab, Khan Sen Sok, Phnom Penh, Cambodia</span></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="copyright-wrap" style="background-color: var(--primary-dark); padding: 20px 0; border-top: 1px solid rgba(255,255,255,0.08);">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="dropdown">
                            <a class="btn dropdown-toggle text-white-50" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false" style="border: 1px solid rgba(255,255,255,0.2); font-size: 0.8rem; padding: 4px 12px;">
                                English
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="font-size:0.8rem; min-width:80px; padding:0;">
                                <li><a class="dropdown-item" href="#">English</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12 text-center">          
                        
                    </div>
                    <div class="col-lg-4 col-md-4 col-12 text-center text-md-end text-white-50" style="font-size: 0.85rem;">
                        &copy; Copyright@{{ date('Y') }} by <strong>LEARN ACADEMY</strong>, all right reserve
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('scripts')
</body>
</html>
