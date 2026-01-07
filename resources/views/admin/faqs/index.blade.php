@extends('layouts.admin')

@section('title', 'Manage FAQs')
@section('page-title', 'FAQs Management')

@section('breadcrumb')
<li class="breadcrumb-item active">FAQs</li>
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Frequently Asked Questions</h3>
            <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New FAQ
            </a>
        </div>
    </div>
    <div class="card-body">
        
        @if($faqs->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Question</th>
                        <th>Answer Preview</th>
                        <th>Created</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($faqs as $faq)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $faq->question }}</strong></td>
                        <td>{{ Str::limit($faq->answer, 80) }}</td>
                        <td>{{ formatDate($faq->created_at, 'd M Y') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.faqs.edit', $faq) }}" 
                                   class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.faqs.destroy', $faq) }}" 
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
            {{ $faqs->links() }}
        </div>
        
        @else
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> No FAQs available. Add your first FAQ!
        </div>
        @endif
    </div>
</div>

@endsection