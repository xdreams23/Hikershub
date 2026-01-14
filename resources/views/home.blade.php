@extends('layouts.app')

@section('title', 'Home - Explore Mountains')

@section('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    /* --- VARIABLE WARNA --- */
    :root {
        --primary-dark: #2c5f2d;
        --accent-color: #e5732d;
        --orange-custom: #FF5722;
        --bg-off-white: #f8f9fa;
    }

    /* --- ANIMASI HERO SECTION (CSS MURNI) --- */
    /* Membuat elemen muncul dari bawah ke atas */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Membuat elemen muncul dari atas ke bawah (untuk teks kecil) */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Class untuk dipasang di HTML Hero */
    .hero-animate-up {
        opacity: 0; /* Mulai invisible */
        animation: fadeInUp 1s ease-out forwards;
    }

    .hero-animate-down {
        opacity: 0;
        animation: fadeInDown 1s ease-out forwards;
    }

    /* Delay agar muncul bergantian */
    .delay-100 { animation-delay: 0.2s; }
    .delay-200 { animation-delay: 0.4s; }
    .delay-300 { animation-delay: 0.6s; }
    .delay-500 { animation-delay: 0.8s; }


    /* --- NAVBAR STYLES (SAMA SEPERTI SEBELUMNYA) --- */
    .navbar {
        background-color: transparent !important;
        box-shadow: none !important;
        transition: all 0.4s ease; /* Transisi diperhalus */
    }
    .navbar:not(.scrolled) .navbar-brand { color: white !important; }
    .navbar:not(.scrolled) .nav-link { color: rgba(255,255,255,0.9) !important; }
    .navbar:not(.scrolled) .nav-link.active { 
        color: white !important; 
        border-bottom: 2px solid white; 
    }
    .navbar:not(.scrolled) .nav-link.active::after { display: none; }
    .navbar:not(.scrolled) .btn-nav-auth { 
        border-color: white !important; 
        color: white !important; 
    }
    .navbar:not(.scrolled) .btn-nav-auth:hover { 
        background-color: var(--orange-custom) !important; 
        border-color: var(--orange-custom) !important; 
        color: white !important; 
    }

    .navbar.scrolled {
        background-color: rgba(20, 30, 20, 0.95) !important;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
        padding-top: 12px !important;
        padding-bottom: 12px !important;
    }
    .navbar.scrolled .navbar-brand { color: white !important; }
    .navbar.scrolled .nav-link { color: rgba(255,255,255,0.9) !important; }
    .navbar.scrolled .nav-link:hover, 
    .navbar.scrolled .nav-link.active { color: var(--orange-custom) !important; }

    /* --- HERO SECTION --- */
    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.6)), url('{{ asset("images/Elvin.jpg") }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        height: 100vh; 
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
        position: relative;
        margin: 0;
        padding: 0;
    }

    /* --- BUTTONS & SCROLL --- */
    .btn-accent { 
        background-color: var(--orange-custom); 
        border: none; 
        color: white; 
        transition: all 0.3s ease; 
    }
    .btn-accent:hover { 
        background-color: #d84315; 
        color: white; 
        transform: translateY(-2px); 
        box-shadow: 0 5px 15px rgba(255, 87, 34, 0.4); 
    }
    
    .scroll-down { 
        position: absolute; 
        bottom: 30px; 
        left: 50%; 
        transform: translateX(-50%); 
        animation: bounce 2s infinite; 
        opacity: 0.8; 
        color: white; 
        text-decoration: none; 
        cursor: pointer; 
        /* Tambahkan animasi fade in untuk tombol scroll ini juga */
        opacity: 0;
        animation: fadeInUp 1s ease-out 1.2s forwards, bounce 2s infinite 1.2s; 
    }
    @keyframes bounce { 
        0%, 20%, 50%, 80%, 100% {transform: translateY(0) translateX(-50%);} 
        40% {transform: translateY(-10px) translateX(-50%);} 
        60% {transform: translateY(-5px) translateX(-50%);} 
    }

    /* --- CAROUSEL & CARDS --- */
    .carousel-container { position: relative; padding: 0 10px; }
    .trip-carousel { 
        display: flex; 
        overflow-x: auto; 
        scroll-behavior: smooth; 
        gap: 30px; 
        padding: 20px 10px 40px 10px; 
        -ms-overflow-style: none; 
        scrollbar-width: none; 
    }
    .trip-carousel::-webkit-scrollbar { display: none; }
    .trip-card-wrapper { min-width: 320px; max-width: 320px; flex: 0 0 auto; }
    
    .carousel-btn { 
        position: absolute; top: 45%; transform: translateY(-50%); 
        width: 50px; height: 50px; border-radius: 50%; 
        background: white; border: 1px solid #eee; 
        box-shadow: 0 4px 10px rgba(0,0,0,0.1); 
        z-index: 10; display: flex; align-items: center; justify-content: center; 
        cursor: pointer; transition: all 0.3s ease; color: var(--primary-dark); 
    }
    .carousel-btn:hover { background: var(--primary-dark); color: white; transform: scale(1.1) translateY(-45%); }
    .carousel-btn.prev { left: -20px; } 
    .carousel-btn.next { right: -20px; }
    @media (max-width: 768px) { .carousel-btn { display: none; } }

    .trip-card { 
        border-radius: 24px; background: white; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.05); 
        transition: all 0.4s; overflow: hidden; 
        height: 100%; display: flex; flex-direction: column; 
    }
    .trip-card:hover { 
        transform: translateY(-10px); 
        box-shadow: 0 20px 40px rgba(0,0,0,0.12); 
    }
    
    .card-img-wrapper { height: 220px; position: relative; overflow: hidden; }
    .card-img-wrapper img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
    .trip-card:hover .card-img-wrapper img { transform: scale(1.1); }
    
    .badge-difficulty { 
        position: absolute; top: 15px; left: 15px; 
        background: rgba(255,255,255,0.95); backdrop-filter: blur(4px); 
        color: var(--primary-dark); font-weight: 700; font-size: 0.7rem; 
        text-transform: uppercase; padding: 6px 14px; border-radius: 30px; z-index: 2; 
    }
    .badge-rating { 
        position: absolute; top: 15px; right: 15px; 
        background: rgba(255,255,255,0.95); backdrop-filter: blur(4px); 
        color: #ffc107; font-weight: 700; font-size: 0.8rem; 
        padding: 5px 10px; border-radius: 12px; display: flex; align-items: center; gap: 4px; z-index: 2; 
    }
    .badge-rating span { color: #1a1a1a; }

    .card-body-custom { padding: 24px; display: flex; flex-direction: column; flex-grow: 1; }
    .card-location { 
        color: var(--orange-custom); font-size: 0.75rem; 
        font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; display: block; 
    }
    .card-title { 
        font-size: 1.25rem; font-weight: 800; color: var(--text-dark); margin-bottom: 12px; line-height: 1.4; 
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; 
    }
    .meta-tags { display: flex; gap: 10px; margin-bottom: 20px; }
    .meta-pill { 
        display: inline-flex; align-items: center; background: #f1f3f5; 
        color: var(--text-grey); font-size: 0.8rem; padding: 6px 12px; border-radius: 8px; font-weight: 500; 
    }
    .meta-pill i { margin-right: 6px; color: var(--primary-dark); }
    
    .card-footer-custom { 
        display: flex; justify-content: space-between; align-items: center; 
        margin-top: auto; padding-top: 15px; border-top: 1px solid #f0f0f0; 
    }
    .price-label { font-size: 0.7rem; color: var(--text-grey); display: block; margin-bottom: 2px; }
    .price-value { font-size: 1.1rem; font-weight: 800; color: var(--primary-dark); }
    .btn-card-action { 
        width: 42px; height: 42px; border-radius: 12px; background: var(--bg-off-white); 
        color: var(--primary-dark); display: flex; align-items: center; justify-content: center; 
        transition: all 0.3s ease; border: 1px solid transparent; 
    }
    .trip-card:hover .btn-card-action { 
        background: var(--accent-color); color: white; transform: rotate(-45deg); 
    }
</style>
@endsection

@section('content')

<div class="hero-section">
    <div class="container">
        <span class="hero-animate-down text-uppercase fw-bold mb-3 d-block" style="letter-spacing: 4px; opacity: 0.9; font-size: 0.9rem;">
            Welcome to HikersHub
        </span>
        
        <h1 class="hero-animate-up delay-100 display-3 fw-bold mb-4" style="text-shadow: 0 4px 15px rgba(0,0,0,0.5);">
            Discover Nature's<br>Hidden Gems
        </h1>
        
        <p class="hero-animate-up delay-200 lead mb-5 opacity-90 mx-auto" style="max-width: 600px; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
            Experience safe, professional, and unforgettable hiking adventures across Indonesia's most beautiful peaks.
        </p>
        
        <div class="hero-animate-up delay-500 d-flex justify-content-center gap-3">
            <a href="#featured-trips" class="btn btn-accent btn-lg px-5 py-3 rounded-pill fw-bold shadow">
                Start Exploring
            </a>
            @guest
            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill fw-bold" style="border-width: 2px;">
                Join Community
            </a>
            @endguest
        </div>
    </div>
    
    <a href="#featured-trips" class="scroll-down">
        <i class="fas fa-chevron-down fa-2x"></i>
    </a>
</div>

<div class="container py-5 my-5" id="featured-trips">
    <div class="d-flex justify-content-between align-items-end mb-5 px-2" data-aos="fade-up">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--primary-dark);">Popular Destinations</h2>
            <p class="text-muted mb-0">Swipe to find your next adventure</p>
            <div style="width: 60px; height: 4px; background: var(--accent-color); margin-top: 15px; border-radius: 2px;"></div>
        </div>
        <div class="d-none d-md-block">
            <a href="{{ route('trips.index') }}" class="btn btn-outline-dark rounded-pill px-4 py-2 fw-semibold" style="border-width: 2px;">
                View All Trips <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
    
    @if($featuredTrips->count() > 0)
    <div class="carousel-container" data-aos="fade-up" data-aos-delay="200">
        <button class="carousel-btn prev" onclick="scrollCarousel('left')">
            <i class="fas fa-chevron-left"></i>
        </button>

        <div class="trip-carousel" id="tripCarousel">
            @foreach($featuredTrips as $trip)
            <div class="trip-card-wrapper">
                <div class="trip-card">
                    
                    <div class="card-img-wrapper">
                        <span class="badge-difficulty">{{ ucfirst($trip->mountain->difficulty_level) }}</span>
                        <div class="badge-rating"><i class="fas fa-star"></i> <span>4.8</span></div>
                        <img src="{{ $trip->mountain->image ? asset('storage/'.$trip->mountain->image) : 'https://via.placeholder.com/400x300?text=Mountain' }}" 
                             alt="{{ $trip->mountain->name }}">
                    </div>
                    
                    <div class="card-body-custom">
                        <div>
                            <span class="card-location">
                                <i class="fas fa-map-marker-alt me-1"></i> {{ $trip->mountain->location }}
                            </span>
                            <a href="{{ route('trips.show', $trip) }}" class="text-decoration-none">
                                <h3 class="card-title">{{ Str::limit($trip->title, 40) }}</h3>
                            </a>
                            <div class="meta-tags">
                                <div class="meta-pill"><i class="far fa-clock"></i> {{ $trip->duration_days }} Days</div>
                                <div class="meta-pill"><i class="far fa-calendar"></i> {{ date('d M', strtotime($trip->start_date)) }}</div>
                            </div>
                        </div>
                        
                        <div class="card-footer-custom">
                            <div>
                                <span class="price-label">Start from</span>
                                <span class="price-value">{{ $trip->formatted_price }}</span>
                            </div>
                            <a href="{{ route('trips.show', $trip) }}" class="btn-card-action">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <button class="carousel-btn next" onclick="scrollCarousel('right')">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
    @else
    <div class="text-center py-5 bg-light rounded-4">
        <i class="fas fa-mountain fa-2x text-muted mb-3"></i>
        <p class="text-muted">No trips available at the moment.</p>
    </div>
    @endif
