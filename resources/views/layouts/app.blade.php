<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <title>@yield('title', 'Welcome') - HikersHub</title>

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        
        /* --- NAVBAR STYLING --- */
        .navbar { padding: 15px 0; transition: all 0.3s ease; }

        /* Navbar Putih (Standard untuk page selain Home) */
        .navbar-standard { background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .navbar-standard .navbar-brand { color: #2d5016; }
        .navbar-standard .nav-link { color: #555; }
        .navbar-standard .nav-link:hover { color: #28a745; }

        /* Brand Logo */
        .navbar-brand { font-weight: 800; font-size: 1.5rem; display: flex; align-items: center; gap: 8px; letter-spacing: -0.5px; }
        .nav-link { font-weight: 500; margin: 0 10px; transition: color 0.3s; position: relative; }

        /* Active State (Text Hijau) */
        .navbar-standard .nav-link.active { color: #28a745; font-weight: 700; }

        /* Buttons */
        .btn-primary { background-color: #28a745; border-color: #28a745; font-weight: 600; padding: 8px 25px; border-radius: 50px; }
        .btn-primary:hover { background-color: #218838; border-color: #1e7e34; }
        
        /* Footer */
        .footer { background: #2d5016; color: white; padding: 60px 0 30px; margin-top: 0; }
        .footer a { color: rgba(255,255,255,0.7); text-decoration: none; transition: color 0.3s; }
        .footer a:hover { color: white; }
        .footer h5 { font-weight: 700; margin-bottom: 20px; letter-spacing: 0.5px; }

        /* Global Utilities */
        .section-title { font-weight: 700; font-size: 2rem; margin-bottom: 40px; color: #2d5016; }
    </style>
    
    @yield('styles')
</head>
<body>
    
    <nav class="navbar navbar-expand-lg {{ request()->routeIs('home') ? 'navbar-dark fixed-top' : 'navbar-light navbar-standard sticky-top' }}">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="currentColor" style="color: #FF5722;">
                    <path d="M12 2L2 19h20L12 2zm0 3.5l6.5 11.5h-13L12 5.5z"/>
                    <path d="M12 8.5l-3.5 6h7l-3.5-6z" fill="rgba(255,255,255,0.3)"/>
                </svg>
                HikersHub
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('trips.*') ? 'active' : '' }}" href="{{ route('trips.index') }}">Trips</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('mountains.*') ? 'active' : '' }}" href="{{ route('mountains.index') }}">Mountains</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('gallery.*') ? 'active' : '' }}" href="{{ route('gallery.index') }}">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                    </li>
                    
                    @auth
                        @if(auth()->user()->role == 'admin')
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-primary shadow-sm" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-1"></i> Admin
                            </a>
                        </li>
                        @else
                        <li class="nav-item dropdown ms-lg-2">
                            <a class="nav-link dropdown-toggle btn btn-outline-success px-4 py-1 rounded-pill" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" style="border: 2px solid #28a745;">
                                <i class="fas fa-user-circle me-1"></i> {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 mt-2">
                                <li><a class="dropdown-item py-2" href="{{ route('user.dashboard') }}"><i class="fas fa-columns me-2 text-muted"></i> Dashboard</a></li>
                                <li><a class="dropdown-item py-2" href="{{ route('user.bookings.index') }}"><i class="fas fa-ticket-alt me-2 text-muted"></i> My Bookings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @endif
                    @else
                        <li class="nav-item ms-lg-2">
                            <a class="btn {{ request()->routeIs('home') ? 'btn-outline-light' : 'btn-outline-success' }} fw-bold px-4 rounded-pill" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="btn {{ request()->routeIs('home') ? 'btn-light text-success' : 'btn-success' }} fw-bold px-4 rounded-pill" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @if(session('success') || session('error') || $errors->any())
    <div class="container mt-4" style="position: relative; z-index: 1050;">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3">
            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
    </div>
    @endif

    @yield('content')

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="d-flex align-items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style="color: #FF5722;">
                            <path d="M12 2L2 19h20L12 2zm0 3.5l6.5 11.5h-13L12 5.5z"/>
                        </svg>
                        HikersHub
                    </h5>
                    <p class="text-white-50 small mt-3">Your trusted partner for mountain hiking adventures across Indonesia. Safety, fun, and nature combined.</p>
                    <div class="social-icons mt-4">
                        <a href="#" class="me-3 text-white"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="me-3 text-white"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="me-3 text-white"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="me-3 text-white"><i class="fab fa-youtube fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled mt-3">
                        <li class="mb-2"><a href="{{ route('home') }}">Home</a></li>
                        <li class="mb-2"><a href="{{ route('trips.index') }}">All Trips</a></li>
                        <li class="mb-2"><a href="{{ route('mountains.index') }}">Mountains</a></li>
                        <li class="mb-2"><a href="{{ route('about') }}">About Us</a></li>
                    </ul>
                </div>
                <div class="col-md-6 mb-4">
                    <h5>Newsletter</h5>
                    <p class="small text-white-50 mt-3">Join our community to get the latest trip updates and special promos.</p>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control border-0 py-3 ps-4 rounded-start-pill" placeholder="Enter your email address">
                        <button class="btn btn-warning fw-bold text-dark px-4 rounded-end-pill" type="button">Subscribe</button>
                    </div>
                </div>
            </div>
            <hr class="bg-white opacity-25 my-4">
            <div class="text-center text-white-50 small">
                &copy; {{ date('Y') }} HikersHub Indonesia. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>