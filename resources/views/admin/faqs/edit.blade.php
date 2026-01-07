@extends('layouts.admin')

@section('title', 'Edit FAQ')
@section('page-title', 'Edit FAQ')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.faqs.index') }}">FAQs</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit FAQ</h3>
            </div>
            <form action="{{ route('admin.faqs.update', $faq) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="card-body">
                    
                    <div class="form-group">
                        <label>Question *</label>
                        <input type="text" name="question" 
                               class="form-control @error('question') is-invalid @enderror" 
                               value="{{ old('question', $faq->question) }}" 
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
                                  required>{{ old('answer', $faq->answer) }}</textarea>
                        @error('answer')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Update FAQ
                    </button>
                    <a href="{{ route('admin.faqs.index') }}" class="btn btn-default">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">FAQ Info</h3>
            </div>
            <div class="card-body">
                <p><strong>Created:</strong> {{ formatDate($faq->created_at) }}</p>
                <p><strong>Last Updated:</strong> {{ formatDate($faq->updated_at) }}</p>
            </div>
        </div>
    </div>
</div>

@endsection