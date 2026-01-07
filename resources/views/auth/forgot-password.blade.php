@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            
            <div class="card shadow">
                <div class="card-body p-5">
                    
                    <div class="text-center mb-4">
                        <i class="fas fa-key fa-3x text-warning mb-3"></i>
                        <h3 class="fw-bold">Forgot Password?</h3>
                        <p class="text-muted">No problem. Just let us know your email address and we will email you a password reset link.</p>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success mb-4">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-4">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" 
                                   type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus
                                   placeholder="your@email.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-envelope"></i> Email Password Reset Link
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}" class="text-muted text-decoration-none">
                                <i class="fas fa-arrow-left"></i> Back to Login
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection