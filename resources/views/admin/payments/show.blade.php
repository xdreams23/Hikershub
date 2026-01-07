@extends('layouts.admin')

@section('title', 'Payment Verification')
@section('page-title', 'Payment Verification')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">Payments</a></li>
<li class="breadcrumb-item active">Verify</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-7">
        
        <!-- Payment Proof -->
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">Payment Proof</h3>
            </div>
            <div class="card-body text-center">
                @if($payment->booking->payment_proof)
                <img src="{{ asset('storage/'.$payment->booking->payment_proof) }}" 
                     class="img-fluid"
                     alt="Payment Proof"
                     style="max-height: 600px;">
                <div class="mt-3">
                    <a href="{{ asset('storage/'.$payment->booking->payment_proof) }}" 
                       target="_blank" 
                       class="btn btn-primary">
                        <i class="fas fa-external-link-alt"></i> Open in New Tab
                    </a>
                </div>
                @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> No payment proof uploaded yet.
                </div>
                @endif
            </div>
        </div>

    </div>

    <div class="col-md-5">
        
        <!-- Payment Details -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Payment Details</h3>
            </div>
            <div class="card-body">
                <p><strong>Booking Code:</strong> 
                    <a href="{{ route('admin.bookings.show', $payment->booking) }}">{{ $payment->booking->booking_code }}</a>
                </p>
                <p><strong>Amount:</strong> <span class="text-success h4">{{ $payment->formatted_amount }}</span></p>
                <p><strong>Payment Method:</strong> {{ ucfirst($payment->payment_method) }}</p>
                <p><strong>Payment Date:</strong> {{ formatDate($payment->payment_date) }}</p>
                <p><strong>Status:</strong> {!! $payment->status_badge !!}</p>
                
                @if($payment->verified_at)
                <hr>
                <p><strong>Verified At:</strong> {{ formatDate($payment->verified_at) }}</p>
                <p><strong>Verified By:</strong> {{ $payment->verifier->name }}</p>
                @endif
            </div>
        </div>

        <!-- User Info -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Customer Information</h3>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $payment->booking->user->name }}</p>
                <p><strong>Email:</strong> {{ $payment->booking->user->email }}</p>
                <p><strong>Phone:</strong> {{ $payment->booking->user->phone ?? 'N/A' }}</p>
                <a href="{{ route('admin.users.show', $payment->booking->user) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-user"></i> View Profile
                </a>
            </div>
        </div>

        <!-- Trip Info -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Trip Information</h3>
            </div>
            <div class="card-body">
                <h6>{{ $payment->booking->trip->title }}</h6>
                <p class="text-muted mb-2">{{ $payment->booking->trip->mountain->name }}</p>
                <p><strong>Date:</strong> {{ formatDate($payment->booking->trip->start_date, 'd M Y') }}</p>
                <p><strong>Participants:</strong> {{ $payment->booking->participants_count }} person(s)</p>
                <a href="{{ route('admin.trips.show', $payment->booking->trip) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-hiking"></i> View Trip
                </a>
            </div>
        </div>

        <!-- Verification Action -->
        @if($payment->status == 'pending')
        <div class="card">
            <div class="card-header bg-warning">
                <h3 class="card-title">Verify Payment</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.payments.verify', $payment) }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label>Verification Decision *</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="">-- Select --</option>
                            <option value="success">✓ Approve Payment</option>
                            <option value="failed">✗ Reject Payment</option>
                        </select>
                        @error('status')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Notes (Optional)</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Add notes if needed..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-success btn-block">
                        <i class="fas fa-check"></i> Submit Verification
                    </button>
                </form>
            </div>
        </div>
        @else
        <div class="card">
            <div class="card-body text-center">
                @if($payment->status == 'success')
                <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                <h5 class="text-success">Payment Approved</h5>
                @else
                <i class="fas fa-times-circle text-danger fa-3x mb-3"></i>
                <h5 class="text-danger">Payment Rejected</h5>
                @endif
                <p class="text-muted">This payment has already been verified.</p>
            </div>
        </div>
        @endif

        <!-- Navigation -->
        <a href="{{ route('admin.payments.index') }}" class="btn btn-default btn-block">
            <i class="fas fa-arrow-left"></i> Back to Payments List
        </a>

    </div>
</div>

@endsection