@extends('layouts.admin')

@section('title', 'Upload Gallery Images')
@section('page-title', 'Upload Gallery Images')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.galleries.index') }}">Gallery</a></li>
<li class="breadcrumb-item active">Upload</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Upload Images</h3>
            </div>
            <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="card-body">
                    
                    <div class="form-group">
                        <label>Select Trip *</label>
                        <select name="trip_id" 
                                class="form-control @error('trip_id') is-invalid @enderror" 
                                required>
                            <option value="">-- Select Trip --</option>
                            @foreach($trips as $trip)
                            <option value="{{ $trip->id }}" {{ old('trip_id') == $trip->id ? 'selected' : '' }}>
                                {{ $trip->title }} - {{ formatDate($trip->start_date, 'd M Y') }}
                            </option>
                            @endforeach
                        </select>
                        @error('trip_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Upload Images * (Multiple Selection Allowed)</label>
                        <div class="custom-file">
                            <input type="file" 
                                   name="images[]" 
                                   class="custom-file-input @error('images') is-invalid @enderror" 
                                   id="images"
                                   accept="image/*"
                                   multiple
                                   required>
                            <label class="custom-file-label" for="images">Choose files</label>
                        </div>
                        <small class="form-text text-muted">You can select multiple images at once. Max 2MB per image (JPG, PNG, JPEG)</small>
                        @error('images')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                        @error('images.*')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Caption (Optional)</label>
                        <input type="text" name="caption" 
                               class="form-control @error('caption') is-invalid @enderror" 
                               value="{{ old('caption') }}" 
                               placeholder="e.g., Summit celebration at sunrise">
                        <small class="form-text text-muted">This caption will be applied to all uploaded images</small>
                        @error('caption')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Image Preview -->
                    <div class="form-group" id="image-preview-container" style="display: none;">
                        <label>Image Previews:</label>
                        <div id="image-previews" class="row"></div>
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload"></i> Upload Images
                    </button>
                    <a href="{{ route('admin.galleries.index') }}" class="btn btn-default">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Upload Guidelines</h3>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li>Use high-quality images</li>
                    <li>Landscape orientation recommended</li>
                    <li>Max file size: 2MB per image</li>
                    <li>Supported formats: JPG, PNG, JPEG</li>
                    <li>You can upload multiple images at once</li>
                    <li>Images will be displayed in public gallery</li>
                </ul>
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
    
    // Multiple Image preview
    $('#images').change(function() {
        const files = this.files;
        const previewContainer = $('#image-previews');
        previewContainer.empty();
        
        if (files.length > 0) {
            $('#image-preview-container').show();
            
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewContainer.append(`
                        <div class="col-md-4 mb-2">
                            <img src="${e.target.result}" class="img-thumbnail" style="height: 150px; width: 100%; object-fit: cover;">
                        </div>
                    `);
                }
                
                reader.readAsDataURL(file);
            }
        } else {
            $('#image-preview-container').hide();
        }
    });
});
</script>
@endpush