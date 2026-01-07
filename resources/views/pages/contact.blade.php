@extends('layouts.app')

@section('title', 'Contact Us')

@section('styles')
<style>
    /* --- 1. PALETTE --- */
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
    .contact-header {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.8)), url('{{ asset("images/Elvin.jpg") }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        padding: 180px 0 100px 0;
        color: white;
        text-align: center;
        margin-bottom: 50px;
    }

    /* --- 4. FORM CARD --- */
    .contact-card {
        background: white;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        overflow: hidden;
        height: 100%;
    }

    .contact-card-header {
        background: var(--primary-dark);
        color: white;
        padding: 25px 30px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .contact-card-body {
        padding: 40px;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    .form-control {
        border-radius: 12px;
        padding: 12px 15px;
        border: 1px solid #eee;
        background-color: var(--bg-off-white);
        font-size: 0.95rem;
        transition: all 0.3s;
    }

    .form-control:focus {
        background-color: white;
        border-color: var(--primary-light);
        box-shadow: 0 0 0 4px rgba(151, 188, 98, 0.1);
    }

    .btn-send {
        background: var(--accent-color);
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-send:hover {
        background: #c45d1e;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(229, 115, 45, 0.3);
        color: white;
    }

    /* --- 5. INFO SIDEBAR --- */
    .info-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        margin-bottom: 25px;
        border-left: 5px solid var(--primary-light);
        transition: transform 0.3s;
    }
    
    .info-card:hover { transform: translateX(5px); }

    .info-icon-wrapper {
        width: 50px;
        height: 50px;
        background: rgba(44, 95, 45, 0.1);
        color: var(--primary-dark);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-bottom: 15px;
    }

    .info-title {
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 10px;
        font-size: 1.1rem;
    }

    .info-text {
        color: var(--text-grey);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 0;
    }

    .social-link {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg-off-white);
        color: var(--primary-dark);
        transition: all 0.3s;
        text-decoration: none;
    }

    .social-link:hover {
        background: var(--accent-color);
        color: white;
        transform: scale(1.1);
    }

</style>
@endsection

@section('content')

<div class="contact-header">
    <div class="container">
        <h1 class="display-3 fw-bold mb-3">Get in Touch</h1>
        <p class="lead opacity-90 mx-auto" style="max-width: 600px;">
            Have questions about a trip or need help planning your adventure? We're here to help!
        </p>
    </div>
</div>

<div class="container pb-5" style="margin-top: -80px; position: relative; z-index: 10;">
    <div class="row g-5">
        
        <div class="col-lg-8">
            <div class="contact-card">
                <div class="contact-card-header">
                    <i class="fas fa-envelope-open-text fa-2x"></i>
                    <div>
                        <h4 class="mb-0">Send us a Message</h4>
                        <small class="opacity-75 font-weight-normal">We usually reply within 24 hours</small>
                    </div>
                </div>
                
                <div class="contact-card-body">
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Your Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', auth()->user()->name ?? '') }}" 
                                       placeholder="John Doe"
                                       required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Your Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', auth()->user()->email ?? '') }}" 
                                       placeholder="john@example.com"
                                       required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Subject <span class="text-danger">*</span></label>
                            <input type="text" name="subject" 
                                   class="form-control @error('subject') is-invalid @enderror" 
                                   value="{{ old('subject') }}" 
                                   placeholder="e.g., Question about Rinjani Trip booking"
                                   required>
                            @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label class="form-label">Message <span class="text-danger">*</span></label>
                            <textarea name="message" 
                                      class="form-control @error('message') is-invalid @enderror" 
                                      rows="6" 
                                      placeholder="Tell us how we can help you..."
                                      required>{{ old('message') }}</textarea>
                            @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn-send">
                            Send Message <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            
            <div class="info-card">
                <div class="info-icon-wrapper">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h5 class="info-title">Headquarters</h5>
                <p class="info-text">
                    Jl. Sudirman No. 123<br>
                    Jakarta Pusat, DKI Jakarta<br>
                    Indonesia 10110
                </p>
            </div>

            <div class="info-card">
                <div class="info-icon-wrapper">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <h5 class="info-title">Phone Support</h5>
                <p class="info-text">
                    Office: +62 21 1234 5678<br>
                    WhatsApp: <a href="#" class="text-decoration-none text-success fw-bold">+62 812 3456 7890</a>
                </p>
            </div>

            <div class="info-card">
                <div class="info-icon-wrapper">
                    <i class="fas fa-at"></i>
                </div>
                <h5 class="info-title">Email Us</h5>
                <p class="info-text">
                    General: info@hikershub.com<br>
                    Support: support@hikershub.com
                </p>
            </div>

            <div class="info-card border-left-0 border-top-0">
                <h5 class="info-title mb-4">Follow Us</h5>
                <div class="d-flex gap-3">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
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