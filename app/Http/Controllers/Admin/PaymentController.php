<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['booking.user', 'booking.trip.mountain']);

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Show pending first
        $payments = $query->orderByRaw("FIELD(status, 'pending', 'success', 'failed')")
                         ->latest()
                         ->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['booking.user', 'booking.trip.mountain', 'verifier']);
        return view('admin.payments.show', compact('payment'));
    }

    public function verify(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => 'required|in:success,failed',
            'notes' => 'nullable|string'
        ]);

        // Update payment
        $payment->update([
            'status' => $validated['status'],
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        // Update booking status
        if ($validated['status'] == 'success') {
            $payment->booking->update(['status' => 'paid']);
        } else {
            $payment->booking->update(['status' => 'pending']);
        }

        return redirect()->route('admin.payments.index')
                        ->with('success', 'Payment verified successfully.');
    }

    public function pending()
    {
        $payments = Payment::with(['booking.user', 'booking.trip.mountain'])
                          ->where('status', 'pending')
                          ->latest()
                          ->paginate(15);

        return view('admin.payments.pending', compact('payments'));
    }
}