@extends('layouts.admin')

@section('title', 'Manage Bookings')
@section('page-title', 'Bookings Management')

@section('breadcrumb')
<li class="breadcrumb-item active">Bookings</li>
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Bookings</h3>
    </div>
    <div class="card-body">
        
        <!-- Search & Filter -->
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search booking code or user..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="trip_id" class="form-control">
                        <option value="">All Trips</option>
                        @foreach($trips as $t)
                        <option value="{{ $t->id }}" {{ request('trip_id') == $t->id ? 'selected' : '' }}>
                            {{ Str::limit($t->title, 40) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </div>
        </form>

        <!-- Statistics Cards -->
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $bookings->where('status', 'pending')->count() }}</h3>
                        <p>Pending</p>
                    </div>
                    <div class="icon"><i class="fas fa-clock"></i></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $bookings->where('status', 'confirmed')->count() }}</h3>
                        <p>Confirmed</p>
                    </div>
                    <div class="icon"><i class="fas fa-check"></i></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $bookings->where('status', 'paid')->count() }}</h3>
                        <p>Paid</p>
                    </div>
                    <div class="icon"><i class="fas fa-check-double"></i></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $bookings->where('status', 'cancelled')->count() }}</h3>
                        <p>Cancelled</p>
                    </div>
                    <div class="icon"><i class="fas fa-times"></i></div>
                </div>
            </div>
        </div>

        @if($bookings->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Booking Code</th>
                        <th>User</th>
                        <th>Trip</th>
                        <th>Date</th>
                        <th>Participants</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                    <tr>
                        <td>
                            <strong>{{ $booking->booking_code }}</strong><br>
                            <small class="text-muted">{{ formatDate($booking->created_at, 'd M Y') }}</small>
                        </td>
                        <td>
                            {{ $booking->user->name }}<br>
                            <small class="text-muted">{{ $booking->user->email }}</small>
                        </td>
                        <td>
                            {{ Str::limit($booking->trip->title, 30) }}<br>
                            <small class="text-muted">{{ $booking->trip->mountain->name }}</small>
                        </td>
                        <td>{{ formatDate($booking->trip->start_date, 'd M Y') }}</td>
                        <td>{{ $booking->participants_count }}</td>
                        <td><strong>{{ $booking->formatted_total_price }}</strong></td>
                        <td>{!! $booking->status_badge !!}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.bookings.show', $booking) }}" 
                                   class="btn btn-sm btn-info" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if($booking->status != 'cancelled')
                                <button type="button" 
                                        class="btn btn-sm btn-warning" 
                                        data-toggle="modal" 
                                        data-target="#statusModal{{ $booking->id }}"
                                        title="Update Status">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>

                    <!-- Status Modal -->
                    <div class="modal fade" id="statusModal{{ $booking->id }}">
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
                                            <label>Select Status</label>
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
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $bookings->links() }}
        </div>
        
        @else
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> No bookings found.
        </div>
        @endif
    </div>
</div>

@endsection