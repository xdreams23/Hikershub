@extends('layouts.admin')

@section('title', 'Manage Trips')
@section('page-title', 'Trips')

@section('breadcrumb')
<li class="breadcrumb-item active">Trips</li>
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Trips List</h3>
            <a href="{{ route('admin.trips.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Trip
            </a>
        </div>
    </div>
    <div class="card-body">
        
        <!-- Search & Filter -->
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search trips..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="full" {{ request('status') == 'full' ? 'selected' : '' }}>Full</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="mountain_id" class="form-control">
                        <option value="">All Mountains</option>
                        @foreach($mountains as $m)
                        <option value="{{ $m->id }}" {{ request('mountain_id') == $m->id ? 'selected' : '' }}>
                            {{ $m->name }}
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

        @if($trips->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Trip Title</th>
                        <th>Mountain</th>
                        <th>Date</th>
                        <th>Duration</th>
                        <th>Price</th>
                        <th>Participants</th>
                        <th>Status</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trips as $trip)
                    <tr>
                        <td><strong>{{ $trip->title }}</strong></td>
                        <td>{{ $trip->mountain->name }}</td>
                        <td>{{ formatDate($trip->start_date, 'd M Y') }}</td>
                        <td>{{ $trip->duration_days }} days</td>
                        <td>{{ $trip->formatted_price }}</td>
                        <td>
                            <span class="badge badge-info">
                                {{ $trip->current_participants }}/{{ $trip->max_participants }}
                            </span>
                        </td>
                        <td>{!! $trip->status_badge !!}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.trips.show', $trip) }}" 
                                   class="btn btn-sm btn-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.trips.edit', $trip) }}" 
                                   class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.trips.destroy', $trip) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $trips->links() }}
        </div>
        
        @else
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> No trips found.
        </div>
        @endif
    </div>
</div>

@endsection