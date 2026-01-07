@extends('layouts.app')

@section('title', 'About Us')

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

    /* --- 3. HERO HEADER --- */
    .about-header {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.8)), url('{{ asset("images/Elvin.jpg") }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        padding: 200px 0 120px 0;
        color: white;
        text-align: center;
        margin-bottom: 0;
    }

    /* --- 4. CONTENT SECTIONS --- */
    .section-title {
        font-weight: 800;
        color: var(--primary-dark);
        margin-bottom: 20px;
        position: relative;
        display: inline-block;
    }
    .section-title::after {
        content: '';
        display: block;
        width: 50px;
        height: 4px;
        background: var(--accent-color);
        margin-top: 10px;
        border-radius: 2px;
    }

    .content-box {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        margin-bottom: 30px;
        height: 100%;
        transition: transform 0.3s;
    }
    
    .content-box:hover { transform: translateY(-5px); }

    .feature-icon {
        width: 70px;
        height: 70px;
        background: rgba(44, 95, 45, 0.1);
        color: var(--primary-dark);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 20px;
    }

    /* Stats Cards */
    .stat-card {
        background: white;
        padding: 30px;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        border-bottom: 5px solid var(--accent-color);
        transition: transform 0.3s;
    }
    .stat-card:hover { transform: translateY(-5px); }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary-dark);
        margin-bottom: 5px;
    }
    .stat-label {
        color: var(--text-grey);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9rem;
    }

    /* Team / Values List */
    .value-list li {
        margin-bottom: 15px;
        display: flex;
        align-items: start;
    }
    .value-list i {
        color: var(--accent-color);
        margin-right: 15px;
        margin-top: 5px;
    }

    /* Contact Box */
    .contact-box {
        background: var(--primary-dark);
        color: white;
        padding: 40px;
        border-radius: 20px;
    }
    .contact-item {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    .contact-icon {
        width: 40px;
        height: 40px;
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }

</style>
@endsection

@section('content')

<div class="about-header">
    <div class="container">
        <h1 class="display-3 fw-bold mb-3">About HikersHub</h1>
        <p class="lead opacity-90 mx-auto" style="max-width: 700px;">
            We are more than just a travel platform. We are a community of explorers dedicated to connecting you with the majestic beauty of Indonesia's peaks.
        </p>
    </div>
</div>

<div class="container" style="margin-top: -60px; position: relative; z-index: 10;">
    <div class="row g-4 justify-content-center">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-number">5000+</div>
                <div class="stat-label">Happy Hikers</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-number">500+</div>
                <div class="stat-label">Successful Trips</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-number">50+</div>
                <div class="stat-label">Mountains Conquered</div>
            </div>
        </div>
    </div>
</div>

<div class="container my-5 py-5">
    <div class="row g-5 align-items-center">
        <div class="col-lg-6">
            <h2 class="section-title">Who We Are</h2>
            <p class="lead text-dark fw-bold mb-4">
                HikersHub is Indonesia's premier open trip platform, born from a passion for high altitudes and shared adventures.
            </p>
            <p class="text-muted" style="line-height: 1.8;">
                Founded in 2020, we started with a simple mission: to make mountain hiking accessible, safe, and fun for everyone. We noticed that many people wanted to explore Indonesia's breathtaking volcanoes but lacked the companions, gear, or logistical know-how.
            </p>
            <p class="text-muted" style="line-height: 1.8;">
                Today, we've grown into a trusted community where solo travelers find new friends, and experienced hikers discover new challenges. We handle the logistics so you can focus on the journey.
            </p>
        </div>
        <div class="col-lg-6">
            <div class="row g-4">
                <div class="col-sm-6">
                    <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?q=80&w=1740&auto=format&fit=crop" class="img-fluid rounded-4 shadow mb-4 w-100" alt="Hiking Group" style="height: 300px; object-fit: cover;">
                </div>
                <div class="col-sm-6 mt-sm-5">
                    <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=1740&auto=format&fit=crop" class="img-fluid rounded-4 shadow w-100" alt="Mountain View" style="height: 300px; object-fit: cover;">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-light py-5">
    <div class="container py-4">
        <div class="row g-5">
            <div class="col-lg-5">
                <div class="content-box border-0">
                    <h3 class="fw-bold mb-4 text-dark">Our Mission</h3>
                    <ul class="list-unstyled value-list">
                        <li>
                            <i class="fas fa-check-circle fa-lg"></i>
                            <span>Make mountain hiking accessible and affordable for everyone.</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle fa-lg"></i>
                            <span>Promote safe, eco-friendly, and responsible hiking practices.</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle fa-lg"></i>
                            <span>Support local economies by partnering with local guides and porters.</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle fa-lg"></i>
                            <span>Build a supportive community of outdoor enthusiasts.</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-7">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="content-box">
                            <div class="feature-icon">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <h5 class="fw-bold">Professional Guides</h5>
                            <p class="text-muted small mb-0">Certified experts trained in wilderness first aid and rescue protocols.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="content-box">
                            <div class="feature-icon" style="background: rgba(229, 115, 45, 0.1); color: var(--accent-color);">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h5 class="fw-bold">Safety First</h5>
                            <p class="text-muted small mb-0">Comprehensive insurance coverage and strict safety standards for every trip.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="content-box">
                            <div class="feature-icon" style="background: rgba(23, 162, 184, 0.1); color: #17a2b8;">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <h5 class="fw-bold">Eco-Friendly</h5>
                            <p class="text-muted small mb-0">Commitment to 'Leave No Trace' principles to protect our nature.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="content-box">
                            <div class="feature-icon" style="background: rgba(255, 193, 7, 0.1); color: #ffc107;">
                                <i class="fas fa-users"></i>
                            </div>
                            <h5 class="fw-bold">Community</h5>
                            <p class="text-muted small mb-0">Join a vibrant network of thousands of hikers across Indonesia.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-5 py-5">
    <div class="row g-5">
        <div class="col-lg-7">
            <h3 class="section-title">Sustainability Commitment</h3>
            <p class="text-muted lead mb-4">
                We believe that we are merely visitors to these mountains. It is our duty to leave them better than we found them.
            </p>
            <p class="text-muted">
                HikersHub actively participates in mountain cleanup events and contributes a percentage of our profits to reforestation projects. We educate every participant on responsible waste management and respect for local customs.
            </p>
        </div>
        <div class="col-lg-5">
            <div class="contact-box">
                <h4 class="fw-bold mb-4">Get in Touch</h4>
                <div class="contact-item">
                    <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <small class="opacity-75 d-block">Headquarters</small>
                        <strong>Jakarta, Indonesia</strong>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                    <div>
                        <small class="opacity-75 d-block">Email Support</small>
                        <strong>info@hikerhub.com</strong>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon"><i class="fas fa-phone"></i></div>
                    <div>
                        <small class="opacity-75 d-block">Call Us</small>
                        <strong>+62 812-3456-7890</strong>
                    </div>
                </div>
                
                <hr class="border-white opacity-25 my-4">
                
                <div class="d-flex gap-3">
                    <a href="#" class="text-white opacity-75 hover-opacity-100"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-white opacity-75 hover-opacity-100"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-white opacity-75 hover-opacity-100"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#" class="text-white opacity-75 hover-opacity-100"><i class="fab fa-youtube fa-lg"></i></a>
                </div>
            </div>
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