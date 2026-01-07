@extends('layouts.admin')

@section('title', 'Edit Gallery Image')
@section('page-title', 'Edit Gallery Image')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.galleries.index') }}">Gallery</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Image Details</h3>
            </div>
            <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="card-body">
                    
                    <div class="form-group">
                        <label>Select Trip *</label>
                        <select name="trip_id" 
                                class="form-control @error('trip_id') is-invalid @enderror" 
                                required>
                            <option value="">-- Select Trip --</option>
                            @foreach($trips as $trip)
                            <option value="{{ $trip->id }}" 
                                {{ old('trip_id', $gallery->trip_id) == $trip->id ? 'selected' : '' }}>
                                {{ $trip->title }} - {{ formatDate($trip->start_date, 'd M Y') }}
                            </option>
                            @endforeach
                        </select>
                        @error('trip_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Caption</label>
                        <input type="text" name="caption" 
                               class="form-control @error('caption') is-invalid @enderror" 
                               value="{{ old('caption', $gallery->caption) }}" 
                               placeholder="e.g., Summit celebration at sunrise">
                        @error('caption')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Current Image -->
                    <div class="form-group">
                        <label>Current Image:</label><br>
                        <img src="{{ asset('storage/'.$gallery->image_path) }}" 
                             alt="{{ $gallery->caption }}" 
                             class="img-thumbnail"
                             style="max-width: 400px;">
                    </div>

                    <div class="form-group">
                        <label>Replace Image (Optional)</label>
                        <div class="custom-file">
                            <input type="file" 
                                   name="image" 
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
                        <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 400px;">
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Update Image
                    </button>
                    <a href="{{ route('admin.galleries.index') }}" class="btn btn-default">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Image Info</h3>
            </div>
            <div class="card-body">
                <p><strong>Trip:</strong> {{ $gallery->trip->title }}</p>
                <p><strong>Uploaded:</strong> {{ formatDate($gallery->created_at) }}</p>
                <p><strong>Last Updated:</strong> {{ formatDate($gallery->updated_at) }}</p>
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