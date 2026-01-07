@extends('layouts.user')

@section('title', 'My Bookings')
@section('page-title', 'My Adventure Log')

@section('page-actions')
<a href="{{ route('trips.index') }}" class="btn btn-primary">
    <i class="fas fa-plus me-2"></i> Book New Adventure
</a>
@endsection

@section('content')

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center h-100 py-3">
            <div class="card-body">
                <h6 class="text-muted text-uppercase small fw-bold">All Bookings</h6>
                <h2 class="mb-0 text-dark">{{ $bookings->total() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center h-100 py-3">
            <div class="card-body">
                <h6 class="text-muted text-uppercase small fw-bold text-warning">Pending</h6>
                <h2 class="mb-0 text-warning">{{ $bookings->where('status', 'pending')->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center h-100 py-3">
            <div class="card-body">
                <h6 class="text-muted text-uppercase small fw-bold text-info">Confirmed</h6>
                <h2 class="mb-0 text-info">{{ $bookings->where('status', 'confirmed')->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center h-100 py-3">
            <div class="card-body">
                <h6 class="text-muted text-uppercase small fw-bold text-success">Paid</h6>
                <h2 class="mb-0 text-success">{{ $bookings->where('status', 'paid')->count() }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 border-bottom-0">
        <h5 class="mb-0 fw-bold">Recent Bookings</h5>
    </div>
    
    <div class="card-body p-0">
        @if($bookings->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">Booking ID</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Adventure</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Date</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted text-center">Pax</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Total</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Status</th>
                        <th class="pe-4 py-3 text-uppercase small fw-bold text-muted text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                    <tr>
                        <td class="ps-4">
                            <span class="fw-bold text-dark">#{{ $booking->booking_code }}</span>
                            <br>
                            <small class="text-muted">{{ formatDate($booking->created_at, 'd M Y') }}</small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $booking->trip->mountain->image ? asset('storage/'.$booking->trip->mountain->image) : 'https://via.placeholder.com/40' }}" 
                                     class="rounded-3 me-3" width="40" height="40" style="object-fit: cover;">
                                <div>
                                    <div class="fw-bold text-dark">{{ Str::limit($booking->trip->title, 30) }}</div>
                                    <small class="text-muted">{{ $booking->trip->mountain->name }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="text-dark">{{ formatDate($booking->trip->start_date, 'd M') }}</span>
                            <small class="text-muted">- {{ formatDate($booking->trip->end_date, 'd M Y') }}</small>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border">{{ $booking->participants_count }}</span>
                        </td>
                        <td>
                            <span class="fw-bold text-success">{{ $booking->formatted_total_price }}</span>
                        </td>
                        <td>
                            {!! $booking->status_badge !!}
                        </td>
                        <td class="pe-4 text-end">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    Options
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('user.bookings.show', $booking) }}">
                                            <i class="fas fa-eye me-2 text-primary"></i> View Details
                                        </a>
                                    </li>
                                    
                                    @if($booking->status == 'pending')
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-credit-card me-2 text-success"></i> Pay Now
                                        </a>
                                    </li>
                                    @endif

                                    @if($booking->status == 'pending' || $booking->status == 'confirmed')
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="#" onclick="confirmCancel('{{ $booking->id }}')">
                                            <i class="fas fa-times me-2"></i> Cancel Booking
                                        </a>
                                        <form id="cancel-form-{{ $booking->id }}" 
                                              action="{{ route('user.bookings.cancel', $booking) }}" 
                                              method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex justify-content-center">
                {{ $bookings->links() }}
            </div>
        </div>

        @else
        <div class="text-center py-5">
            <div class="mb-3">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                    <i class="fas fa-ticket-alt fa-2x text-muted opacity-50"></i>
                </div>
            </div>
            <h5 class="fw-bold text-dark">No Bookings Yet</h5>
            <p class="text-muted mb-4">You haven't booked any trips yet. Your next adventure awaits!</p>
            <a href="{{ route('trips.index') }}" class="btn btn-primary px-4 rounded-pill">
                Explore Trips
            </a>
        </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
function confirmCancel(bookingId) {
    if (confirm('Are you sure you want to cancel this booking? This action cannot be undone.')) {
        document.getElementById('cancel-form-' + bookingId).submit();
    }
}
</script>
@endpush