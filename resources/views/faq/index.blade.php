@extends('layouts.app')

@section('title', 'Frequently Asked Questions')

@section('content')

<!-- Page Header -->
<div class="bg-success text-white py-5">
    <div class="container">
        <h1 class="display-4 mb-0"><i class="fas fa-question-circle"></i> FAQ</h1>
        <p class="lead">Frequently Asked Questions</p>
    </div>
</div>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            @if($faqs->count() > 0)
            
            <div class="accordion" id="faqAccordion">
                @foreach($faqs as $index => $faq)
                <div class="card mb-3">
                    <div class="card-header" id="heading{{ $index }}">
                        <h5 class="mb-0">
                            <button class="btn btn-link text-decoration-none w-100 text-start" 
                                    type="button" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#collapse{{ $index }}" 
                                    aria-expanded="{{ $index == 0 ? 'true' : 'false' }}">
                                <i class="fas fa-chevron-down me-2"></i>
                                {{ $faq->question }}
                            </button>
                        </h5>
                    </div>

                    <div id="collapse{{ $index }}" 
                         class="collapse {{ $index == 0 ? 'show' : '' }}" 
                         data-bs-parent="#faqAccordion">
                        <div class="card-body">
                            <p class="mb-0" style="white-space: pre-line;">{{ $faq->answer }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> No FAQs available at the moment.
            </div>
            @endif

            <!-- Still Have Questions -->
            <div class="card bg-light mt-5">
                <div class="card-body text-center">
                    <h4>Still have questions?</h4>
                    <p class="text-muted">Can't find the answer you're looking for? Feel free to contact us!</p>
                    <a href="{{ route('contact') }}" class="btn btn-success">
                        <i class="fas fa-envelope"></i> Contact Us
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection