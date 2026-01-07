@extends('layouts.admin')

@section('title', 'Manage Reviews')
@section('page-title', 'Reviews Management')

@section('breadcrumb')
<li class="breadcrumb-item active">Reviews</li>
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Reviews</h3>
    </div>
    <div class="card-body">
        
        <!-- Filter -->
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search by user name..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="rating" class="form-control">
                        <option value="">All Ratings</option>
                        <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                        <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                        <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                        <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                        <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Star</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
        </form>

        @if($reviews->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Trip</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Date</th>
                        <th width="100">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                    <tr>
                        <td>{{ $review->user->name }}</td>
                        <td>{{ Str::limit($review->trip->title, 30) }}</td>
                        <td>{!! generateStars($review->rating) !!}</td>
                        <td>{{ Str::limit($review->comment, 60) }}</td>
                        <td>{{ formatDate($review->created_at, 'd M Y') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.reviews.show', $review) }}" 
                                   class="btn btn-sm btn-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.reviews.destroy', $review) }}" 
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
            {{ $reviews->links() }}
        </div>
        
        @else
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> No reviews found.
        </div>
        @endif
    </div>
</div>

@endsection