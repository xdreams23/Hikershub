@extends('layouts.admin')

@section('title', 'Add New Trip')
@section('page-title', 'Add New Trip')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.trips.index') }}">Trips</a></li>
<li class="breadcrumb-item active">Create</li>
@endsection

@section('content')

<form action="{{ route('admin.trips.store') }}" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-md-8">
            
            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Basic Information</h3>
                </div>
                <div class="card-body">
                    
                    <div class="form-group">
                        <label>Select Mountain *</label>
                        <select name="mountain_id" class="form-control @error('mountain_id') is-invalid @enderror" required>
                            <option value="">-- Select Mountain --</option>
                            @foreach($mountains as $mountain)
                            <option value="{{ $mountain->id }}" {{ old('mountain_id') == $mountain->id ? 'selected' : '' }}>
                                {{ $mountain->name }} ({{ $mountain->location }})
                            </option>
                            @endforeach
                        </select>
                        @error('mountain_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Trip Title *</label>
                        <input type="text" name="title" 
                               class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title') }}" 
                               placeholder="e.g., Open Trip Semeru 3D2N"
                               required>
                        @error('title')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Start Date *</label>
                                <input type="date" name="start_date" 
                                       class="form-control @error('start_date') is-invalid @enderror" 
                                       value="{{ old('start_date') }}" 
                                       required>
                                @error('start_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>End Date *</label>
                                <input type="date" name="end_date" 
                                       class="form-control @error('end_date') is-invalid @enderror" 
                                       value="{{ old('end_date') }}" 
                                       required>
                                @error('end_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Duration (Days) *</label>
                                <input type="number" name="duration_days" 
                                       class="form-control @error('duration_days') is-invalid @enderror" 
                                       value="{{ old('duration_days') }}" 
                                       min="1"
                                       required>
                                @error('duration_days')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Meeting Point *</label>
                        <input type="text" name="meeting_point" 
                               class="form-control @error('meeting_point') is-invalid @enderror" 
                               value="{{ old('meeting_point') }}" 
                               placeholder="e.g., Stasiun Malang"
                               required>
                        @error('meeting_point')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Price (Rp) *</label>
                                <input type="number" name="price" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       value="{{ old('price') }}" 
                                       min="0"
                                       required>
                                @error('price')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Min Participants *</label>
                                <input type="number" name="min_participants" 
                                       class="form-control @error('min_participants') is-invalid @enderror" 
                                       value="{{ old('min_participants', 1) }}" 
                                       min="1"
                                       required>
                                @error('min_participants')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Max Participants *</label>
                                <input type="number" name="max_participants" 
                                       class="form-control @error('max_participants') is-invalid @enderror" 
                                       value="{{ old('max_participants') }}" 
                                       min="1"
                                       required>
                                @error('max_participants')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Status *</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="full" {{ old('status') == 'full' ? 'selected' : '' }}>Full</option>
                            <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>

            <!-- Details -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Trip Details</h3>
                </div>
                <div class="card-body">
                    
                    <div class="form-group">
                        <label>Itinerary</label>
                        <textarea name="itinerary" 
                                  class="form-control @error('itinerary') is-invalid @enderror" 
                                  rows="5"
                                  placeholder="Day 1: ...&#10;Day 2: ...">{{ old('itinerary') }}</textarea>
                        @error('itinerary')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Include Items</label>
                        <textarea name="include_items" 
                                  class="form-control @error('include_items') is-invalid @enderror" 
                                  rows="4"
                                  placeholder="What's included in the package...">{{ old('include_items') }}</textarea>
                        @error('include_items')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Exclude Items</label>
                        <textarea name="exclude_items" 
                                  class="form-control @error('exclude_items') is-invalid @enderror" 
                                  rows="4"
                                  placeholder="What's NOT included...">{{ old('exclude_items') }}</textarea>
                        @error('exclude_items')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Terms & Conditions</label>
                        <textarea name="terms_conditions" 
                                  class="form-control @error('terms_conditions') is-invalid @enderror" 
                                  rows="4"
                                  placeholder="Terms and conditions for this trip...">{{ old('terms_conditions') }}</textarea>
                        @error('terms_conditions')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>

        </div>

        <div class="col-md-4">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Tips</h3>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Set realistic participant limits</li>
                        <li>Make sure dates are accurate</li>
                        <li>Include detailed itinerary</li>
                        <li>Be clear about what's included/excluded</li>
                        <li>State all terms and conditions</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Actions</h3>
                </div>
                <div class="card-body">
                    <button type="submit" class="btn btn-success btn-block">
                        <i class="fas fa-save"></i> Save Trip
                    </button>
                    <a href="{{ route('admin.trips.index') }}" class="btn btn-default btn-block">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection