@extends('layouts.admin')

@section('title', 'Reports')
@section('page-title', 'Reports & Analytics')

@section('breadcrumb')
<li class="breadcrumb-item active">Reports</li>
@endsection

@section('content')

<div class="row">
    
    <!-- Revenue Report -->
    <div class="col-md-6 col-lg-3">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>Revenue</h3>
                <p>Financial Reports</p>
            </div>
            <div class="icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <a href="{{ route('admin.reports.revenue') }}" class="small-box-footer">
                View Report <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Bookings Report -->
    <div class="col-md-6 col-lg-3">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>Bookings</h3>
                <p>Booking Statistics</p>
            </div>
            <div class="icon">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <a href="{{ route('admin.reports.bookings') }}" class="small-box-footer">
                View Report <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Trips Report -->
    <div class="col-md-6 col-lg-3">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>Trips</h3>
                <p>Trip Analytics</p>
            </div>
            <div class="icon">
                <i class="fas fa-hiking"></i>
            </div>
            <a href="{{ route('admin.reports.trips') }}" class="small-box-footer">
                View Report <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Mountains Report -->
    <div class="col-md-6 col-lg-3">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>Mountains</h3>
                <p>Mountain Statistics</p>
            </div>
            <div class="icon">
                <i class="fas fa-mountain"></i>
            </div>
            <a href="{{ route('admin.reports.mountains') }}" class="small-box-footer">
                View Report <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

</div>

<!-- Quick Overview -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Quick Overview</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <h4>{{ \App\Models\Booking::count() }}</h4>
                        <p class="text-muted">Total Bookings</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <h4>{{ formatRupiah(\App\Models\Payment::where('status', 'success')->sum('amount')) }}</h4>
                        <p class="text-muted">Total Revenue</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <h4>{{ \App\Models\Trip::count() }}</h4>
                        <p class="text-muted">Total Trips</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <h4>{{ \App\Models\User::where('role', 'user')->count() }}</h4>
                        <p class="text-muted">Total Users</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Available Reports</h3>
            </div>
            <div class="card-body">
                <ul>
                    <li><strong>Revenue Report:</strong> View total revenue, daily revenue breakdown, and payment method statistics</li>
                    <li><strong>Bookings Report:</strong> Analyze booking trends, status distribution, and daily bookings</li>
                    <li><strong>Trips Report:</strong> See most popular trips, trips by mountain, and upcoming schedules</li>
                    <li><strong>Mountains Report:</strong> View mountain popularity and difficulty distribution</li>
                    <li><strong>Participants Report:</strong> Track total participants and trip participation statistics</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection