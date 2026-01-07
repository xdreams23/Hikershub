@extends('layouts.user')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('styles')
<style>
    /* 1. STATS CARDS (Minimalis) */
    .card-stat {
        background: #fff;
        border: 1px solid #e3e6f0;
        border-radius: 10px;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    }
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    /* 2. TABLE STYLING (Yang diminta) */
    .table-card {
        background: #fff;
        border-radius: 10px;
        border: 1px solid #e3e6f0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        overflow: hidden;
    }
    
    .table-modern {
        width: 100%;
        margin-bottom: 0;
    }
    
    .table-modern thead th {
        background-color: #f8f9fc;
        color: #858796;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 15px 20px;
        border-bottom: 1px solid #e3e6f0;
        border-top: none;
    }
    
    .table-modern tbody td {
        padding: 15px 20px;
        vertical-align: middle;
        color: #5a5c69;
        border-bottom: 1px solid #f0f2f5;
        font-size: 0.9rem;
    }
    
    .table-modern tbody tr:hover {
        background-color: #fafbfc;
    }
    
    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }

    /* Badge Custom */
    .badge-soft {
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    .badge-soft-warning { background: #fff3cd; color: #856404; }
    .badge-soft-success { background: #d4edda; color: #155724; }
    .badge-soft-info { background: #d1ecf1; color: #0c5460; }
    .badge-soft-danger { background: #f8d7da; color: #721c24; }

    /* Action Button Sidebar */
    .btn-action-tile {
        display: block;
        background: #fff;
        border: 1px solid #e3e6f0;
        border-radius: 10px;
        padding: 15px;
        text-align: center;
        text-decoration: none;
        color: #5a5c69;
        transition: 0.2s;
    }
    .btn-action-tile:hover {
        border-color: var(--primary-dark);
        color: var(--primary-dark);
        transform: translateY(-2px);
    }
</style>
@endsection

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
        <div class="card-stat">
            <div>
                <div class="text-muted small fw-bold text-uppercase">Total Trips</div>
                <div class="fs-3 fw-bold text-dark">{{ $totalBookings }}</div>
            </div>
            <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                <i class="fas fa-suitcase"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-stat">
            <div>
                <div class="text-muted small fw-bold text-uppercase">Pending</div>
                <div class="fs-3 fw-bold text-dark">{{ $pendingBookings }}</div>
            </div>
            <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-stat">
            <div>
                <div class="text-muted small fw-bold text-uppercase">Paid</div>
                <div class="fs-3 fw-bold text-dark">{{ $paidBookings }}</div>
            </div>
            <div class="stat-icon bg-success bg-opacity-10 text-success">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-9">
        <div class="table-card mb-4">
            <div class="d-flex justify-content-between align-items-center px-4 py-3 border-bottom bg-white">
                <h6 class="m-0 fw-bold text-primary">Recent Booking History</h6>
                <a href="{{ route('user.bookings.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>Ref Code</th>
                            <th>Destination</th>
                            <th>Date</th>
                            <th>Pax</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings->take(5) as $booking)
                        <tr>
                            <td class="fw-bold">
                                #{{ $booking->booking_code }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $booking->trip->mountain->image ? asset('storage/'.$booking->trip->mountain->image) : 'https://via.placeholder.com/30' }}" 
                                         class="rounded me-2" width="30" height="30" style="object-fit: cover;">
                                    <span class="fw-semibold">{{ Str::limit($booking->trip->title, 25) }}</span>
                                </div>
                            </td>
                            <td>
                                {{ formatDate($booking->trip->start_date, 'd M') }}
                            </td>
                            <td>{{ $booking->participants_count }}</td>
                            <td class="fw-bold text-dark">{{ $booking->formatted_total_price }}</td>
                            <td>
                                @if($booking->status == 'pending')
                                    <span class="badge-soft badge-soft-warning">Pending</span>
                                @elseif($booking->status == 'confirmed')
                                    <span class="badge-soft badge-soft-info">Confirmed</span>
                                @elseif($booking->status == 'paid')
                                    <span class="badge-soft badge-soft-success">Paid</span>
                                @else
                                    <span class="badge-soft badge-soft-danger">Cancelled</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('user.bookings.show', $booking) }}" class="btn btn-sm btn-light border">
                                    Manage
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                No data available in table.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card p-3 border-0 shadow-sm mb-3">
            <div class="text-center mb-3">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
                    <span class="fw-bold fs-4 text-primary">{{ substr(auth()->user()->name, 0, 1) }}</span>
                </div>
                <h6 class="fw-bold mb-0">{{ auth()->user()->name }}</h6>
                <small class="text-muted">{{ auth()->user()->email }}</small>
            </div>
            <a href="{{ route('user.profile.edit') }}" class="btn btn-outline-primary btn-sm w-100 rounded-pill">Edit Profile</a>
        </div>

        <h6 class="text-uppercase text-muted fw-bold small mb-3 px-1">Quick Menu</h6>
        <div class="row g-2">
            <div class="col-6">
                <a href="{{ route('trips.index') }}" class="btn-action-tile">
                    <i class="fas fa-search mb-2 d-block fs-4 text-info"></i>
                    <small class="fw-bold">Browse</small>
                </a>
            </div>
            <div class="col-6">
                <a href="{{ route('user.bookings.index') }}" class="btn-action-tile">
                    <i class="fas fa-list mb-2 d-block fs-4 text-warning"></i>
                    <small class="fw-bold">My List</small>
                </a>
            </div>
            <div class="col-12">
                <a href="https://wa.me/6281234567890" target="_blank" class="btn-action-tile d-flex align-items-center justify-content-center gap-2">
                    <i class="fab fa-whatsapp fs-5 text-success"></i>
                    <span class="fw-bold">Chat Support</span>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection