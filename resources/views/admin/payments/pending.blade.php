@extends('layouts.admin')

@section('title', 'Pending Payments')
@section('page-title', 'Pending Payment Verification')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">Payments</a></li>
<li class="breadcrumb-item active">Pending</li>
@endsection

@section('content')

<div class="card">
    <div class="card-header bg-warning">
        <h3 class="card-title">
            <i class="fas fa-clock"></i> Pending Payment Verification 
            <span class="badge badge-light">{{ $payments->total() }}</span>
        </h3>
    </div>
    <div class="card-body">
        
        @if($payments->count() > 0)
        
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> These payments are waiting for your verification. Please review the payment proof and approve or reject accordingly.
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Booking Code</th>
                        <th>User</th>
                        <th>Trip</th>
                        <th>Amount</th>
                        <th>Payment Date</th>
                        <th>Proof</th>
                        <th width="100">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td><strong>{{ $payment->booking->booking_code }}</strong></td>
                        <td>
                            {{ $payment->booking->user->name }}<br>
                            <small class="text-muted">{{ $payment->booking->user->email }}</small>
                        </td>
                        <td>{{ Str::limit($payment->booking->trip->title, 30) }}</td>
                        <td><strong class="text-success">{{ $payment->formatted_amount }}</strong></td>
                        <td>{{ formatDate($payment->payment_date, 'd M Y H:i') }}</td>
                        <td>
                            @if($payment->booking->payment_proof)
                            <a href="{{ asset('storage/'.$payment->booking->payment_proof) }}" 
                               target="_blank" 
                               class="btn btn-sm btn-info">
                                <i class="fas fa-image"></i> View
                            </a>
                            @else
                            <span class="badge badge-warning">No Proof</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.payments.show', $payment) }}" 
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-check"></i> Verify
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $payments->links() }}
        </div>
        
        @else
        <div class="alert alert-success text-center">
            <i class="fas fa-check-circle"></i> No pending payments! All caught up.
        </div>
        @endif
    </div>
</div>

@endsection