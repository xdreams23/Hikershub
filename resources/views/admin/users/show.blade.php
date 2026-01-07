@extends('layouts.admin')

@section('title', 'User Details')
@section('page-title', 'User Details')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
<li class="breadcrumb-item active">{{ $user->name }}</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-4">
        
        <!-- User Info Card -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <i class="fas fa-user-circle fa-5x text-secondary"></i>
                </div>
                <h3 class="profile-username text-center">{{ $user->name }}</h3>
                <p class="text-muted text-center">
                    @if($user->role == 'admin')
                    <span class="badge badge-danger">Administrator</span>
                    @else
                    <span class="badge badge-primary">User</span>
                    @endif
                </p>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Total Bookings</b> <a class="float-right">{{ $user->bookings->count() }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Total Reviews</b> <a class="float-right">{{ $user->reviews->count() }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Member Since</b> <a class="float-right">{{ formatDate($user->created_at, 'd M Y') }}</a>
                    </li>
                </ul>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-block">
                    <i class="fas fa-edit"></i> Edit Profile
                </a>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Contact Information</h3>
            </div>
            <div class="card-body">
                <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                <p class="text-muted">{{ $user->email }}</p>
                <hr>
                <strong><i class="fas fa-phone mr-1"></i> Phone</strong>
                <p class="text-muted">{{ $user->phone ?? 'Not provided' }}</p>
                <hr>
                <strong><i class="fas fa-birthday-cake mr-1"></i> Date of Birth</strong>
                <p class="text-muted">{{ $user->date_of_birth ? formatDate($user->date_of_birth, 'd M Y') : 'Not provided' }}</p>
                <hr>
                <strong><i class="fas fa-venus-mars mr-1"></i> Gender</strong>
                <p class="text-muted">{{ $user->gender ? ucfirst($user->gender) : 'Not provided' }}</p>
            </div>
        </div>

        <!-- Emergency Contact -->
        @if($user->emergency_contact_name)
        <div class="card">
            <div class="card-header bg-danger">
                <h3 class="card-title">Emergency Contact</h3>
            </div>
            <div class="card-body">
                <strong><i class="fas fa-user mr-1"></i> Name</strong>
                <p class="text-muted">{{ $user->emergency_contact_name }}</p>
                <hr>
                <strong><i class="fas fa-phone mr-1"></i> Phone</strong>
                <p class="text-muted">{{ $user->emergency_contact_phone }}</p>
            </div>
        </div>
        @endif

    </div>

    <div class="col-md-8">
        
        <!-- Booking History -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Booking History</h3>
            </div>
            <div class="card-body">
                @if($user->bookings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Booking Code</th>
                                <th>Trip</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->bookings->take(10) as $booking)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.bookings.show', $booking) }}">
                                        {{ $booking->booking_code }}
                                    </a>
                                </td>
                                <td>{{ Str::limit($booking->trip->title, 30) }}</td>
                                <td>{{ formatDate($booking->created_at, 'd M Y') }}</td>
                                <td>{{ $booking->formatted_total_price }}</td>
                                <td>{!! $booking->status_badge !!}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted text-center">No bookings yet.</p>
                @endif
            </div>
        </div>

        <!-- Reviews -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">User Reviews</h3>
            </div>
            <div class="card-body">
                @if($user->reviews->count() > 0)
                @foreach($user->reviews as $review)
                <div class="mb-3 pb-3 border-bottom">
                    <div class="d-flex justify-content-between">
                        <strong>{{ $review->trip->title }}</strong>
                        <span>{!! generateStars($review->rating) !!}</span>
                    </div>
                    <p class="text-muted small mb-0">{{ $review->comment }}</p>
                    <small class="text-muted">{{ diffForHumans($review->created_at) }}</small>
                </div>
                @endforeach
                @else
                <p class="text-muted text-center">No reviews yet.</p>
                @endif
            </div>
        </div>

    </div>
</div>

@endsection