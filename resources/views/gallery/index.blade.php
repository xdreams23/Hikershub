@extends('layouts.app')

@section('title', 'Photo Gallery')

@section('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

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

    /* --- 2. CSS ANIMATIONS --- */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .hero-animate-up { opacity: 0; animation: fadeInUp 1s ease-out forwards; }
    .hero-animate-down { opacity: 0; animation: fadeInDown 1s ease-out forwards; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-400 { animation-delay: 0.4s; }

    /* --- 3. NAVBAR SCROLL LOGIC --- */
    .navbar {
        position: fixed !important;
        top: 0; width: 100%; z-index: 9999;
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

    /* --- 4. PAGE HEADER --- */
    .gallery-header {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)), url('{{ asset("images/Elvin.jpg") }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        padding: 160px 0 100px 0;
        color: white;
        text-align: center;
        margin-bottom: 50px;
        overflow: hidden;
    }

    /* --- 5. GALLERY GRID --- */
    .gallery-item {
        border-radius: 15px; overflow: hidden; position: relative;
        cursor: pointer; box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease; background: white;
        height: 100%; display: flex; flex-direction: column;
    }

    .gallery-item:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.15); }

    .img-wrapper { position: relative; overflow: hidden; height: 250px; }
    .img-wrapper img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
    .gallery-item:hover .img-wrapper img { transform: scale(1.1); }

    /* Overlay Icon */
    .hover-overlay {
        position: absolute; inset: 0; background: rgba(44, 95, 45, 0.6);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; transition: opacity 0.3s ease;
    }
    .gallery-item:hover .hover-overlay { opacity: 1; }

    .zoom-icon {
        width: 50px; height: 50px; background: white; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: var(--primary-dark); font-size: 1.2rem;
        transform: scale(0.8); transition: transform 0.3s ease;
    }
    .gallery-item:hover .zoom-icon { transform: scale(1); }

    /* Card Content */
    .gallery-caption {
        padding: 15px; background: white; border-top: 1px solid #f0f0f0;
        flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;
    }

    .trip-tag {
        font-size: 0.8rem; color: var(--accent-color); font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.5px;
        margin-bottom: 5px; display: block;
    }

    .caption-text {
        font-size: 0.95rem; color: var(--text-dark); margin-bottom: 0; line-height: 1.4;
    }

    /* --- 6. FILTER BAR --- */
    .filter-bar {
        background: white; padding: 10px 10px 10px 25px;
        border-radius: 50px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        display: inline-flex; align-items: center; gap: 15px;
        max-width: 800px; margin-bottom: 40px;
        transition: transform 0.3s ease;
    }
    .filter-bar:hover { transform: translateY(-3px); }

    .form-select-custom {
        border: none; background-color: var(--bg-off-white);
        border-radius: 30px; padding: 10px 20px;
        font-weight: 500; cursor: pointer; outline: none;
        transition: background 0.3s;
    }
    .form-select-custom:hover { background-color: #eee; }

    .btn-filter {
        background: var(--primary-dark); color: white; border: none;
        border-radius: 30px; padding: 10px 25px; font-weight: 600;
        transition: all 0.3s;
    }
    .btn-filter:hover { background: var(--accent-color); box-shadow: 0 4px 12px rgba(229, 115, 45, 0.3); }

</style>
@endsection

@section('content')

<div class="gallery-header">
    <div class="container">
        <h1 class="hero-animate-down display-3 fw-bold mb-2" style="text-shadow: 0 4px 10px rgba(0,0,0,0.5);">
            Our Memories
        </h1>
        <p class="hero-animate-up delay-200 lead opacity-90" style="text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
            Capturing the unforgettable moments from every peak.
        </p>
    </div>
</div>

<div class="container pb-5">
    
    <div class="text-center hero-animate-up delay-400">
        <form method="GET" action="{{ route('gallery.index') }}" class="d-inline-block">
            <div class="filter-bar">
                <span class="text-muted fw-bold d-none d-md-inline">Filter By Trip:</span>
                <select name="trip_id" class="form-select-custom">
                    <option value="">All Adventures</option>
                    @foreach($trips as $trip)
                    <option value="{{ $trip->id }}" {{ request('trip_id') == $trip->id ? 'selected' : '' }}>
                        {{ Str::limit($trip->title, 40) }}
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="btn-filter">
                    <i class="fas fa-filter me-2"></i> Show
                </button>
            </div>
        </form>
    </div>

    @if($galleries->count() > 0)
    <div class="row g-4">
        {{-- LOOPING PERTAMA: HANYA UNTUK TAMPILAN GRID (Dengan AOS) --}}
        @foreach($galleries as $gallery)
        <div class="col-sm-6 col-lg-4 col-xl-3" 
             data-aos="fade-up" 
             data-aos-delay="{{ $loop->iteration * 100 }}"
             data-aos-duration="800">
             
            <div class="gallery-item" data-bs-toggle="modal" data-bs-target="#imageModal{{ $gallery->id }}">
                <div class="img-wrapper">
                    <img src="{{ Str::startsWith($gallery->image_path, 'http') ? $gallery->image_path : asset('storage/'.$gallery->image_path) }}" 
                         alt="{{ $gallery->caption }}">
                    
                    <div class="hover-overlay">
                        <div class="zoom-icon">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                </div>
                
                <div class="gallery-caption">
                    <div>
                        <span class="trip-tag">
                            <i class="fas fa-mountain me-1"></i> {{ Str::limit($gallery->trip->title, 20) }}
                        </span>
                        @if($gallery->caption)
                        <p class="caption-text">{{ Str::limit($gallery->caption, 50) }}</p>
                        @else
                        <p class="caption-text text-muted fst-italic small">No caption provided</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-5" data-aos="fade-up" data-aos-delay="200">
        {{ $galleries->links() }}
    </div>

    {{-- LOOPING KEDUA: KHUSUS UNTUK MODAL POPUP (Di luar element AOS) --}}
    @foreach($galleries as $gallery)
    <div class="modal fade" id="imageModal{{ $gallery->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-0">
                    <img src="{{ Str::startsWith($gallery->image_path, 'http') ? $gallery->image_path : asset('storage/'.$gallery->image_path) }}" 
                         class="img-fluid rounded shadow-lg" 
                         style="max-height: 85vh;" 
                         alt="{{ $gallery->caption }}">
                    
                    @if($gallery->caption)
                    <div class="mt-3 text-white">
                        <h5 class="fw-bold mb-1">{{ $gallery->caption }}</h5>
                        <small class="opacity-75">{{ $gallery->trip->title }}</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @else
    <div class="text-center py-5 bg-light rounded-4 border border-dashed mt-4" data-aos="zoom-in">
        <div class="mb-3 text-muted opacity-50">
            <i class="fas fa-camera-retro fa-3x"></i>
        </div>
        <h5 class="fw-bold">No Photos Yet</h5>
        <p class="text-muted mb-0">We haven't uploaded any documentation for this category yet.</p>
        <a href="{{ route('gallery.index') }}" class="btn btn-outline-dark mt-3 rounded-pill px-4">View All Photos</a>
    </div>
    @endif

</div>

@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    // Init AOS
    AOS.init({
        once: true,
        offset: 80,
    });

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