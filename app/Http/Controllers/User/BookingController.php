<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Trip;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['trip.mountain', 'payment'])
                          ->where('user_id', auth()->id())
                          ->latest()
                          ->paginate(10);

        return view('user.bookings.index', compact('bookings'));
    }

    public function create(Trip $trip)
    {
        // Check if trip is available
        if ($trip->status != 'open') {
            return redirect()->route('trips.show', $trip)
                           ->with('error', 'This trip is not available for booking.');
        }

        // Check if trip is full
        if ($trip->is_full) {
            return redirect()->route('trips.show', $trip)
                           ->with('error', 'This trip is fully booked.');
        }

        // Check if user already booked this trip
        $existingBooking = Booking::where('user_id', auth()->id())
                                 ->where('trip_id', $trip->id)
                                 ->whereIn('status', ['pending', 'confirmed', 'paid'])
                                 ->first();

        if ($existingBooking) {
            return redirect()->route('user.bookings.show', $existingBooking)
                           ->with('info', 'You already have a booking for this trip.');
        }

        return view('user.bookings.create', compact('trip'));
    }

    public function store(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'participants_count' => 'required|integer|min:1|max:' . $trip->available_slots,
            'notes' => 'nullable|string|max:500',
        ]);

        // Check availability again
        if ($trip->available_slots < $validated['participants_count']) {
            return redirect()->back()
                           ->with('error', 'Not enough slots available.')
                           ->withInput();
        }

        DB::beginTransaction();
        try {
            // Calculate total price
            $totalPrice = $trip->price * $validated['participants_count'];

            // Create booking
            $booking = Booking::create([
                'trip_id' => $trip->id,
                'user_id' => auth()->id(),
                'participants_count' => $validated['participants_count'],
                'total_price' => $totalPrice,
                'status' => 'pending',
                'notes' => $validated['notes'],
            ]);

            // Create payment record
            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $totalPrice,
                'payment_method' => 'transfer', // default
                'payment_date' => now(),
                'status' => 'pending',
            ]);

            // Update trip status if full
            if ($trip->is_full) {
                $trip->update(['status' => 'full']);
            }

            DB::commit();

            return redirect()->route('user.bookings.show', $booking)
                           ->with('success', 'Booking created successfully! Please upload payment proof.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'Failed to create booking. Please try again.')
                           ->withInput();
        }
    }

    public function show(Booking $booking)
    {
        // Check ownership
        if ($booking->user_id != auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $booking->load(['trip.mountain', 'payment']);

        return view('user.bookings.show', compact('booking'));
    }

    public function uploadPayment(Request $request, Booking $booking)
    {
        // Check ownership
        if ($booking->user_id != auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        // Check booking status
        if ($booking->status == 'paid') {
            return redirect()->back()
                           ->with('info', 'Payment already verified.');
        }

        if ($booking->status == 'cancelled') {
            return redirect()->back()
                           ->with('error', 'Cannot upload payment for cancelled booking.');
        }

        $validated = $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload payment proof
        if ($request->hasFile('payment_proof')) {
            // Delete old proof if exists
            if ($booking->payment_proof) {
                deleteImage($booking->payment_proof);
            }

            $path = uploadImage($request->file('payment_proof'), 'payments');
            
            // Update booking
            $booking->update([
                'payment_proof' => $path,
                'status' => 'confirmed',
            ]);

            // Update payment status
            if ($booking->payment) {
                $booking->payment->update([
                    'status' => 'pending',
                    'payment_date' => now(),
                ]);
            }
        }

        return redirect()->route('user.bookings.show', $booking)
                        ->with('success', 'Payment proof uploaded successfully. Waiting for admin verification.');
    }

    public function cancel(Booking $booking)
    {
        // Check ownership
        if ($booking->user_id != auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        // Check if already paid
        if ($booking->status == 'paid') {
            return redirect()->back()
                           ->with('error', 'Cannot cancel paid booking. Please contact admin.');
        }

        // Cancel booking
        $booking->update(['status' => 'cancelled']);

        // Update trip status back to open if was full
        $trip = $booking->trip;
        if ($trip->status == 'full' && !$trip->is_full) {
            $trip->update(['status' => 'open']);
        }

        return redirect()->route('user.bookings.index')
                        ->with('success', 'Booking cancelled successfully.');
    }
}