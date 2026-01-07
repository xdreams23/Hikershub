@extends('layouts.app')

@section('title', 'Login - HikersHub')

@section('styles')
<style>
    /* Hilangkan scrollbar default jika ingin tampilan benar-benar locked */
    body {
        overflow-x: hidden; /* Hanya hilangkan scroll horizontal */
    }

    /* --- 1. LAYOUT UTAMA --- */
    .login-wrapper {
        /* Ganti height 100vh menjadi calc() agar pas dikurangi tinggi navbar */
        /* Asumsi tinggi navbar sekitar 70-80px */
        min-height: calc(100vh - 80px); 
        width: 100%;
        display: flex;
        
        /* HAPUS padding-top agar gambar nempel langsung ke navbar */
        padding-top: 0 !important; 
        
        overflow: hidden;
    }

    /* --- 2. BAGIAN KIRI (GAMBAR) --- */
    .login-image-side {
        background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(44, 95, 45, 0.7)), url('{{ asset("images/Elvin.jpg") }}');
        background-size: cover;
        background-position: center;
        
        flex: 1.5; /* Lebar 60% */
        /* Tidak perlu set height 100% manual karena flex container sudah handle */
        
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 60px;
        color: white;
        position: relative;
    }

    /* --- 3. BAGIAN KANAN (FORM) --- */
    .login-form-side {
        flex: 1; /* Lebar 40% */
        background-color: white;
        
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        
        /* Scroll internal jika layar pendek */
        overflow-y: auto; 
    }

    /* Responsif Mobile */
    @media (max-width: 991px) {
        .login-wrapper {
            flex-direction: column;
            min-height: auto; /* Biarkan tinggi otomatis di HP */
        }
        
        .login-image-side { 
            display: none; 
        }
        
        .login-form-side { 
            width: 100%; 
            padding: 40px 20px;
            min-height: calc(100vh - 80px); /* Full screen di HP */
        }
    }

    /* --- 4. TYPOGRAPHY & ELEMEN LAIN (TETAP SAMA) --- */
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
        font-size: 2.8rem;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 20px;
        text-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }

    .form-container { width: 100%; max-width: 420px; }

    /* Input Modern */
    .form-floating > .form-control {
        border-radius: 12px;
        border: 1px solid #e0e0e0;
        height: 55px;
        padding-left: 20px;
        background-color: #fcfcfc;
    }
    
    .form-floating > .form-control:focus {
        border-color: #2c5f2d;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(44, 95, 45, 0.1);
    }

    .btn-login {
        background-color: #2c5f2d;
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
        box-shadow: 0 10px 20px rgba(44, 95, 45, 0.15);
    }

    .btn-login:hover {
        background-color: #1e4220;
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(44, 95, 45, 0.25);
        color: white;
    }

    .link-accent { color: #e5732d; text-decoration: none; font-weight: 600; transition: 0.3s; }
    .link-accent:hover { color: #d35400; text-decoration: underline; }
</style>
@endsection

@section('content')

<div class="login-wrapper">
    
    <div class="login-image-side">
        <div class="brand-title text-white-50">
            <small class="text-uppercase fw-bold ls-2" style="letter-spacing: 2px;">Adventure Awaits</small>
        </div>

        <div class="quote-box">
            <h2 class="quote-text">"It is not the mountain we conquer, but ourselves."</h2>
            <p class="opacity-75 fs-5 mt-3">— Edmund Hillary</p>
        </div>

        <div class="mt-auto text-white-50 small">
            &copy; {{ date('Y') }} HikersHub Indonesia.
        </div>
    </div>

    <div class="login-form-side">
        <div class="form-container">
            
            <div class="text-center mb-5">
                <div class="mb-3 d-inline-block p-3 rounded-circle" style="background: rgba(44, 95, 45, 0.1); color: #2c5f2d;">
                    <i class="fas fa-user-circle fa-3x"></i>
                </div>
                <h2 class="fw-bold text-dark">Welcome Back!</h2>
                <p class="text-muted">Please enter your details to sign in.</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-floating mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" 
                           placeholder="name@example.com" required autofocus>
                    <label for="email">Email Address</label>
                    @error('email')
                        <div class="invalid-feedback ps-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" placeholder="Password" required>
                    <label for="password">Password</label>
                    @error('password')
                        <div class="invalid-feedback ps-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-muted small" for="remember">
                            Remember me
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="small link-accent" href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn-login">
                    Sign In
                </button>

                <div class="text-center">
                    <span class="text-muted small">Don't have an account yet?</span>
                    <a href="{{ route('register') }}" class="link-accent small ms-1">Create Account</a>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection