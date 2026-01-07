<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get user's bookings
        $bookings = Booking::with(['trip.mountain', 'payment'])
                          ->where('user_id', $user->id)
                          ->latest()
                          ->paginate(10);

        // Statistics
        $totalBookings = $bookings->total();
        $pendingBookings = Booking::where('user_id', $user->id)
                                 ->where('status', 'pending')
                                 ->count();
        $paidBookings = Booking::where('user_id', $user->id)
                              ->where('status', 'paid')
                              ->count();

        return view('user.dashboard', compact(
            'bookings',
            'totalBookings',
            'pendingBookings',
            'paidBookings'
        ));
    }
}