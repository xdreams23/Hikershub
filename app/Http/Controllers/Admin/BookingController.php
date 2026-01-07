<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'trip.mountain', 'payment']);

        // Search by booking code or user name
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by trip
        if ($request->has('trip_id') && $request->trip_id != '') {
            $query->where('trip_id', $request->trip_id);
        }

        $bookings = $query->latest()->paginate(15);
        $trips = Trip::with('mountain')->get();

        return view('admin.bookings.index', compact('bookings', 'trips'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'trip.mountain', 'payment']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,paid,cancelled'
        ]);

        $booking->update($validated);

        // Update trip status if full
        if ($booking->status == 'confirmed' || $booking->status == 'paid') {
            $trip = $booking->trip;
            if ($trip->is_full) {
                $trip->update(['status' => 'full']);
            }
        }

        return redirect()->back()
                        ->with('success', 'Booking status updated successfully.');
    }

    public function cancel(Booking $booking)
    {
        if ($booking->status == 'cancelled') {
            return redirect()->back()
                           ->with('error', 'Booking is already cancelled.');
        }

        $booking->update(['status' => 'cancelled']);

        // Update trip status back to open if was full
        $trip = $booking->trip;
        if ($trip->status == 'full' && !$trip->is_full) {
            $trip->update(['status' => 'open']);
        }

        return redirect()->back()
                        ->with('success', 'Booking cancelled successfully.');
    }
}