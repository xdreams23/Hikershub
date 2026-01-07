@extends('layouts.app')

@section('title', 'Book Trip')

@section('styles')
<style>
    /* --- 1. PALETTE --- */
    :root {
        --primary-dark: #2c5f2d;
        --primary-light: #97bc62;
        --accent-color: #e5732d;
        --text-dark: #1a1a1a;
        --text-grey: #6c757d;
        --bg-off-white: #f8f9fa;
    }

    /* --- 2. NAVBAR SCROLL LOGIC --- */
    .navbar {
        position: fixed !important;
        top: 0;
        width: 100%;
        z-index: 9999;
        background-color: transparent !important;
        box-shadow: none !important;
        transition: all 0.4s ease-in-out;
        padding-top: 25px !important;
        padding-bottom: 25px !important;
    }

    .navbar.scrolled {
        background-color: rgba(20, 30, 20, 0.95) !important;
        backdrop-filter: blur(10px);
        padding-top: 12px !important;
        padding-bottom: 12px !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
    }

    .navbar .navbar-brand { color: white !important; font-weight: 800; }
    .navbar .nav-link { color: rgba(255, 255, 255, 0.9) !important; font-weight: 500; }
    .navbar .nav-link:hover { color: var(--accent-color) !important; }
    .navbar .btn-outline-primary { color: white !important; border-color: white !important; }
    .navbar .btn-outline-primary:hover { background-color: var(--accent-color) !important; border-color: var(--accent-color) !important; }

    /* --- 3. PAGE HEADER --- */
    .booking-header {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.8)), url('{{ asset("images/Elvin.jpg") }}');
        background-size: cover;
        background-position: center;
        padding: 160px 0 100px 0;
        color: white;
        text-align: center;
        margin-bottom: 50px;
    }

    /* --- 4. FORM & SUMMARY --- */
    .form-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }

    .summary-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        border: 1px solid #f0f0f0;
        position: sticky;
        top: 100px;
    }

    .summary-header {
        background: var(--bg-off-white);
        padding: 20px 25px;
        border-bottom: 1px solid #eee;
    }

    .trip-thumb {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        object-fit: cover;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        color: var(--text-grey);
    }

    .price-total {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px dashed #eee;
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--primary-dark);
    }

    /* Form Elements */
    .form-label {
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border-radius: 12px;
        padding: 12px 15px;
        border: 1px solid #eee;
        background-color: var(--bg-off-white);
        font-size: 0.95rem;
    }
    .form-control:focus {
        border-color: var(--primary-light);
        box-shadow: 0 0 0 3px rgba(151, 188, 98, 0.1);
        background-color: white;
    }

    .btn-confirm {
        background: var(--accent-color);
        color: white;
        width: 100%;
        padding: 15px;
        border-radius: 12px;
        font-weight: 700;
        border: none;
        transition: all 0.3s;
    }
    .btn-confirm:hover { background: #c45d1e; transform: translateY(-2px); color: white; }

</style>
@endsection

@section('content')

<div class="booking-header">
    <div class="container">
        <h1 class="display-4 fw-bold mb-2">Secure Your Spot</h1>
        <p class="lead opacity-90">You are booking a trip to {{ $trip->mountain->name }}</p>
    </div>
</div>

<div class="container pb-5" style="margin-top: -80px; position: relative; z-index: 10;">
    
    <form action="{{ route('user.bookings.store', $trip) }}" method="POST" id="bookingForm">
        @csrf
        <div class="row g-5">
            
            <div class="col-lg-8">
                <div class="form-card">
                    <h4 class="fw-bold mb-4"><i class="fas fa-user-edit me-2 text-muted"></i> Hiker Details</h4>
                    
                    @if(!auth()->user()->phone)
                    <div class="alert alert-warning border-0 rounded-3 mb-4">
                        <div class="d-flex">
                            <i class="fas fa-exclamation-circle fa-lg mt-1 me-3"></i>
                            <div>
                                <strong>Profile Incomplete</strong>
                                <p class="mb-0 small">Please add your phone number for emergency contact purposes.</p>
                                <a href="{{ route('user.profile.edit') }}" class="fw-bold text-dark text-decoration-none small">Update Profile -></a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                        </div>
                    </div>

                    <hr class="my-5 opacity-10">

                    <h4 class="fw-bold mb-4"><i class="fas fa-ticket-alt me-2 text-muted"></i> Booking Details</h4>

                    <div class="mb-4">
                        <label class="form-label">Number of Participants <span class="text-danger">*</span></label>
                        <div class="d-flex align-items-center gap-3">
                            <button type="button" class="btn btn-outline-secondary rounded-circle" style="width:40px; height:40px;" onclick="adjustParticipants(-1)">-</button>
                            <input type="number" name="participants_count" id="participants_count"
                                   class="form-control text-center fw-bold fs-5" 
                                   style="width: 80px;"
                                   value="{{ old('participants_count', 1) }}"
                                   min="1" max="{{ $trip->available_slots }}" readonly>
                            <button type="button" class="btn btn-outline-secondary rounded-circle" style="width:40px; height:40px;" onclick="adjustParticipants(1)">+</button>
                            <span class="text-muted small ms-2">({{ $trip->available_slots }} slots left)</span>
                        </div>
                        @error('participants_count') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Special Requests (Optional)</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Dietary restrictions, health conditions, etc...">{{ old('notes') }}</textarea>
                    </div>

                    <div class="form-check p-3 rounded-3 bg-light">
                        <input class="form-check-input mt-1" type="checkbox" id="agree_terms" required>
                        <label class="form-check-label small" for="agree_terms">
                            I acknowledge that hiking involves risks and I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal" class="fw-bold text-success">Terms & Conditions</a> set by HikersHub.
                        </label>
                    </div>

                </div>
            </div>

            <div class="col-lg-4">
                <div class="summary-card">
                    <div class="summary-header">
                        <h5 class="fw-bold mb-0">Order Summary</h5>
                    </div>
                    <div class="p-4">
                        <div class="d-flex gap-3 mb-4">
                            <img src="{{ $trip->mountain->image ? asset('storage/'.$trip->mountain->image) : 'https://via.placeholder.com/80' }}" 
                                 class="trip-thumb shadow-sm" alt="Mountain">
                            <div>
                                <h6 class="fw-bold mb-1">{{ Str::limit($trip->title, 40) }}</h6>
                                <p class="text-muted small mb-0">
                                    <i class="far fa-calendar me-1"></i> {{ date('d M', strtotime($trip->start_date)) }} - {{ date('d M Y', strtotime($trip->end_date)) }}
                                </p>
                            </div>
                        </div>

                        <div class="price-row">
                            <span>Price / Pax</span>
                            <span>{{ $trip->formatted_price }}</span>
                        </div>
                        <div class="price-row">
                            <span>Participants</span>
                            <span id="summary_count">x 1</span>
                        </div>
                        
                        <div class="price-total">
                            <span>Total Payment</span>
                            <span class="text-success" id="total_price">{{ $trip->formatted_price }}</span>
                        </div>

                        <button type="submit" class="btn-confirm mt-4">
                            Proceed to Payment <i class="fas fa-lock ms-2"></i>
                        </button>
                        
                        <div class="text-center mt-3">
                            <a href="{{ route('trips.show', $trip) }}" class="text-muted small text-decoration-none">Cancel Booking</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<div class="modal fade" id="termsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Terms & Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bg-light rounded-3 m-3 p-4" style="max-height: 400px; overflow-y: auto;">
                <p style="white-space: pre-line;" class="text-muted mb-0">{{ $trip->terms_conditions ?? 'Standard hiking safety and cancellation policies apply.' }}</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-dark px-4 rounded-pill" data-bs-dismiss="modal">I Understand</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Navbar Scroll
    document.addEventListener("DOMContentLoaded", function(){
        const navbar = document.querySelector('.navbar'); 
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    });

    // Dynamic Price Calculation
    const pricePerPerson = {{ $trip->price }};
    const maxSlots = {{ $trip->available_slots }};
    const input = document.getElementById('participants_count');
    const summaryCount = document.getElementById('summary_count');
    const totalElement = document.getElementById('total_price');

    function adjustParticipants(amount) {
        let current = parseInt(input.value);
        let newVal = current + amount;

        if (newVal >= 1 && newVal <= maxSlots) {
            input.value = newVal;
            updateTotal(newVal);
        }
    }

    function updateTotal(count) {
        const total = pricePerPerson * count;
        summaryCount.textContent = 'x ' + count;
        
        // Format Currency IDR
        totalElement.textContent = 'Rp ' + total.toLocaleString('id-ID');
    }
</script>
@endpush