@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')

<div class="container py-5" style="margin-top: 80px;">
    <div class="row">
        
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 100px; z-index: 1;">
                <div class="list-group list-group-flush rounded-3 overflow-hidden">
                    <a href="{{ route('user.dashboard') }}" class="list-group-item list-group-item-action py-3 border-0">
                        <i class="fas fa-tachometer-alt me-2 text-muted"></i> Dashboard
                    </a>
                    <a href="{{ route('user.bookings.index') }}" class="list-group-item list-group-item-action py-3 border-0 fw-bold text-success" style="background-color: #e8f5e9; border-left: 4px solid #2c5f2d;">
                        <i class="fas fa-ticket-alt me-2"></i> My Bookings
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-3 border-0 disabled">
                        <i class="fas fa-user me-2 text-muted"></i> Profile
                    </a>
                </div>
            </div>

            <div class="mt-4 d-grid">
                <a href="{{ route('trips.index') }}" class="btn btn-primary rounded-pill py-2 shadow-sm">
                    <i class="fas fa-plus me-2"></i> Book New Adventure
                </a>
            </div>
        </div>

        <div class="col-lg-9">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-dark mb-0">My Adventure Log</h3>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm text-center h-100 py-3" style="background: #f8f9fa;">
                        <div class="card-body p-2">
                            <h6 class="text-muted text-uppercase small fw-bold mb-1">Total</h6>
                            <h2 class="mb-0 text-dark fw-bold">{{ $bookings->total() }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm text-center h-100 py-3" style="background: #fff3cd;">
                        <div class="card-body p-2">
                            <h6 class="text-muted text-uppercase small fw-bold text-warning mb-1">Pending</h6>
                            <h2 class="mb-0 text-warning fw-bold">{{ $bookings->where('status', 'pending')->count() }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm text-center h-100 py-3" style="background: #cff4fc;">
                        <div class="card-body p-2">
                            <h6 class="text-muted text-uppercase small fw-bold text-info mb-1">Confirmed</h6>
                            <h2 class="mb-0 text-info fw-bold">{{ $bookings->where('status', 'confirmed')->count() }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm text-center h-100 py-3" style="background: #d1e7dd;">
                        <div class="card-body p-2">
                            <h6 class="text-muted text-uppercase small fw-bold text-success mb-1">Paid</h6>
                            <h2 class="mb-0 text-success fw-bold">{{ $bookings->where('status', 'paid')->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-list me-2 text-muted"></i> Recent Bookings</h5>
                </div>
                
                <div class="card-body p-0">
                    @if($bookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">ID</th>
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
                                        <span class="badge bg-light text-dark border font-monospace">#{{ $booking->booking_code }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div style="width: 50px; height: 50px; flex-shrink: 0; overflow: hidden; border-radius: 8px; margin-right: 15px; border: 1px solid #eee;">
                                                <img src="{{ $booking->trip->mountain->image ? (Str::startsWith($booking->trip->mountain->image, 'http') ? $booking->trip->mountain->image : asset('storage/'.$booking->trip->mountain->image)) : 'https://via.placeholder.com/100?text=M' }}" 
                                                     alt="{{ $booking->trip->mountain->name }}"
                                                     style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ Str::limit($booking->trip->title, 25) }}</div>
                                                <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i> {{ $booking->trip->mountain->name }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small fw-bold">{{ date('d M', strtotime($booking->trip->start_date)) }}</div>
                                        <small class="text-muted text-xs">{{ date('Y', strtotime($booking->trip->start_date)) }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border rounded-pill px-3">{{ $booking->quantity }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success small">{{ $booking->formatted_total_price }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = match($booking->status) {
                                                'pending' => 'bg-warning text-dark bg-opacity-25 border-warning',
                                                'confirmed' => 'bg-info text-dark bg-opacity-25 border-info',
                                                'paid' => 'bg-success text-success bg-opacity-10 border-success',
                                                'cancelled' => 'bg-danger text-danger bg-opacity-10 border-danger',
                                                default => 'bg-secondary text-secondary bg-opacity-10'
                                            };
                                        @endphp
                                        <span class="badge border {{ $statusClass }} rounded-pill text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                            {{ $booking->status }}
                                        </span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                Manage
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('user.bookings.show', $booking) }}">
                                                        <i class="fas fa-eye me-2 text-primary"></i> View Details
                                                    </a>
                                                </li>
                                                
                                                @if($booking->status == 'pending')
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('user.bookings.show', $booking) }}">
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
                                <i class="fas fa-map-marked-alt fa-2x text-muted opacity-50"></i>
                            </div>
                        </div>
                        <h5 class="fw-bold text-dark">No Bookings Yet</h5>
                        <p class="text-muted mb-4">Start your journey by booking your first mountain trip.</p>
                        <a href="{{ route('trips.index') }}" class="btn btn-success px-4 rounded-pill">
                            Explore Trips
                        </a>
                    </div>
                    @endif
                </div>
            </div>

        </div>
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