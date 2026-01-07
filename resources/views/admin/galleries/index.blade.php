@extends('layouts.admin')

@section('title', 'Manage Gallery')
@section('page-title', 'Gallery Management')

@section('breadcrumb')
<li class="breadcrumb-item active">Gallery</li>
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Photo Gallery</h3>
            <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Upload New Images
            </a>
        </div>
    </div>
    <div class="card-body">
        
        <!-- Filter -->
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <select name="trip_id" class="form-control">
                        <option value="">All Trips</option>
                        @foreach($trips as $trip)
                        <option value="{{ $trip->id }}" {{ request('trip_id') == $trip->id ? 'selected' : '' }}>
                            {{ $trip->title }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
        </form>

        @if($galleries->count() > 0)
        <div class="row">
            @foreach($galleries as $gallery)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="{{ asset('storage/'.$gallery->image_path) }}" 
                         class="card-img-top" 
                         alt="{{ $gallery->caption }}"
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body p-2">
                        <p class="small mb-1"><strong>{{ $gallery->trip->title }}</strong></p>
                        @if($gallery->caption)
                        <p class="small text-muted mb-2">{{ Str::limit($gallery->caption, 50) }}</p>
                        @endif
                        <div class="btn-group btn-group-sm w-100">
                            <a href="{{ route('admin.galleries.edit', $gallery) }}" 
                               class="btn btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.galleries.destroy', $gallery) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $galleries->links() }}
        </div>
        
        @else
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> No images in gallery yet.
        </div>
        @endif
    </div>
</div>

@endsection