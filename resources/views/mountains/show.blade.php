@extends('layouts.app')

@section('title', $mountain->name)

@section('styles')
<style>
    /* --- 1. PALET WARNA --- */
    :root {
        --primary-dark: #2c5f2d;
        --primary-light: #97bc62;
        --accent-color: #e5732d;
        --text-dark: #1a1a1a;
        --text-grey: #6c757d;
        --bg-off-white: #f8f9fa;
    }

    /* --- 2. NAVBAR SCROLL LOGIC --- */
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

    /* --- 3. HERO BANNER --- */
    .mountain-hero {
        height: 65vh;
        min-height: 500px;
        position: relative;
        background-image: url("{{ $mountain->image ? asset('storage/'.$mountain->image) : 'https://via.placeholder.com/1920x1080?text=Mountain' }}");
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        display: flex;
        align-items: flex-end;
        padding-bottom: 80px;
    }

    .mountain-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0.8) 100%);
    }

    .hero-content {
        position: relative;
        z-index: 2;
        color: white;
    }

    .badge-difficulty {
        padding: 8px 16px;
        border-radius: 30px;
        font-weight: 700;
        font-size: 0.9rem;
        text-transform: uppercase;
        backdrop-filter: blur(5px);
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.4);
        color: white;
        display: inline-block;
        margin-bottom: 15px;
    }

    /* --- 4. CONTENT LAYOUT --- */
    .main-wrapper {
        background: white;
        border-radius: 40px 40px 0 0;
        margin-top: -60px;
        position: relative;
        z-index: 10;
        padding-top: 50px;
        padding-bottom: 50px;
    }

    /* Sidebar Widgets */
    .widget-card {
        background: white;
        border: 1px solid #f0f0f0;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    .widget-title {
        font-weight: 800;
        color: var(--primary-dark);
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Trip Card (List View) */
    .trip-list-card {
        border: 1px solid #eee;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        transition: all 0.3s;
        background: white;
    }

    .trip-list-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        border-color: var(--primary-light);
    }

    .trip-price {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--accent-color);
    }

    /* Info Icons */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .info-item {
        background: var(--bg-off-white);
        padding: 20px;
        border-radius: 15px;
        text-align: center;
    }
    .info-item i { font-size: 2rem; color: var(--primary-dark); margin-bottom: 10px; }
    .info-item strong { display: block; font-size: 1.1rem; color: var(--text-dark); }
    .info-item span { color: var(--text-grey); font-size: 0.9rem; }

    /* Buttons */
    .btn-action {
        background: var(--accent-color);
        color: white;
        border-radius: 12px;
        padding: 12px 25px;
        font-weight: 700;
        transition: all 0.3s;
        border: none;
    }
    .btn-action:hover { background: #c45d1e; color: white; transform: translateY(-2px); }

    .btn-outline-action {
        border: 2px solid var(--primary-dark);
        color: var(--primary-dark);
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 700;
        background: transparent;
        transition: all 0.3s;
    }
    .btn-outline-action:hover { background: var(--primary-dark); color: white; }

</style>
@endsection

@section('content')

<div class="mountain-hero">
    <div class="container hero-content">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <span class="badge-difficulty">
                    <i class="fas fa-signal me-2"></i> {{ ucfirst($mountain->difficulty_level) }} Level
                </span>
                <h1 class="display-3 fw-bold mb-2">{{ $mountain->name }}</h1>
                <div class="d-flex align-items-center text-white-50 fs-5">
                    <i class="fas fa-map-marker-alt me-2 text-warning"></i> {{ $mountain->location }}
                    <span class="mx-3">|</span>
                    <i class="fas fa-mountain me-2"></i> {{ $mountain->formatted_altitude }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="main-wrapper">
    <div class="container">
        <div class="row">
            
            <div class="col-lg-8 pe-lg-5">
                
                <div class="info-grid">
                    <div class="info-item">
                        <i class="fas fa-mountain"></i>
                        <strong>{{ $mountain->formatted_altitude }}</strong>
                        <span>Elevation</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-layer-group"></i>
                        <strong>{{ ucfirst($mountain->difficulty_level) }}</strong>
                        <span>Difficulty</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-hiking"></i>
                        <strong>{{ $mountain->trips->count() }}</strong>
                        <span>Trips Organized</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-map"></i>
                        <strong>Location</strong>
                        <span>{{ Str::limit($mountain->location, 15) }}</span>
                    </div>
                </div>

                <div class="mb-5">
                    <h3 class="fw-bold mb-4" style="color: var(--primary-dark)">About the Mountain</h3>
                    <p class="lead text-muted" style="white-space: pre-line; line-height: 1.8;">
                        {{ $mountain->description }}
                    </p>
                </div>

                @if($mountain->facilities)
                <div class="mb-5">
                    <h4 class="fw-bold mb-3">Facilities & Basecamp Info</h4>
                    <div class="bg-light p-4 rounded-4 border-start border-4 border-success">
                        <p class="mb-0 text-muted" style="white-space: pre-line;">{{ $mountain->facilities }}</p>
                    </div>
                </div>
                @endif

                <div id="trips-section" class="pt-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fw-bold mb-0">Upcoming Open Trips</h3>
                        @if($upcomingTrips->count() > 0)
                            <span class="badge bg-success rounded-pill">{{ $upcomingTrips->count() }} Available</span>
                        @endif
                    </div>

                    @if($upcomingTrips->count() > 0)
                        @foreach($upcomingTrips as $trip)
                        <div class="trip-list-card">
                            <div class="row align-items-center">
                                <div class="col-md-7">
                                    <h5 class="fw-bold mb-1">{{ $trip->title }}</h5>
                                    <div class="text-muted small mb-2">
                                        <i class="fas fa-calendar-alt me-2 text-success"></i> {{ formatDate($trip->start_date, 'd M Y') }}
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-clock me-2 text-success"></i> {{ $trip->duration_days }} Days
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="badge bg-light text-dark border">
                                            <i class="fas fa-user-friends me-1"></i> {{ $trip->available_slots }} Slots Left
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-5 text-md-end mt-3 mt-md-0">
                                    <div class="mb-2">
                                        <small class="text-muted d-block">Start from</small>
                                        <span class="trip-price">{{ $trip->formatted_price }}</span>
                                    </div>
                                    <a href="{{ route('trips.show', $trip) }}" class="btn-action d-block d-md-inline-block text-decoration-none">
                                        Details <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        <div class="text-center mt-4">
                            <a href="{{ route('trips.index', ['mountain_id' => $mountain->id]) }}" class="btn-outline-action text-decoration-none">
                                View All Trips History
                            </a>
                        </div>
                    @else
                        <div class="text-center py-5 bg-light rounded-4 border border-dashed">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3 opacity-50"></i>
                            <h5 class="fw-bold">No Trips Available Yet</h5>
                            <p class="text-muted">We haven't scheduled a trip to {{ $mountain->name }} recently.</p>
                            <a href="{{ route('trips.index') }}" class="btn-action text-decoration-none">
                                Check Other Mountains
                            </a>
                        </div>
                    @endif
                </div>

            </div>

            <div class="col-lg-4 mt-5 mt-lg-0">
                <div class="sticky-top" style="top: 100px; z-index: 5;">
                    
                    <div class="widget-card bg-success text-white border-0 text-center">
                        <h4 class="fw-bold text-white mb-3">Want to Climb?</h4>
                        <p class="opacity-90 mb-4">Join our community and conquer the peak of {{ $mountain->name }} safely.</p>
                        @if($upcomingTrips->count() > 0)
                            <a href="#trips-section" class="btn btn-light w-100 fw-bold py-3 rounded-pill text-success shadow-sm">
                                Book Available Trip
                            </a>
                        @else
                            <button class="btn btn-white w-100 fw-bold py-3 rounded-pill text-muted disabled" disabled>
                                No Trips Available
                            </button>
                        @endif
                    </div>

                    <div class="widget-card">
                        <div class="widget-title">
                            <span>Risk Level</span>
                            <i class="fas fa-info-circle text-muted"></i>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3">
                            <div style="width: 12px; height: 12px; border-radius: 50%; background: #28a745; margin-right: 10px;"></div>
                            <strong class="me-auto">Easy</strong>
                            <small class="text-muted">Beginner Friendly</small>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div style="width: 12px; height: 12px; border-radius: 50%; background: #17a2b8; margin-right: 10px;"></div>
                            <strong class="me-auto">Medium</strong>
                            <small class="text-muted">Fit Hikers</small>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div style="width: 12px; height: 12px; border-radius: 50%; background: #ffc107; margin-right: 10px;"></div>
                            <strong class="me-auto">Hard</strong>
                            <small class="text-muted">Experienced</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <div style="width: 12px; height: 12px; border-radius: 50%; background: #dc3545; margin-right: 10px;"></div>
                            <strong class="me-auto">Extreme</strong>
                            <small class="text-muted">Pro Only</small>
                        </div>
                        
                        <div class="mt-3 pt-3 border-top text-center">
                            <small class="text-muted">Current Level: 
                                <span class="fw-bold text-{{ getDifficultyColor($mountain->difficulty_level) }}">
                                    {{ ucfirst($mountain->difficulty_level) }}
                                </span>
                            </small>
                        </div>
                    </div>

                    @php
                        $otherMountains = \App\Models\Mountain::where('id', '!=', $mountain->id)
                                          ->inRandomOrder()->take(3)->get();
                    @endphp

                    @if($otherMountains->count() > 0)
                    <div class="widget-card">
                        <div class="widget-title">
                            <span>Explore More</span>
                        </div>
                        @foreach($otherMountains as $other)
                        <a href="{{ route('mountains.show', $other) }}" class="d-flex align-items-center text-decoration-none mb-3 last-mb-0 group">
                            <img src="{{ $other->image ? asset('storage/'.$other->image) : 'https://via.placeholder.com/100' }}" 
                                 class="rounded-3 me-3" 
                                 style="width: 60px; height: 60px; object-fit: cover;">
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">{{ $other->name }}</h6>
                                <small class="text-muted">{{ $other->location }}</small>
                            </div>
                            <i class="fas fa-chevron-right ms-auto text-muted small"></i>
                        </a>
                        @endforeach
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