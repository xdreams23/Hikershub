@extends('layouts.user')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Dashboard</h4>
        <span class="text-muted small">Overview of your activity</span>
    </div>
    <span class="badge bg-white text-dark border p-2">
        <i class="far fa-calendar me-1"></i> {{ now()->format('d M Y') }}
    </span>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-bold text-uppercase mb-1">Total Trips</div>
                    <div class="fs-3 fw-bold text-dark">{{ $totalBookings }}</div>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary" style="width: 50px; height: 50px;">
                    <i class="fas fa-suitcase fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-bold text-uppercase mb-1">Pending</div>
                    <div class="fs-3 fw-bold text-dark">{{ $pendingBookings }}</div>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning" style="width: 50px; height: 50px;">
                    <i class="fas fa-clock fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-bold text-uppercase mb-1">Paid</div>
                    <div class="fs-3 fw-bold text-dark">{{ $paidBookings }}</div>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success" style="width: 50px; height: 50px;">
                    <i class="fas fa-check-circle fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-9 mb-4">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-primary">Recent Booking History</h6>
                <a href="{{ route('user.bookings.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">View All</a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4 py-3 border-0">Ref Code</th>
                            <th class="py-3 border-0">Destination</th>
                            <th class="py-3 border-0">Date</th>
                            <th class="py-3 border-0">Pax</th>
                            <th class="py-3 border-0">Total</th>
                            <th class="py-3 border-0">Status</th>
                            <th class="pe-4 py-3 border-0 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($bookings->take(5) as $booking)
                        <tr>
                            <td class="ps-4 fw-bold text-dark">
                                #{{ $booking->booking_code }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div style="width: 35px; height: 35px; border-radius: 8px; overflow: hidden; flex-shrink: 0; border: 1px solid #eee; margin-right: 10px;">
                                        <img src="{{ $booking->trip->mountain->image ? (Str::startsWith($booking->trip->mountain->image, 'http') ? $booking->trip->mountain->image : asset('storage/'.$booking->trip->mountain->image)) : 'https://via.placeholder.com/35' }}" 
                                             alt="Img"
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <span class="fw-semibold text-dark small">{{ Str::limit($booking->trip->title, 20) }}</span>
                                </div>
                            </td>
                            <td class="small text-muted">
                                {{ formatDate($booking->trip->start_date, 'd M') }}
                            </td>
                            <td class="small text-center">{{ $booking->participants_count }}</td>
                            <td class="fw-bold text-success small">{{ $booking->formatted_total_price }}</td>
                            <td>
                                @if($booking->status == 'pending')
                                    <span class="badge bg-warning bg-opacity-25 text-warning border border-warning rounded-pill px-2">Pending</span>
                                @elseif($booking->status == 'confirmed')
                                    <span class="badge bg-info bg-opacity-25 text-info border border-info rounded-pill px-2">Confirmed</span>
                                @elseif($booking->status == 'paid')
                                    <span class="badge bg-success bg-opacity-25 text-success border border-success rounded-pill px-2">Paid</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-25 text-danger border border-danger rounded-pill px-2">Cancelled</span>
                                @endif
                            </td>
                            <td class="pe-4 text-end">
                                <a href="{{ route('user.bookings.show', $booking) }}" class="btn btn-sm btn-light border rounded-pill px-3">
                                    Manage
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-box-open fa-2x mb-3 opacity-25"></i>
                                <p class="mb-0 small">No recent bookings found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body text-center p-4">
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center bg-primary text-white rounded-circle fs-3 fw-bold shadow-sm" style="width: 70px; height: 70px;">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <h6 class="fw-bold text-dark mb-0">{{ auth()->user()->name }}</h6>
                <small class="text-muted d-block mb-3">{{ auth()->user()->email }}</small>
                <a href="#" class="btn btn-outline-primary btn-sm rounded-pill w-100">
                    <i class="fas fa-user-edit me-1"></i> Edit Profile
                </a>
            </div>
        </div>

        <h6 class="text-uppercase text-muted fw-bold small mb-3 px-1">Quick Menu</h6>
        <div class="row g-2">
            <div class="col-6">
                <a href="{{ route('trips.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm text-center p-3 h-100 hover-scale" style="background-color: #fff;">
                        <i class="fas fa-search fs-3 text-info mb-2"></i>
                        <div class="small fw-bold text-dark">Browse</div>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <a href="{{ route('user.bookings.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm text-center p-3 h-100 hover-scale" style="background-color: #fff;">
                        <i class="fas fa-list fs-3 text-warning mb-2"></i>
                        <div class="small fw-bold text-dark">My List</div>
                    </div>
                </a>
            </div>
            <div class="col-12">
                <a href="https://wa.me/6281234567890" target="_blank" class="text-decoration-none">
                    <div class="card border-0 shadow-sm text-center p-3 hover-scale" style="background-color: #d1e7dd;">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <i class="fab fa-whatsapp fs-4 text-success"></i>
                            <span class="fw-bold text-success">Chat Support</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection