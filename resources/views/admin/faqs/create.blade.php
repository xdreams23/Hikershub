@extends('layouts.admin')

@section('title', 'Add New FAQ')
@section('page-title', 'Add New FAQ')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.faqs.index') }}">FAQs</a></li>
<li class="breadcrumb-item active">Create</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">FAQ Information</h3>
            </div>
            <form action="{{ route('admin.faqs.store') }}" method="POST">
                @csrf
                
                <div class="card-body">
                    
                    <div class="form-group">
                        <label>Question *</label>
                        <input type="text" name="question" 
                               class="form-control @error('question') is-invalid @enderror" 
                               value="{{ old('question') }}" 
                               placeholder="e.g., What is the cancellation policy?"
                               required>
                        @error('question')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Answer *</label>
                        <textarea name="answer" 
                                  class="form-control @error('answer') is-invalid @enderror" 
                                  rows="6" 
                                  placeholder="Provide a detailed answer..."
                                  required>{{ old('answer') }}</textarea>
                        @error('answer')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Save FAQ
                    </button>
                    <a href="{{ route('admin.faqs.index') }}" class="btn btn-default">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Tips</h3>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li>Keep questions concise and clear</li>
                    <li>Provide detailed and helpful answers</li>
                    <li>Use simple language that's easy to understand</li>
                    <li>Cover common concerns and queries</li>
                    <li>Update FAQs regularly based on user feedback</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection