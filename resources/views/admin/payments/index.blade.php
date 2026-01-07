@extends('layouts.admin')

@section('title', 'Payments Management')
@section('page-title', 'Payments')

@section('breadcrumb')
<li class="breadcrumb-item active">Payments</li>
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">All Payments</h3>
            <a href="{{ route('admin.payments.pending') }}" class="btn btn-warning">
                <i class="fas fa-clock"></i> Pending Verification 
                <span class="badge badge-light">{{ \App\Models\Payment::where('status', 'pending')->count() }}</span>
            </a>
        </div>
    </div>
    <div class="card-body">
        
        <!-- Filter -->
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
        </form>

        @if($payments->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Booking Code</th>
                        <th>User</th>
                        <th>Trip</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Payment Date</th>
                        <th>Status</th>
                        <th width="100">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr class="{{ $payment->status == 'pending' ? 'table-warning' : '' }}">
                        <td><strong>{{ $payment->booking->booking_code }}</strong></td>
                        <td>{{ $payment->booking->user->name }}</td>
                        <td>{{ Str::limit($payment->booking->trip->title, 30) }}</td>
                        <td><strong>{{ $payment->formatted_amount }}</strong></td>
                        <td>{{ ucfirst($payment->payment_method) }}</td>
                        <td>{{ formatDate($payment->payment_date, 'd M Y') }}</td>
                        <td>{!! $payment->status_badge !!}</td>
                        <td>
                            <a href="{{ route('admin.payments.show', $payment) }}" 
                               class="btn btn-sm btn-primary" title="View & Verify">
                                <i class="fas fa-eye"></i>
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
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> No payments found.
        </div>
        @endif
    </div>
</div>

@endsection