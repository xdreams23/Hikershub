@extends('layouts.user')

@section('title', 'Booking Details')
@section('page-title', 'Reservation Status')

@section('page-actions')
<a href="{{ route('user.bookings.index') }}" class="btn btn-outline-secondary">
    <i class="fas fa-arrow-left me-2"></i> Back to List
</a>
@endsection

@section('content')

<div class="row g-4">
    
    <div class="col-lg-8">
        
        <div class="card mb-4 border-0 shadow-sm" style="border-radius: 15px; overflow: hidden; border-left: 5px solid {{ $booking->status == 'pending' ? '#ffc107' : ($booking->status == 'confirmed' ? '#17a2b8' : ($booking->status == 'paid' ? '#28a745' : '#dc3545')) }}; background-color: {{ $booking->status == 'pending' ? '#fff3cd' : ($booking->status == 'confirmed' ? '#d1ecf1' : ($booking->status == 'paid' ? '#d4edda' : '#f8d7da')) }}">
            <div class="card-body d-flex align-items-center">
                <div class="me-3">
                    @if($booking->status == 'pending') <i class="fas fa-clock fa-3x opacity-50" style="color: #856404"></i>
                    @elseif($booking->status == 'confirmed') <i class="fas fa-spinner fa-3x opacity-50" style="color: #0c5460"></i>
                    @elseif($booking->status == 'paid') <i class="fas fa-check-circle fa-3x opacity-50" style="color: #155724"></i>
                    @else <i class="fas fa-times-circle fa-3x opacity-50" style="color: #721c24"></i>
                    @endif
                </div>
                <div>
                    <h5 class="fw-bold mb-1 text-uppercase" style="color: {{ $booking->status == 'pending' ? '#856404' : ($booking->status == 'confirmed' ? '#0c5460' : ($booking->status == 'paid' ? '#155724' : '#721c24')) }}">{{ ucfirst($booking->status) }}</h5>
                    <p class="mb-0 small opacity-75">
                        @if($booking->status == 'pending') Please complete payment to secure your slot.
                        @elseif($booking->status == 'confirmed') Payment proof uploaded. Waiting for admin verification.
                        @elseif($booking->status == 'paid') Your adventure is confirmed! See you at the meeting point.
                        @else This booking has been cancelled.
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Adventure Details</h5>
                
                <div style="display: flex; gap: 20px; align-items: center; background: #f8f9fa; padding: 20px; border-radius: 15px; margin-bottom: 30px;">
                    
                    <img src="{{ $booking->trip->mountain->image ? (Str::startsWith($booking->trip->mountain->image, 'http') ? $booking->trip->mountain->image : asset('storage/'.$booking->trip->mountain->image)) : 'https://via.placeholder.com/150' }}" 
                         alt="Mountain"
                         style="width: 100px; height: 100px; border-radius: 12px; object-fit: cover; flex-shrink: 0; box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);">
                    <div>
                        <h4 class="fw-bold mb-1">{{ $booking->trip->title }}</h4>
                        <p class="text-muted mb-2"><i class="fas fa-mountain me-1"></i> {{ $booking->trip->mountain->name }}</p>
                        <a href="{{ route('trips.show', $booking->trip) }}" class="text-decoration-none small fw-bold text-success">
                            View Trip Page <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold text-uppercase">Start Date</label>
                        <p class="fw-bold text-dark mb-0"><i class="far fa-calendar me-2"></i> {{ formatDate($booking->trip->start_date, 'd F Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold text-uppercase">End Date</label>
                        <p class="fw-bold text-dark mb-0"><i class="far fa-flag me-2"></i> {{ formatDate($booking->trip->end_date, 'd F Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold text-uppercase">Duration</label>
                        <p class="fw-bold text-dark mb-0"><i class="far fa-clock me-2"></i> {{ $booking->trip->duration_days }} Days</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold text-uppercase">Meeting Point</label>
                        <p class="fw-bold text-dark mb-0"><i class="fas fa-map-pin me-2"></i> {{ $booking->trip->meeting_point }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Payment Summary</h5>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Booking Code:</strong></p>
                        <div class="bg-light p-2 rounded fw-bold text-primary d-inline-block px-3">
                            #{{ $booking->booking_code }}
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-1"><strong>Booking Date:</strong></p>
                        <span class="text-muted">{{ formatDate($booking->created_at, 'd M Y, H:i') }}</span>
                    </div>
                </div>

                <div style="background: white; border: 1px solid #eee; border-radius: 15px; padding: 25px;">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Price per Person</span>
                        <span>{{ $booking->trip->formatted_price }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 border-bottom pb-3">
                        <span>Participants</span>
                        <span>x {{ $booking->participants_count }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-dark">Total Amount</span>
                        <span class="fw-bold text-success fs-4">{{ $booking->formatted_total_price }}</span>
                    </div>
                </div>

                @if($booking->notes)
                <div class="mt-4 p-3 bg-light rounded">
                    <small class="fw-bold text-muted d-block mb-1">Your Notes:</small>
                    <p class="mb-0 small fst-italic">"{{ $booking->notes }}"</p>
                </div>
                @endif
            </div>
        </div>

    </div>

    <div class="col-lg-4">
        
        @if($booking->status == 'pending' || $booking->status == 'confirmed')
        <div class="card border-0 shadow-sm mb-4">
            <div class="p-3 bg-success text-white rounded-top fw-bold">
                <i class="fas fa-file-invoice-dollar me-2"></i> Payment Action
            </div>
            <div class="p-4 bg-white rounded-bottom">
                @if($booking->status == 'pending')
                    <p class="small text-muted mb-3">Please transfer the total amount and upload your proof of payment below.</p>
                @else
                    <p class="small text-muted mb-3">You have uploaded a proof. You can update it if requested by admin.</p>
                @endif

                <form action="{{ route('user.bookings.upload-payment', $booking) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <input type="file" name="payment_proof" class="form-control form-control-sm" required>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">
                        <i class="fas fa-upload me-2"></i> {{ $booking->status == 'pending' ? 'Confirm Payment' : 'Update Proof' }}
                    </button>
                </form>
            </div>
        </div>
        @endif

        @if($booking->status == 'pending')
        <div class="card border-0 shadow-sm mb-4">
            <div class="p-3 border-bottom fw-bold text-dark">
                <i class="fas fa-university me-2"></i> Bank Transfer
            </div>
            <div class="p-4 bg-white rounded-bottom">
                <div class="mb-3">
                    <small class="text-muted d-block">Bank BCA</small>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">123 456 7890</span>
                        <button class="btn btn-link btn-sm p-0 text-decoration-none">Copy</button>
                    </div>
                    <small class="text-muted">a.n HikersHub Indonesia</small>
                </div>
                <hr>
                <div class="mb-0">
                    <small class="text-muted d-block">Bank Mandiri</small>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">987 654 3210</span>
                        <button class="btn btn-link btn-sm p-0 text-decoration-none">Copy</button>
                    </div>
                    <small class="text-muted">a.n HikersHub Indonesia</small>
                </div>
            </div>
        </div>
        @endif

        @if($booking->payment_proof)
        <div class="card border-0 shadow-sm mb-4">
            <div class="p-3 border-bottom fw-bold text-dark">
                <i class="fas fa-image me-2"></i> Uploaded Proof
            </div>
            <div class="p-3 text-center bg-white rounded-bottom">
                
                <img src="{{ Str::startsWith($booking->payment_proof, 'http') ? $booking->payment_proof : asset('storage/'.$booking->payment_proof) }}" 
                     class="img-fluid rounded border" 
                     alt="Proof"
                     onclick="window.open(this.src)"
                     style="cursor: pointer; max-height: 300px; object-fit: contain;">
                <div class="text-center mt-2">
                    <small class="text-muted">Click image to enlarge</small>
                </div>
            </div>
        </div>
        @endif

        @if($booking->status == 'paid')
            @if(!$booking->trip->reviews->where('user_id', auth()->id())->count())
            <div class="card border-0 shadow-sm mb-4">
                <div class="p-4 text-center bg-white rounded">
                    <h6 class="fw-bold mb-2">How was your trip?</h6>
                    <p class="small text-muted mb-3">Share your experience with other hikers.</p>
                    <a href="{{ route('user.reviews.create', $booking->trip) }}" class="btn btn-warning w-100 rounded-pill text-dark fw-bold">
                        <i class="fas fa-star me-2"></i> Write a Review
                    </a>
                </div>
            </div>
            @endif
        @endif

        @if($booking->status == 'pending' || $booking->status == 'confirmed')
        <div class="text-center mt-4">
            <form action="{{ route('user.bookings.cancel', $booking) }}" method="POST" onsubmit="return confirm('Are you sure? This cannot be undone.');">
                @csrf
                <button type="submit" class="btn btn-link text-danger text-decoration-none btn-sm">
                    <i class="fas fa-times me-1"></i> Cancel Booking
                </button>
            </form>
        </div>
        @endif

    </div>
</div>

@endsection