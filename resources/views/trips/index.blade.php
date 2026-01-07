@extends('layouts.app')

@section('title', 'Browse Trips')

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

    /* Override Navbar Colors */
    .navbar .navbar-brand { color: white !important; font-weight: 800; }
    .navbar .nav-link { color: rgba(255, 255, 255, 0.9) !important; font-weight: 500; }
    .navbar .nav-link:hover { color: var(--accent-color) !important; }
    .navbar .btn-outline-primary { color: white !important; border-color: white !important; }
    .navbar .btn-outline-primary:hover { background-color: var(--accent-color) !important; border-color: var(--accent-color) !important; }

    /* --- 3. PAGE HERO HEADER --- */
    .page-header {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)), url('{{ asset("images/Elvin.jpg") }}'); /* Ganti dengan gambar header umum */
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        padding: 160px 0 80px 0;
        color: white;
        text-align: center;
        margin-bottom: 50px;
    }

    /* --- 4. FILTER SIDEBAR --- */
    .filter-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        background: white;
        overflow: hidden;
    }

    .filter-header {
        background: var(--primary-dark);
        color: white;
        padding: 20px 25px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .filter-body {
        padding: 25px;
    }

    .form-label {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border-radius: 10px;
        border: 1px solid #eee;
        padding: 10px 15px;
        font-size: 0.95rem;
        background-color: var(--bg-off-white);
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-light);
        box-shadow: 0 0 0 3px rgba(151, 188, 98, 0.2);
    }

    /* --- 5. TRIP CARD DESIGN (Sama seperti Home) --- */
    .trip-card {
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

    .trip-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12);
    }
    
    .card-img-wrapper {
        height: 220px;
        position: relative;
        overflow: hidden;
    }
    
    .card-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .trip-card:hover .card-img-wrapper img { transform: scale(1.1); }

    /* Badges */
    .badge-difficulty {
        position: absolute;
        top: 15px;
        left: 15px;
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

    .card-location {
        color: var(--accent-color);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 5px;
        display: block;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 10px;
        line-height: 1.4;
    }

    .meta-info {
        display: flex;
        gap: 15px;
        font-size: 0.85rem;
        color: var(--text-grey);
        margin-bottom: 15px;
    }

    .meta-info i { color: var(--primary-light); margin-right: 5px; }

    .card-footer-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        padding-top: 15px;
        border-top: 1px solid #f0f0f0;
    }

    .price-value { font-size: 1.1rem; font-weight: 800; color: var(--primary-dark); }
    .price-label { font-size: 0.7rem; color: var(--text-grey); display: block; }

    .btn-card-action {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: var(--bg-off-white);
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .trip-card:hover .btn-card-action {
        background: var(--accent-color);
        color: white;
    }

    /* Buttons */
    .btn-accent {
        background-color: var(--accent-color);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 10px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-accent:hover { background-color: #c45d1e; color: white; transform: translateY(-2px); }

</style>
@endsection

@section('content')

<div class="page-header">
    <div class="container">
        <h1 class="display-4 fw-bold mb-2">Explore Open Trips</h1>
        <p class="lead opacity-90">Find your next mountain adventure and create unforgettable memories.</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row">
        
        <div class="col-lg-3 mb-5">
            <div class="filter-card sticky-top" style="top: 100px; z-index: 1;">
                <div class="filter-header">
                    <span><i class="fas fa-filter me-2"></i> Filters</span>
                </div>
                <div class="filter-body">
                    <form method="GET" action="{{ route('trips.index') }}">
                        
                        <div class="mb-4">
                            <label class="form-label">Search Trip</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 rounded-start-3"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" name="search" class="form-control border-start-0 rounded-end-3 ps-0" 
                                       placeholder="Mountain or keyword..." 
                                       value="{{ request('search') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Destination</label>
                            <select name="mountain_id" class="form-select">
                                <option value="">All Mountains</option>
                                @foreach($mountains as $mountain)
                                <option value="{{ $mountain->id }}" {{ request('mountain_id') == $mountain->id ? 'selected' : '' }}>
                                    {{ $mountain->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Difficulty Level</label>
                            <select name="difficulty" class="form-select">
                                <option value="">Any Level</option>
                                <option value="easy" {{ request('difficulty') == 'easy' ? 'selected' : '' }}>Easy (Beginner)</option>
                                <option value="medium" {{ request('difficulty') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="hard" {{ request('difficulty') == 'hard' ? 'selected' : '' }}>Hard</option>
                                <option value="extreme" {{ request('difficulty') == 'extreme' ? 'selected' : '' }}>Extreme</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price Budget</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" name="min_price" class="form-control" placeholder="Min" value="{{ request('min_price') }}">
                                </div>
                                <div class="col-6">
                                    <input type="number" name="max_price" class="form-control" placeholder="Max" value="{{ request('max_price') }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Sort Results</label>
                            <select name="sort" class="form-select">
                                <option value="date" {{ request('sort') == 'date' ? 'selected' : '' }}>Date (Nearest)</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price (Lowest)</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price (Highest)</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-accent w-100 mb-2">
                            Apply Filters
                        </button>
                        
                        <a href="{{ route('trips.index') }}" class="btn btn-link text-muted w-100 text-decoration-none">
                            <small>Reset Filters</small>
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            
            <div class="d-flex justify-content-between align-items-center mb-4 ps-2">
                <h5 class="fw-bold text-dark mb-0">
                    Showing <span style="color: var(--accent-color);">{{ $trips->total() }}</span> Adventures
                </h5>
            </div>

            @if($trips->count() > 0)
            <div class="row g-4">
                @foreach($trips as $trip)
                <div class="col-md-6 col-xl-4">
                    <div class="trip-card">
                        <div class="card-img-wrapper">
                            <span class="badge-difficulty">
                                {{ ucfirst($trip->mountain->difficulty_level) }}
                            </span>
                            
                            @if($trip->available_slots <= 0)
                                <span class="position-absolute top-0 end-0 m-3 badge bg-danger rounded-pill shadow-sm z-2">
                                    Full Booked
                                </span>
                            @elseif($trip->available_slots < 5)
                                <span class="position-absolute top-0 end-0 m-3 badge bg-warning text-dark rounded-pill shadow-sm z-2">
                                    Last {{ $trip->available_slots }} Slots
                                </span>
                            @endif

                            <img src="{{ $trip->mountain->image ? asset('storage/'.$trip->mountain->image) : 'https://via.placeholder.com/400x300?text=Mountain' }}" 
                                 alt="{{ $trip->mountain->name }}">
                        </div>
                        
                        <div class="card-body-custom">
                            <div>
                                <span class="card-location">
                                    <i class="fas fa-map-marker-alt me-1"></i> {{ $trip->mountain->location }}
                                </span>
                                
                                <a href="{{ route('trips.show', $trip) }}" class="text-decoration-none">
                                    <h5 class="card-title">{{ Str::limit($trip->title, 40) }}</h5>
                                </a>
                                
                                <div class="meta-info">
                                    <span><i class="far fa-clock"></i> {{ $trip->duration_days }}D</span>
                                    <span><i class="far fa-calendar"></i> {{ date('d M', strtotime($trip->start_date)) }}</span>
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

            <div class="d-flex justify-content-center mt-5">
                {{ $trips->links() }}
            </div>
            
            @else
            <div class="text-center py-5 bg-light rounded-4 border border-dashed">
                <div class="mb-3 text-muted opacity-50">
                    <i class="fas fa-search fa-3x"></i>
                </div>
                <h5 class="fw-bold">No trips found</h5>
                <p class="text-muted mb-0">We couldn't find any trips matching your criteria.</p>
                <a href="{{ route('trips.index') }}" class="btn btn-outline-dark mt-3 rounded-pill px-4">Clear All Filters</a>
            </div>
            @endif
        </div>
    </div>
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