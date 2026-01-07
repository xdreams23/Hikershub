@extends('layouts.admin')

@section('title', 'Manage Mountains')
@section('page-title', 'Mountains')

@section('breadcrumb')
<li class="breadcrumb-item active">Mountains</li>
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Mountains List</h3>
            <a href="{{ route('admin.mountains.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Mountain
            </a>
        </div>
    </div>
    <div class="card-body">
        
        <!-- Search & Filter -->
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search mountains..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="difficulty" class="form-control">
                        <option value="">All Difficulties</option>
                        <option value="easy" {{ request('difficulty') == 'easy' ? 'selected' : '' }}>Easy</option>
                        <option value="medium" {{ request('difficulty') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="hard" {{ request('difficulty') == 'hard' ? 'selected' : '' }}>Hard</option>
                        <option value="extreme" {{ request('difficulty') == 'extreme' ? 'selected' : '' }}>Extreme</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </div>
        </form>

        @if($mountains->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="80">Image</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Altitude</th>
                        <th>Difficulty</th>
                        <th>Trips</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mountains as $mountain)
                    <tr>
                        <td>
                            @if($mountain->image)
                            <img src="{{ asset('storage/'.$mountain->image) }}" 
                                 alt="{{ $mountain->name }}" 
                                 class="img-thumbnail"
                                 style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                            <div class="bg-secondary text-white text-center" style="width: 60px; height: 60px; line-height: 60px;">
                                <i class="fas fa-mountain"></i>
                            </div>
                            @endif
                        </td>
                        <td><strong>{{ $mountain->name }}</strong></td>
                        <td>{{ $mountain->location }}</td>
                        <td>{{ $mountain->formatted_altitude }}</td>
                        <td>{!! $mountain->difficulty_badge !!}</td>
                        <td>
                            <span class="badge badge-info">{{ $mountain->trips->count() }} trips</span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.mountains.show', $mountain) }}" 
                                   class="btn btn-sm btn-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.mountains.edit', $mountain) }}" 
                                   class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.mountains.destroy', $mountain) }}" 
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
            {{ $mountains->links() }}
        </div>
        
        @else
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> No mountains found.
        </div>
        @endif
    </div>
</div>

@endsection