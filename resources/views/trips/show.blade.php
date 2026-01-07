@extends('layouts.app')

@section('title', $trip->title)

@section('styles')
<style>
    /* --- 1. PALET WARNA (Konsisten dengan Home) --- */
    :root {
        --primary-dark: #2c5f2d;
        --primary-light: #97bc62;
        --accent-color: #e5732d;
        --text-dark: #1a1a1a;
        --text-grey: #6c757d;
        --bg-off-white: #f8f9fa;
    }

    /* --- 2. NAVBAR SCROLL LOGIC (Agar konsisten dengan Home) --- */
    .navbar {
        position: fixed !important;
        top: 0;
        width: 100%;
        z-index: 9999;
        background-color: transparent !important;
        box-shadow: none !important;
        transition: all 0.4s ease-in-out;
        padding-top: 25px !important;
        padding-bottom: 25px !important;
    }

    .navbar.scrolled {
        background-color: rgba(20, 30, 20, 0.95) !important;
        backdrop-filter: blur(10px);
        padding-top: 12px !important;
        padding-bottom: 12px !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
    }

    .navbar .navbar-brand { color: white !important; font-weight: 800; }
    .navbar .nav-link { color: rgba(255, 255, 255, 0.9) !important; font-weight: 500; }
    .navbar .nav-link:hover { color: var(--accent-color) !important; }
    .navbar .btn-outline-primary { color: white !important; border-color: white !important; }
    .navbar .btn-outline-primary:hover { background-color: var(--accent-color) !important; border-color: var(--accent-color) !important; }

    /* --- 3. TRIP HERO SECTION --- */
    .trip-hero {
        height: 70vh;
        min-height: 500px;
        position: relative;
        background-image: url("{{ $trip->mountain->image ? asset('storage/'.$trip->mountain->image) : 'https://via.placeholder.com/1920x1080?text=Mountain' }}");
        background-size: cover;
        background-position: center;
        background-attachment: fixed; /* Parallax */
        display: flex;
        align-items: flex-end;
        padding-bottom: 80px;
    }

    .trip-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.8) 100%);
    }

    .hero-content {
        position: relative;
        z-index: 2;
        color: white;
    }

    /* Badge Styles */
    .badge-custom {
        padding: 8px 16px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        backdrop-filter: blur(5px);
    }
    .badge-difficulty { background-color: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255,255,255,0.4); color: white; }
    
    /* --- 4. CONTENT LAYOUT --- */
    .main-content-wrapper {
        background: white;
        border-radius: 40px 40px 0 0; /* Lengkungan di atas */
        margin-top: -60px; /* Overlap ke hero image */
        position: relative;
        z-index: 10;
        padding-top: 50px;
    }

    /* Sidebar Sticky */
    .sticky-sidebar {
        position: sticky;
        top: 100px; /* Jarak dari atas saat scroll */
        z-index: 5;
    }

    /* Booking Card */
    .booking-card {
        border: none;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .booking-header {
        background: var(--primary-dark);
        color: white;
        padding: 25px;
        text-align: center;
    }

    .price-tag {
        font-size: 2.5rem;
        font-weight: 800;
        color: white;
    }
    
    .btn-book {
        background: var(--accent-color);
        color: white;
        border: none;
        padding: 15px;
        border-radius: 15px;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s;
        width: 100%;
        display: block;
        text-align: center;
        text-decoration: none;
    }
    
    .btn-book:hover {
        background: #c45d1e;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(229, 115, 45, 0.4);
    }
    
    .btn-book.disabled { background: var(--text-grey); cursor: not-allowed; transform: none; box-shadow: none; }

    /* Info Icons Box */
    .info-box {
        background: var(--bg-off-white);
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 30px;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
    .info-item:last-child { margin-bottom: 0; }
    
    .info-icon {
        width: 45px;
        height: 45px;
        background: rgba(44, 95, 45, 0.1);
        color: var(--primary-dark);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 1.2rem;
    }

    /* Tabs / Sections */
    .section-title {
        font-weight: 800;
        color: var(--primary-dark);
        margin-bottom: 20px;
        position: relative;
        display: inline-block;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 40px;
        height: 4px;
        background: var(--accent-color);
        border-radius: 2px;
    }

    /* Itinerary Timeline Style */
    .itinerary-box {
        background: #fff;
        border-left: 4px solid var(--primary-light);
        padding: 20px;
        background: var(--bg-off-white);
        border-radius: 0 15px 15px 0;
        white-space: pre-line;
        line-height: 1.8;
    }

    /* Gallery Grid */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
    }
    .gallery-img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 15px;
        transition: transform 0.3s;
        cursor: pointer;
    }
    .gallery-img:hover { transform: scale(1.05); }

    /* Inclusions */
    .check-list i { color: var(--primary-dark); margin-right: 10px; }
    .cross-list i { color: #dc3545; margin-right: 10px; }

</style>
@endsection

@section('content')

<div class="trip-hero">
    <div class="container hero-content">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="mb-3">
                    <span class="badge-custom badge-difficulty">
                        <i class="fas fa-signal me-1"></i> {{ ucfirst($trip->mountain->difficulty_level) }}
                    </span>
                    <span class="badge-custom ms-2" style="background: var(--accent-color); color: white;">
                        {{ $trip->status == 'open' ? 'Open Trip' : ucfirst($trip->status) }}
                    </span>
                </div>
                <h1 class="display-3 fw-bold mb-2">{{ $trip->title }}</h1>
                <div class="d-flex align-items-center text-white-50 fs-5">
                    <i class="fas fa-map-marker-alt me-2 text-warning"></i> {{ $trip->mountain->location }}
                    <span class="mx-3">|</span>
                    <i class="fas fa-mountain me-2"></i> {{ $trip->mountain->formatted_altitude }}
                </div>
            </div>
            <div class="col-lg-4 text-lg-end d-none d-lg-block">
                <div class="text-warning fs-4">
                    {!! generateStars(round($trip->average_rating)) !!}
                </div>
                <div class="text-white fw-bold">{{ $trip->reviews->count() }} Reviews</div>
            </div>
        </div>
    </div>
</div>

<div class="main-content-wrapper pb-5">
    <div class="container">
        <div class="row">
            
            <div class="col-lg-8 pe-lg-5">
                
                <div class="d-lg-none mb-4">
                    <div class="info-box">
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Date</strong>
                            <span>{{ formatDate($trip->start_date) }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <strong>Price</strong>
                            <span class="text-success fw-bold">{{ $trip->formatted_price }}</span>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h3 class="section-title">About This Trip</h3>
                    <p class="text-muted lead">{{ $trip->mountain->description }}</p>
                    <p class="text-muted">
                        Join us for an unforgettable journey to <strong>{{ $trip->mountain->name }}</strong>. 
                        Meeting point at <strong>{{ $trip->meeting_point }}</strong>.
                    </p>
                </div>

                <div class="info-box">
                    <div class="row g-4">
                        <div class="col-6 col-md-3 text-center">
                            <i class="far fa-clock fa-2x mb-2" style="color: var(--accent-color)"></i>
                            <h6 class="fw-bold mb-0">{{ $trip->duration_days }} Days</h6>
                            <small class="text-muted">Duration</small>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                            <i class="far fa-calendar-alt fa-2x mb-2" style="color: var(--accent-color)"></i>
                            <h6 class="fw-bold mb-0">{{ date('d M', strtotime($trip->start_date)) }}</h6>
                            <small class="text-muted">Start</small>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                            <i class="fas fa-user-friends fa-2x mb-2" style="color: var(--accent-color)"></i>
                            <h6 class="fw-bold mb-0">{{ $trip->max_participants }} Pax</h6>
                            <small class="text-muted">Max Group</small>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                            <i class="fas fa-ticket-alt fa-2x mb-2" style="color: var(--accent-color)"></i>
                            <h6 class="fw-bold mb-0">{{ $trip->available_slots }}</h6>
                            <small class="text-muted">Slots Left</small>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h4 class="section-title">Itinerary</h4>
                    @if($trip->itinerary)
                        <div class="itinerary-box shadow-sm">
                            {{ $trip->itinerary }}
                        </div>
                    @else
                        <p class="text-muted fst-italic">Itinerary detail available upon request.</p>
                    @endif
                </div>

                <div class="row mb-5">
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-3 text-success"><i class="fas fa-check-circle me-2"></i> Included</h5>
                        <div class="bg-light p-4 rounded-4 h-100 check-list" style="white-space: pre-line;">
                            {{ $trip->include_items ?? 'Standard hiking gear provided.' }}
                        </div>
                    </div>
                    <div class="col-md-6 mt-4 mt-md-0">
                        <h5 class="fw-bold mb-3 text-danger"><i class="fas fa-times-circle me-2"></i> Excluded</h5>
                        <div class="bg-light p-4 rounded-4 h-100 cross-list" style="white-space: pre-line;">
                            {{ $trip->exclude_items ?? 'Personal expenses not included.' }}
                        </div>
                    </div>
                </div>

                @if($trip->galleries->count() > 0)
                <div class="mb-5">
                    <h4 class="section-title">Trip Gallery</h4>
                    <div class="gallery-grid">
                        @foreach($trip->galleries as $gallery)
                            <img src="{{ asset('storage/'.$gallery->image_path) }}" 
                                 class="gallery-img shadow-sm" 
                                 alt="{{ $gallery->caption }}"
                                 onclick="window.open(this.src)">
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="mb-5">
                    <h4 class="section-title">Hiker Reviews</h4>
                    <div class="mt-4">
                        @forelse($trip->reviews as $review)
                        <div class="d-flex mb-4 pb-4 border-bottom">
                            <div class="me-3">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center fw-bold text-muted" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                    {{ substr($review->user->name, 0, 1) }}
                                </div>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">{{ $review->user->name }}</h6>
                                <div class="mb-2 text-warning small">
                                    {!! generateStars($review->rating) !!} 
                                    <span class="text-muted ms-2">{{ diffForHumans($review->created_at) }}</span>
                                </div>
                                <p class="text-muted mb-0">{{ $review->comment }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted">No reviews yet. Be the first to join and review!</p>
                        @endforelse
                    </div>
                </div>

            </div>

            <div class="col-lg-4">
                <div class="sticky-sidebar">
                    <div class="booking-card bg-white">
                        <div class="booking-header">
                            <small class="opacity-75 d-block mb-1">Price per person</small>
                            <span class="price-tag">{{ $trip->formatted_price }}</span>
                        </div>
                        <div class="p-4">
                            @auth
                                @if(auth()->user()->role == 'user')
                                    @if($trip->status == 'open' && !$trip->is_full)
                                        <a href="{{ route('user.bookings.create', $trip) }}" class="btn-book">
                                            Book This Trip
                                        </a>
                                        <div class="text-center mt-3 text-muted small">
                                            <i class="fas fa-bolt text-warning"></i> Instant Confirmation
                                        </div>
                                    @else
                                        <button class="btn-book disabled" disabled>
                                            <i class="fas fa-ban me-2"></i> Fully Booked / Closed
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-dark w-100 rounded-pill py-3">
                                        Admin Dashboard
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn-book">
                                    Login to Book
                                </a>
                                <div class="text-center mt-3">
                                    <small class="text-muted">New here? <a href="{{ route('register') }}" class="fw-bold text-success">Register</a></small>
                                </div>
                            @endauth

                            <hr class="my-4 opacity-10">
                            
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="text-center">
                                    <small class="text-muted d-block">Have questions?</small>
                                    <a href="#" class="fw-bold text-decoration-none" style="color: var(--primary-dark)">
                                        <i class="fab fa-whatsapp me-1"></i> Chat with Guide
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($trip->terms_conditions)
                    <div class="mt-4 p-4 rounded-4 bg-light">
                        <h6 class="fw-bold mb-3"><i class="fas fa-file-contract me-2 text-muted"></i>Terms & Conditions</h6>
                        <p class="small text-muted mb-0" style="max-height: 150px; overflow-y: auto; white-space: pre-line;">
                            {{ $trip->terms_conditions }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Logic Navbar berubah warna saat scroll (sama seperti Home)
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