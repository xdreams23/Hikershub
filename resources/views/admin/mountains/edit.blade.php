@extends('layouts.admin')

@section('title', 'Edit Mountain')
@section('page-title', 'Edit Mountain')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.mountains.index') }}">Mountains</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Mountain: {{ $mountain->name }}</h3>
            </div>
            <form action="{{ route('admin.mountains.update', $mountain) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="card-body">
                    
                    <div class="form-group">
                        <label>Mountain Name *</label>
                        <input type="text" name="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $mountain->name) }}" 
                               required>
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Location *</label>
                        <input type="text" name="location" 
                               class="form-control @error('location') is-invalid @enderror" 
                               value="{{ old('location', $mountain->location) }}" 
                               required>
                        @error('location')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Altitude (MDPL) *</label>
                                <input type="number" name="altitude" 
                                       class="form-control @error('altitude') is-invalid @enderror" 
                                       value="{{ old('altitude', $mountain->altitude) }}" 
                                       required>
                                @error('altitude')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Difficulty Level *</label>
                                <select name="difficulty_level" 
                                        class="form-control @error('difficulty_level') is-invalid @enderror" 
                                        required>
                                    <option value="">Select Difficulty</option>
                                    <option value="easy" {{ old('difficulty_level', $mountain->difficulty_level) == 'easy' ? 'selected' : '' }}>Easy</option>
                                    <option value="medium" {{ old('difficulty_level', $mountain->difficulty_level) == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="hard" {{ old('difficulty_level', $mountain->difficulty_level) == 'hard' ? 'selected' : '' }}>Hard</option>
                                    <option value="extreme" {{ old('difficulty_level', $mountain->difficulty_level) == 'extreme' ? 'selected' : '' }}>Extreme</option>
                                </select>
                                @error('difficulty_level')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description *</label>
                        <textarea name="description" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  rows="4" 
                                  required>{{ old('description', $mountain->description) }}</textarea>
                        @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Facilities</label>
                        <textarea name="facilities" 
                                  class="form-control @error('facilities') is-invalid @enderror" 
                                  rows="3">{{ old('facilities', $mountain->facilities) }}</textarea>
                        @error('facilities')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Current Image -->
                    @if($mountain->image)
                    <div class="form-group">
                        <label>Current Image:</label><br>
                        <img src="{{ asset('storage/'.$mountain->image) }}" 
                             alt="{{ $mountain->name }}" 
                             class="img-thumbnail"
                             style="max-width: 300px;">
                    </div>
                    @endif

                    <div class="form-group">
                        <label>Update Image (Optional)</label>
                        <div class="custom-file">
                            <input type="file" name="image" 
                                   class="custom-file-input @error('image') is-invalid @enderror" 
                                   id="image"
                                   accept="image/*">
                            <label class="custom-file-label" for="image">Choose new file</label>
                        </div>
                        <small class="form-text text-muted">Leave empty to keep current image. Max 2MB (JPG, PNG, JPEG)</small>
                        @error('image')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- New Image Preview -->
                    <div class="form-group" id="image-preview" style="display: none;">
                        <label>New Image Preview:</label><br>
                        <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 300px;">
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Update Mountain
                    </button>
                    <a href="{{ route('admin.mountains.index') }}" class="btn btn-default">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Mountain Stats</h3>
            </div>
            <div class="card-body">
                <p><strong>Total Trips:</strong> {{ $mountain->trips->count() }}</p>
                <p><strong>Created:</strong> {{ formatDate($mountain->created_at) }}</p>
                <p><strong>Last Updated:</strong> {{ formatDate($mountain->updated_at) }}</p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<script>
$(document).ready(function () {
    bsCustomFileInput.init();
    
    // Image preview
    $('#image').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result);
                $('#image-preview').show();
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush