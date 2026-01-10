@extends('layouts.app')

@section('title', 'Browse Mountains')

@section('styles')
<style>
    /* --- 1. COLOR PALETTE --- */
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

    /* Navbar Colors Override */
    .navbar .navbar-brand { color: white !important; font-weight: 800; }
    .navbar .nav-link { color: rgba(255, 255, 255, 0.9) !important; font-weight: 500; }
    .navbar .nav-link:hover { color: var(--accent-color) !important; }
    .navbar .btn-outline-primary { color: white !important; border-color: white !important; }
    .navbar .btn-outline-primary:hover { background-color: var(--accent-color) !important; border-color: var(--accent-color) !important; }

    /* --- 3. HERO HEADER --- */
    .page-header {
        /*  */
        background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.7)), url('{{ asset("images/Elvin.jpg") }}');
        background-size: cover;
        background-position: center 30%; /* Shifted up slightly */
        background-attachment: fixed;
        padding: 180px 0 100px 0;
        color: white;
        text-align: center;
        margin-bottom: 60px;
    }

    /* --- 4. SEARCH BAR COMPONENT --- */
    .search-container {
        background: white;
        padding: 15px;
        border-radius: 50px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        max-width: 800px;
        margin: -40px auto 50px auto; /* Overlap header */
        position: relative;
        z-index: 10;
    }

    .search-input {
        border: none;
        flex-grow: 1;
        padding: 10px 20px;
        font-size: 1rem;
        outline: none;
    }

    .search-divider {
        width: 1px;
        height: 30px;
        background: #eee;
        margin: 0 15px;
    }

    .search-select {
        border: none;
        outline: none;
        background: transparent;
        color: var(--text-dark);
        font-weight: 600;
        cursor: pointer;
        padding: 10px;
    }

    .btn-search-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--accent-color);
        color: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        flex-shrink: 0;
    }
    .btn-search-circle:hover {
        background: #c45d1e;
        transform: scale(1.05);
    }

    /* Mobile Responsive Search */
    @media (max-width: 768px) {
        .search-container {
            flex-direction: column;
            border-radius: 20px;
            margin-top: 20px;
            gap: 15px;
            padding: 20px;
        }
        .search-divider { display: none; }
        .search-input, .search-select { width: 100%; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .btn-search-circle { width: 100%; border-radius: 10px; }
    }

    /* --- 5. MOUNTAIN CARD DESIGN --- */
    .mountain-card {
        border: 1px solid rgba(0,0,0,0.04);
        border-radius: 20px;
        background: white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        overflow: hidden;
        height: 100%;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .mountain-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12);
    }
    
    .card-img-wrapper {
        height: 250px; /* Taller image for mountains */
        position: relative;
        overflow: hidden;
    }
    
    .card-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .mountain-card:hover .card-img-wrapper img { transform: scale(1.1); }

    /* Badge Difficulty */
    .badge-difficulty {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(4px);
        color: var(--primary-dark);
        font-weight: 700;
        font-size: 0.7rem;
        text-transform: uppercase;
        padding: 6px 14px;
        border-radius: 30px;
        z-index: 2;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .card-body-custom {
        padding: 24px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        justify-content: space-between;
    }

    .mtn-location {
        color: var(--text-grey);
        font-size: 0.85rem;
        margin-bottom: 5px;
        display: block;
    }

    .mtn-title {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 15px;
    }

    .mtn-stats {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f0f0f0;
    }

    .stat-item {
        display: flex;
        flex-direction: column;
        font-size: 0.8rem;
        color: var(--text-grey);
    }
    
    .stat-item strong {
        font-size: 1rem;
        color: var(--primary-dark);
        font-weight: 700;
    }

    .card-footer-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }

    .trips-count {
        font-size: 0.85rem;
        color: var(--accent-color);
        font-weight: 600;
        background: rgba(229, 115, 45, 0.1);
        padding: 5px 12px;
        border-radius: 8px;
    }

    .btn-view-details {
        color: var(--primary-dark);
        font-weight: 700;
        text-decoration: none;
        display: flex;
        align-items: center;
        transition: color 0.3s;
    }
    
    .btn-view-details:hover { color: var(--accent-color); }
    .btn-view-details i { margin-left: 5px; transition: transform 0.3s; }
    .btn-view-details:hover i { transform: translateX(5px); }

</style>
@endsection

@section('content')

<div class="page-header">
    <div class="container">
        <h1 class="display-3 fw-bold mb-3">Explore Majestic Peaks</h1>
        <p class="lead opacity-90">Discover the breathtaking mountains of Indonesia waiting for your footsteps.</p>
    </div>
</div>

<div class="container pb-5">
    
    <form method="GET" action="{{ route('mountains.index') }}">
        <div class="search-container">
            <i class="fas fa-search text-muted ms-2"></i>
            <input type="text" name="search" class="search-input" 
                   placeholder="Find mountain by name or location..." 
                   value="{{ request('search') }}">
            
            <div class="search-divider"></div>
            
            <select name="difficulty" class="search-select">
                <option value="">All Levels</option>
                <option value="easy" {{ request('difficulty') == 'easy' ? 'selected' : '' }}>Easy</option>
                <option value="medium" {{ request('difficulty') == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="hard" {{ request('difficulty') == 'hard' ? 'selected' : '' }}>Hard</option>
                <option value="extreme" {{ request('difficulty') == 'extreme' ? 'selected' : '' }}>Extreme</option>
            </select>

            <button type="submit" class="btn-search-circle ms-3">
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </form>

    <div class="d-flex justify-content-between align-items-center mb-4 px-2">
        <h5 class="fw-bold mb-0">Found <span style="color: var(--accent-color)">{{ $mountains->total() }}</span> Mountains</h5>
        
        @if(request('search') || request('difficulty'))
        <a href="{{ route('mountains.index') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">
            <i class="fas fa-times me-1"></i> Clear Filter
        </a>
        @endif
    </div>

    @if($mountains->count() > 0)
    <div class="row g-4">
        @foreach($mountains as $mountain)
        <div class="col-md-6 col-lg-4">
            <div class="mountain-card">
                <div class="card-img-wrapper">
                    <span class="badge-difficulty">
                        {{ ucfirst($mountain->difficulty_level) }}
                    </span>
                    
                    @if($mountain->image)
                       <img src="{{ Str::startsWith($mountain->image, 'http') ? $mountain->image : asset('storage/' . $mountain->image) }}">
                    @else
                        <div class="bg-secondary d-flex align-items-center justify-content-center h-100 w-100">
                            <i class="fas fa-mountain fa-4x text-white opacity-25"></i>
                        </div>
                    @endif
                </div>
                
                <div class="card-body-custom">
                    <div>
                        <span class="mtn-location"><i class="fas fa-map-marker-alt me-1"></i> {{ $mountain->location }}</span>
                        <h3 class="mtn-title">{{ $mountain->name }}</h3>
                        
                        <div class="mtn-stats">
                            <div class="stat-item">
                                <strong>{{ $mountain->formatted_altitude }}</strong>
                                <span>Elevation</span>
                            </div>
                            <div class="stat-item">
                                <strong>{{ $mountain->difficulty_level == 'extreme' ? 'High' : 'Normal' }}</strong>
                                <span>Risk Level</span>
                            </div>
                        </div>

                        <p class="text-muted small mb-0 line-clamp-2">
                            {{ Str::limit($mountain->description, 90) }}
                        </p>
                    </div>

                    <div class="card-footer-custom mt-4">
                        <span class="trips-count">
                            <i class="fas fa-hiking me-1"></i> {{ $mountain->trips_count }} Trips
                        </span>
                        <a href="{{ route('mountains.show', $mountain) }}" class="btn-view-details">
                            View Details <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $mountains->links() }}
    </div>

    @else
    <div class="text-center py-5 bg-light rounded-4 border border-dashed mt-4">
        <div class="mb-3 text-muted opacity-50">
            <i class="fas fa-mountain fa-3x"></i>
        </div>
        <h5 class="fw-bold">No mountains found</h5>
        <p class="text-muted mb-0">Try adjusting your search or filter criteria.</p>
        <a href="{{ route('mountains.index') }}" class="btn btn-outline-dark mt-3 rounded-pill px-4">View All Mountains</a>
    </div>
    @endif

</div>

@endsection

@push('scripts')
<script>
    // Navbar Scroll Logic
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