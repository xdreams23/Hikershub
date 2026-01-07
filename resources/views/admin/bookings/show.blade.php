@extends('layouts.admin')

@section('title', 'Booking Details')
@section('page-title', 'Booking Details')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Bookings</a></li>
<li class="breadcrumb-item active">{{ $booking->booking_code }}</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-8">
        
        <!-- Booking Information -->
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">Booking Information</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Booking Code:</strong> <span class="text-primary">{{ $booking->booking_code }}</span></p>
                        <p><strong>Booking Date:</strong> {{ formatDate($booking->created_at) }}</p>
                        <p><strong>Status:</strong> {!! $booking->status_badge !!}</p>
                        <p><strong>Participants:</strong> {{ $booking->participants_count }} person(s)</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Total Price:</strong> <span class="text-success h4">{{ $booking->formatted_total_price }}</span></p>
                        <p><strong>Price per Person:</strong> {{ $booking->trip->formatted_price }}</p>
                    </div>
                </div>
                
                @if($booking->notes)
                <hr>
                <p><strong>Customer Notes:</strong></p>
                <p class="text-muted">{{ $booking->notes }}</p>
                @endif
            </div>
        </div>

        <!-- User Information -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">User Information</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $booking->user->name }}</p>
                        <p><strong>Email:</strong> {{ $booking->user->email }}</p>
                        <p><strong>Phone:</strong> {{ $booking->user->phone ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Emergency Contact:</strong> {{ $booking->user->emergency_contact_name ?? 'N/A' }}</p>
                        <p><strong>Emergency Phone:</strong> {{ $booking->user->emergency_contact_phone ?? 'N/A' }}</p>
                        <p><strong>Date of Birth:</strong> {{ $booking->user->date_of_birth ? formatDate($booking->user->date_of_birth, 'd M Y') : 'N/A' }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.users.show', $booking->user) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-user"></i> View Full Profile
                </a>
            </div>
        </div>

        <!-- Trip Information -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Trip Information</h3>
            </div>
            <div class="card-body">
                <h5>{{ $booking->trip->title }}</h5>
                <p class="text-muted"><i class="fas fa-mountain"></i> {{ $booking->trip->mountain->name }} - {{ $booking->trip->mountain->location }}</p>
                
                <div class="row">
                    <div class="col-md-6">
                        <p><i class="fas fa-calendar"></i> <strong>Start:</strong> {{ formatDate($booking->trip->start_date) }}</p>
                        <p><i class="fas fa-flag-checkered"></i> <strong>End:</strong> {{ formatDate($booking->trip->end_date) }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><i class="fas fa-clock"></i> <strong>Duration:</strong> {{ $booking->trip->duration_days }} Days</p>
                        <p><i class="fas fa-map-pin"></i> <strong>Meeting Point:</strong> {{ $booking->trip->meeting_point }}</p>
                    </div>
                </div>
                
                <a href="{{ route('admin.trips.show', $booking->trip) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-hiking"></i> View Trip Details
                </a>
            </div>
        </div>

        <!-- Payment Information -->
        @if($booking->payment)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Payment Information</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Amount:</strong> {{ $booking->payment->formatted_amount }}</p>
                        <p><strong>Payment Method:</strong> {{ ucfirst($booking->payment->payment_method) }}</p>
                        <p><strong>Payment Date:</strong> {{ formatDate($booking->payment->payment_date) }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Status:</strong> {!! $booking->payment->status_badge !!}</p>
                        @if($booking->payment->verified_at)
                        <p><strong>Verified At:</strong> {{ formatDate($booking->payment->verified_at) }}</p>
                        <p><strong>Verified By:</strong> {{ $booking->payment->verifier->name }}</p>
                        @endif
                    </div>
                </div>

                @if($booking->payment_proof)
                <hr>
                <p><strong>Payment Proof:</strong></p>
                <a href="{{ asset('storage/'.$booking->payment_proof) }}" target="_blank">
                    <img src="{{ asset('storage/'.$booking->payment_proof) }}" 
                         class="img-thumbnail" 
                         alt="Payment Proof"
                         style="max-height: 300px;">
                </a>
                @endif

                @if($booking->payment->status == 'pending')
                <hr>
                <a href="{{ route('admin.payments.show', $booking->payment) }}" class="btn btn-warning">
                    <i class="fas fa-check"></i> Verify Payment
                </a>
                @endif
            </div>
        </div>
        @endif

    </div>

    <!-- Sidebar Actions -->
    <div class="col-md-4">
        
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Actions</h3>
            </div>
            <div class="card-body">
                
                <!-- Update Status -->
                <button type="button" class="btn btn-primary btn-block mb-2" data-toggle="modal" data-target="#statusModal">
                    <i class="fas fa-edit"></i> Update Status
                </button>

                <!-- Cancel Booking -->
                @if($booking->status != 'cancelled')
                <form action="{{ route('admin.bookings.cancel', $booking) }}" 
                      method="POST" 
                      onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-block">
                        <i class="fas fa-times"></i> Cancel Booking
                    </button>
                </form>
                @endif

                <hr>

                <!-- Navigation -->
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-default btn-block">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>

        <!-- Timeline -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">History</h3>
            </div>
            <div class="card-body">
                <ul class="timeline">
                    <li>
                        <i class="fas fa-plus bg-primary"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fas fa-clock"></i> {{ diffForHumans($booking->created_at) }}</span>
                            <h3 class="timeline-header">Booking Created</h3>
                        </div>
                    </li>
                    
                    @if($booking->payment_proof)
                    <li>
                        <i class="fas fa-upload bg-info"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fas fa-clock"></i> {{ diffForHumans($booking->updated_at) }}</span>
                            <h3 class="timeline-header">Payment Proof Uploaded</h3>
                        </div>
                    </li>
                    @endif

                    @if($booking->status == 'paid' && $booking->payment->verified_at)
                    <li>
                        <i class="fas fa-check bg-success"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fas fa-clock"></i> {{ diffForHumans($booking->payment->verified_at) }}</span>
                            <h3 class="timeline-header">Payment Verified</h3>
                            <div class="timeline-body">
                                By {{ $booking->payment->verifier->name }}
                            </div>
                        </div>
                    </li>
                    @endif

                    @if($booking->status == 'cancelled')
                    <li>
                        <i class="fas fa-times bg-danger"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fas fa-clock"></i> {{ diffForHumans($booking->updated_at) }}</span>
                            <h3 class="timeline-header">Booking Cancelled</h3>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
        </div>

    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Booking Status</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Current Status: {!! $booking->status_badge !!}</label>
                    </div>
                    <div class="form-group">
                        <label>New Status</label>
                        <select name="status" class="form-control" required>
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="paid" {{ $booking->status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection