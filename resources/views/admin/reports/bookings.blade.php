@extends('layouts.admin')

@section('title', 'Bookings Report')
@section('page-title', 'Bookings Report')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.reports.index') }}">Reports</a></li>
<li class="breadcrumb-item active">Bookings</li>
@endsection

@section('content')

<!-- Filter Form -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Filter by Date Range</h3>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.bookings') }}">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control" 
                               value="{{ request('start_date', $startDate->format('Y-m-d')) }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control" 
                               value="{{ request('end_date', $endDate->format('Y-m-d')) }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-filter"></i> Apply Filter
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Booking Statistics -->
<div class="row">
    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fas fa-ticket-alt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Bookings</span>
                <span class="info-box-number">{{ $totalBookings }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Paid Bookings</span>
                <span class="info-box-number">{{ $paidBookings }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Pending</span>
                <span class="info-box-number">{{ $pendingBookings }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-danger"><i class="fas fa-times"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Cancelled</span>
                <span class="info-box-number">{{ $cancelledBookings }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row">
    <!-- Status Distribution -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Bookings by Status</h3>
            </div>
            <div class="card-body">
                <canvas id="statusChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Daily Bookings -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daily Bookings Trend</h3>
            </div>
            <div class="card-body">
                <canvas id="dailyBookingsChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Daily Bookings Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daily Bookings Breakdown</h3>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Total Bookings</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dailyBookings as $booking)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($booking->date)->format('d F Y') }}</td>
                    <td>{{ $booking->count }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="text-center">No bookings data for this period</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
// Status Pie Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: @json($bookingsByStatus->pluck('status')),
        datasets: [{
            data: @json($bookingsByStatus->pluck('count')),
            backgroundColor: [
                'rgba(255, 193, 7, 0.8)',
                'rgba(23, 162, 184, 0.8)',
                'rgba(40, 167, 69, 0.8)',
                'rgba(220, 53, 69, 0.8)'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// Daily Bookings Line Chart
const dailyCtx = document.getElementById('dailyBookingsChart').getContext('2d');
new Chart(dailyCtx, {
    type: 'line',
    data: {
        labels: @json($dailyBookings->pluck('date')),
        datasets: [{
            label: 'Daily Bookings',
            data: @json($dailyBookings->pluck('count')),
            borderColor: 'rgb(23, 162, 184)',
            backgroundColor: 'rgba(23, 162, 184, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@endpush