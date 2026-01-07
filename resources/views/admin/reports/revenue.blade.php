@extends('layouts.admin')

@section('title', 'Revenue Report')
@section('page-title', 'Revenue Report')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.reports.index') }}">Reports</a></li>
<li class="breadcrumb-item active">Revenue</li>
@endsection

@section('content')

<!-- Filter Form -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Filter by Date Range</h3>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.revenue') }}">
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

<!-- Total Revenue -->
<div class="row">
    <div class="col-md-12">
        <div class="info-box bg-success">
            <span class="info-box-icon"><i class="fas fa-dollar-sign"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Revenue</span>
                <span class="info-box-number">{{ formatRupiah($totalRevenue) }}</span>
                <span class="progress-description">
                    {{ formatDate($startDate) }} - {{ formatDate($endDate) }}
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Revenue by Payment Method -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Revenue by Payment Method</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Payment Method</th>
                            <th>Transactions</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($revenueByMethod as $method)
                        <tr>
                            <td>{{ ucfirst($method->payment_method) }}</td>
                            <td>{{ $method->count }}</td>
                            <td>{{ formatRupiah($method->total) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">No data available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Daily Revenue Chart -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daily Revenue Trend</h3>
            </div>
            <div class="card-body">
                <canvas id="dailyRevenueChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Daily Revenue Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daily Revenue Breakdown</h3>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dailyRevenue as $revenue)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($revenue->date)->format('d F Y') }}</td>
                    <td>{{ formatRupiah($revenue->total) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="text-center">No revenue data for this period</td>
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
// Daily Revenue Chart
const ctx = document.getElementById('dailyRevenueChart').getContext('2d');
const dailyRevenueChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($dailyRevenue->pluck('date')),
        datasets: [{
            label: 'Daily Revenue (Rp)',
            data: @json($dailyRevenue->pluck('total')),
            borderColor: 'rgb(40, 167, 69)',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@endpush