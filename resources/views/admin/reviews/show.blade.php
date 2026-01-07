@extends('layouts.admin')

@section('title', 'Review Details')
@section('page-title', 'Review Details')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.reviews.index') }}">Reviews</a></li>
<li class="breadcrumb-item active">Details</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Review Information</h3>
            </div>
            <div class="card-body">
                
                <div class="mb-4">
                    <h5>Rating</h5>
                    <div class="h3">{!! generateStars($review->rating) !!} ({{ $review->rating }}/5)</div>
                </div>

                <div class="mb-4">
                    <h5>Comment</h5>
                    <p class="lead">{{ $review->comment }}</p>
                </div>

                <div class="mb-4">
                    <h5>Trip</h5>
                    <p><strong>{{ $review->trip->title }}</strong></p>
                    <p class="text-muted">{{ $review->trip->mountain->name }} - {{ formatDate($review->trip->start_date, 'd M Y') }}</p>
                    <a href="{{ route('admin.trips.show', $review->trip) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-hiking"></i> View Trip
                    </a>
                </div>

                <div class="mb-4">
                    <h5>Reviewer</h5>
                    <p><strong>{{ $review->user->name }}</strong></p>
                    <p class="text-muted">{{ $review->user->email }}</p>
                    <a href="{{ route('admin.users.show', $review->user) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-user"></i> View User Profile
                    </a>
                </div>

                <div>
                    <p class="text-muted">
                        <i class="fas fa-clock"></i> Posted {{ diffForHumans($review->created_at) }}
                    </p>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-danger">
                <h3 class="card-title">Actions</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.reviews.destroy', $review) }}" 
                      method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this review?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block">
                        <i class="fas fa-trash"></i> Delete Review
                    </button>
                </form>
                <hr>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-default btn-block">
                    <i class="fas fa-arrow-left"></i> Back to Reviews
                </a>
            </div>
        </div>
    </div>
</div>

@endsection