</div>

<div class="bg-light py-5">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-down">
            <h2 class="fw-bold" style="color: var(--primary-dark);">Why Choose HikersHub?</h2>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
                <div class="p-5 h-100 bg-white rounded-5 shadow-sm border-0 transition-hover">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 80px; height: 80px; background-color: rgba(44, 95, 45, 0.1); color: var(--primary-dark);">
                        <i class="fas fa-shield-alt fa-2x"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Safety First</h5>
                    <p class="text-muted mb-0">Comprehensive insurance and certified guides for every journey.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="p-5 h-100 bg-white rounded-5 shadow-sm border-0 transition-hover">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 80px; height: 80px; background-color: rgba(229, 115, 45, 0.1); color: var(--accent-color);">
                        <i class="fas fa-hiking fa-2x"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Expert Guides</h5>
                    <p class="text-muted mb-0">Local experts who know every trail and hidden spot.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                <div class="p-5 h-100 bg-white rounded-5 shadow-sm border-0 transition-hover">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 80px; height: 80px; background-color: rgba(23, 162, 184, 0.1); color: #17a2b8;">
                        <i class="fas fa-wallet fa-2x"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Transparent Pricing</h5>
                    <p class="text-muted mb-0">No hidden fees. What you see is exactly what you pay.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="rounded-5 p-5 text-center text-white position-relative overflow-hidden shadow-lg" 
         style="background: linear-gradient(135deg, var(--primary-dark), #144015);" 
         data-aos="zoom-in" data-aos-duration="1000">
         
        <div style="position: absolute; top: -50px; left: -50px; width: 200px; height: 200px; border-radius: 50%; background: white; opacity: 0.05;"></div>
        <div style="position: absolute; bottom: -50px; right: -50px; width: 300px; height: 300px; border-radius: 50%; background: white; opacity: 0.05;"></div>
        
        <div class="position-relative z-1">
            <h2 class="fw-bold mb-3 display-6">Ready for Your Next Ascent?</h2>
            <p class="lead mb-4 opacity-90">Join thousands of hikers who have found their path with us.</p>
            <a href="{{ route('trips.index') }}" class="btn btn-light text-success fw-bold btn-lg rounded-pill px-5 shadow-sm hover-scale">
                Book Now
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    // Inisialisasi AOS
    AOS.init({
        duration: 800, // Durasi animasi (ms)
        once: true,    // Animasi hanya berjalan sekali saat scroll ke bawah
        offset: 100,   // Trigger animasi 100px sebelum elemen terlihat
    });

    // Script Carousel
    function scrollCarousel(direction) {
        const container = document.getElementById('tripCarousel');
        const scrollAmount = 350; 
        if (direction === 'left') {
            container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        } else {
            container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }
    }

    // Script Navbar Scroll
    document.addEventListener("DOMContentLoaded", function(){
        const navbar = document.querySelector('.navbar'); 
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    });
</script>
@endpush