@extends('layouts.app')

@section('title', 'Register - HikersHub')

@section('styles')
<style>
    /* Hilangkan scrollbar default body */
    body {
        overflow-x: hidden;
    }

    /* --- 1. LAYOUT UTAMA --- */
    .register-wrapper {
        min-height: calc(100vh - 80px); 
        width: 100%;
        display: flex;
        padding-top: 0 !important; 
        overflow: hidden;
    }

    /* --- 2. BAGIAN KIRI (GAMBAR) --- */
    .register-image-side {
        /* Menggunakan gambar yang sedikit berbeda atau sama agar konsisten */
        background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(229, 115, 45, 0.6)), url('{{ asset("images/Elvin.jpg") }}');
        background-size: cover;
        background-position: center;
        
        flex: 1.5; /* Lebar 60% */
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 60px;
        color: white;
        position: relative;
    }

    /* --- 3. BAGIAN KANAN (FORM) --- */
    .register-form-side {
        flex: 1; /* Lebar 40% */
        background-color: white;
        
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        
        /* Penting: Agar form panjang bisa discroll */
        overflow-y: auto; 
        max-height: calc(100vh - 80px);
    }

    /* Responsif Mobile */
    @media (max-width: 991px) {
        .register-wrapper {
            flex-direction: column;
            min-height: auto;
        }
        
        .register-image-side { 
            display: none; 
        }
        
        .register-form-side { 
            width: 100%; 
            padding: 40px 20px;
            min-height: calc(100vh - 80px);
            max-height: none; /* Hilangkan batas tinggi di HP */
            overflow-y: visible;
        }
    }

    /* --- 4. TYPOGRAPHY & ELEMENTS --- */
    .brand-title {
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: -1px;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: auto; 
    }

    .quote-box { max-width: 550px; }
    
    .quote-text {
        font-size: 3rem;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 20px;
        text-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }

    .form-container { width: 100%; max-width: 450px; }

    /* Input Modern */
    .form-floating > .form-control {
        border-radius: 12px;
        border: 1px solid #e0e0e0;
        height: 55px;
        padding-left: 20px;
        background-color: #fcfcfc;
    }
    
    /* Fokus warna oranye untuk Register (pembeda dikit) */
    .form-floating > .form-control:focus {
        border-color: #e5732d;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(229, 115, 45, 0.1);
    }

    /* Tombol Gradient Oranye */
    .btn-register {
        background: linear-gradient(45deg, #e5732d, #ff9f43);
        border: none;
        color: white;
        padding: 16px;
        font-weight: 700;
        font-size: 1rem;
        border-radius: 50px;
        width: 100%;
        transition: all 0.3s;
        margin-top: 10px;
        margin-bottom: 25px;
        box-shadow: 0 10px 20px rgba(229, 115, 45, 0.2);
    }

    .btn-register:hover {
        background: linear-gradient(45deg, #d35400, #e67e22);
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(229, 115, 45, 0.3);
        color: white;
    }

    .link-primary-custom { color: #2c5f2d; text-decoration: none; font-weight: 600; transition: 0.3s; }
    .link-primary-custom:hover { color: #1e4220; text-decoration: underline; }
</style>
@endsection

@section('content')

<div class="register-wrapper">
    
    <div class="register-image-side">
        <div class="brand-title text-white-50">
            <small class="text-uppercase fw-bold ls-2" style="letter-spacing: 2px;">Start Your Journey</small>
        </div>

        <div class="quote-box">
            <h2 class="quote-text">"The best view comes after the hardest climb."</h2>
            <p class="opacity-75 fs-5 mt-3">Join our community of hikers today.</p>
        </div>

        <div class="mt-auto text-white-50 small">
            &copy; {{ date('Y') }} HikersHub Indonesia.
        </div>
    </div>

    <div class="register-form-side">
        <div class="form-container">
            
            <div class="text-center mb-4">
                <div class="mb-3 d-inline-block p-3 rounded-circle" style="background: rgba(229, 115, 45, 0.1); color: #e5732d;">
                    <i class="fas fa-user-plus fa-3x"></i>
                </div>
                <h2 class="fw-bold text-dark">Create Account</h2>
                <p class="text-muted">Fill in your details to get started.</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" 
                           placeholder="Full Name" required autofocus>
                    <label for="name">Full Name</label>
                    @error('name')
                        <div class="invalid-feedback ps-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" 
                           placeholder="name@example.com" required>
                    <label for="email">Email Address</label>
                    @error('email')
                        <div class="invalid-feedback ps-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                           id="phone" name="phone" value="{{ old('phone') }}" 
                           placeholder="Phone Number">
                    <label for="phone">Phone Number (Optional)</label>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" placeholder="Password" required>
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" 
                                   placeholder="Confirm" required>
                            <label for="password_confirmation">Confirm</label>
                        </div>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block ps-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="terms" required>
                    <label class="form-check-label text-muted small" for="terms">
                        I agree to the <a href="#" class="link-primary-custom">Terms & Conditions</a>
                    </label>
                </div>

                <button type="submit" class="btn-register">
                    Sign Up
                </button>

                <div class="text-center">
                    <span class="text-muted small">Already have an account?</span>
                    <a href="{{ route('login') }}" class="link-primary-custom small ms-1">Sign In</a>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection