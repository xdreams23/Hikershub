@extends('layouts.user')

@section('title', 'Edit Profile')
@section('page-title', 'Account Settings')

@section('styles')
<style>
    /* Profile Card */
    .profile-card {
        background: white;
        border-radius: 20px;
        border: none;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        text-align: center;
        padding: 40px 20px;
        position: sticky;
        top: 100px;
    }

    .avatar-circle {
        width: 120px;
        height: 120px;
        background: var(--primary-light);
        color: white;
        font-size: 3rem;
        font-weight: 700;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px auto;
        border: 5px solid #f8f9fa;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    /* Form Section */
    .settings-card {
        background: white;
        border-radius: 20px;
        border: none;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        margin-bottom: 30px;
        overflow: hidden;
    }

    .settings-header {
        padding: 20px 30px;
        background: white;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
    }

    .settings-body {
        padding: 30px;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.9rem;
    }

    .form-control, .form-select {
        border-radius: 10px;
        padding: 10px 15px;
        border: 1px solid #eee;
        background-color: #fcfcfc;
    }

    .form-control:focus {
        border-color: var(--primary-light);
        background-color: white;
        box-shadow: 0 0 0 3px rgba(151, 188, 98, 0.1);
    }

    .section-divider {
        height: 1px;
        background: #eee;
        margin: 30px 0;
    }

    .btn-save {
        background: var(--primary-dark);
        color: white;
        padding: 12px 30px;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-save:hover { background: #1e4220; color: white; transform: translateY(-2px); }

</style>
@endsection

@section('content')

<div class="row g-4">
    
    <div class="col-lg-4">
        <div class="profile-card">
            <div class="avatar-circle">
                {{ substr($user->name, 0, 1) }}
            </div>
            <h4 class="fw-bold text-dark mb-1">{{ $user->name }}</h4>
            <p class="text-muted mb-3">{{ $user->email }}</p>
            
            <div class="d-flex justify-content-center gap-2 mb-4">
                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                    Member since {{ $user->created_at->format('Y') }}
                </span>
            </div>

            <div class="row g-2 border-top pt-4">
                <div class="col-6 border-end">
                    <h5 class="fw-bold text-success mb-0">{{ $user->bookings->count() }}</h5>
                    <small class="text-muted text-uppercase" style="font-size: 0.7rem;">Trips Booked</small>
                </div>
                <div class="col-6">
                    <h5 class="fw-bold text-warning mb-0">{{ $user->reviews->count() ?? 0 }}</h5>
                    <small class="text-muted text-uppercase" style="font-size: 0.7rem;">Reviews</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        
        <div class="settings-card">
            <div class="settings-header">
                <h5 class="mb-0 fw-bold"><i class="fas fa-user-edit me-2 text-success"></i> Personal Details</h5>
            </div>
            <div class="settings-body">
                <form action="{{ route('user.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone', $user->phone) }}" placeholder="+62..." required>
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                   value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}" required>
                            @error('date_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Gender</label>
                            <div class="d-flex gap-4 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" value="male" id="male" 
                                           {{ old('gender', $user->gender) == 'male' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" value="female" id="female" 
                                           {{ old('gender', $user->gender) == 'female' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>
                            @error('gender') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="section-divider"></div>

                    <h6 class="fw-bold mb-3 text-muted text-uppercase small">Emergency Contact (Safety)</h6>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Contact Name</label>
                            <input type="text" name="emergency_contact_name" class="form-control @error('emergency_contact_name') is-invalid @enderror" 
                                   value="{{ old('emergency_contact_name', $user->emergency_contact_name) }}" required>
                            @error('emergency_contact_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Contact Phone</label>
                            <input type="text" name="emergency_contact_phone" class="form-control @error('emergency_contact_phone') is-invalid @enderror" 
                                   value="{{ old('emergency_contact_phone', $user->emergency_contact_phone) }}" required>
                            @error('emergency_contact_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn-save">
                            <i class="fas fa-save me-2"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="settings-card">
            <div class="settings-header">
                <h5 class="mb-0 fw-bold text-danger"><i class="fas fa-lock me-2"></i> Security & Password</h5>
            </div>
            <div class="settings-body">
                <form action="{{ route('user.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            <small class="text-muted">Min. 8 characters</small>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-outline-danger px-4 rounded-3 fw-bold">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection