@extends('layouts.admin')

@section('title', 'Trips Report')
@section('page-title', 'Trips Report')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.reports.index') }}">Reports</a></li>
<li class="breadcrumb-item active">Trips</li>
@endsection

@section('content')

<!-- Most Popular Trips -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Most Popular Trips (Top 10)</h3>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Trip Title</th>
                    <th>Mountain</th>
                    <th>Total Bookings</th>
                    <th>Start Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($popularTrips as $index => $trip)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $trip->title }}</td>
                    <td>{{ $trip->mountain->name }}</td>
                    <td><span class="badge badge-success">{{ $trip->bookings_count }} bookings</span></td>
                    <td>{{ formatDate($trip->start_date, 'd M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No trips data available</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <!-- Trips by Mountain -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Trips by Mountain</h3>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Mountain</th>
                            <th>Total Trips</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tripsByMountain as $mountain)
                        <tr>
                            <td>{{ $mountain->name }}</td>
                            <td><span class="badge badge-info">{{ $mountain->trips_count }} trips</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Upcoming Trips -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Upcoming Trips</h3>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Trip</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($upcomingTrips as $trip)
                        <tr>
                            <td>{{ Str::limit($trip->title, 30) }}</td>
                            <td>{{ formatDate($trip->start_date, 'd M') }}</td>
                            <td>{!! $trip->status_badge !!}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">No upcoming trips</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection