@extends('layouts.admin')

@section('title', 'Mountains Report')
@section('page-title', 'Mountains Report')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.reports.index') }}">Reports</a></li>
<li class="breadcrumb-item active">Mountains</li>
@endsection

@section('content')

<div class="row">
    <!-- Popular Mountains -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Most Popular Mountains</h3>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Mountain Name</th>
                            <th>Location</th>
                            <th>Difficulty</th>
                            <th>Total Trips</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($popularMountains as $index => $mountain)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $mountain->name }}</td>
                            <td>{{ $mountain->location }}</td>
                            <td>{!! $mountain->difficulty_badge !!}</td>
                            <td><span class="badge badge-success">{{ $mountain->trips_count }} trips</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Difficulty Distribution -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Mountains by Difficulty</h3>
            </div>
            <div class="card-body">
                <canvas id="difficultyChart" height="200"></canvas>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-sm">
                    @foreach($mountainsByDifficulty as $difficulty)
                    <tr>
                        <td>{{ ucfirst($difficulty->difficulty_level) }}</td>
                        <td><span class="badge badge-{{ getDifficultyColor($difficulty->difficulty_level) }}">{{ $difficulty->count }}</span></td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
const ctx = document.getElementById('difficultyChart').getContext('2d');
new Chart(ctx, {
    type: 'pie',
    data: {
        labels: @json($mountainsByDifficulty->pluck('difficulty_level')),
        datasets: [{
            data: @json($mountainsByDifficulty->pluck('count')),
            backgroundColor: [
                'rgba(40, 167, 69, 0.8)',
                'rgba(23, 162, 184, 0.8)',
                'rgba(255, 193, 7, 0.8)',
                'rgba(220, 53, 69, 0.8)'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>
@endpush