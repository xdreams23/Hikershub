<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Trip;
use App\Models\User;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $totalBookings = Booking::count();
        $totalRevenue = Payment::where('status', 'success')->sum('amount');
        $pendingPayments = Payment::where('status', 'pending')->count();
        $upcomingTrips = Trip::where('start_date', '>', Carbon::now())
                             ->where('status', 'open')
                             ->count();

        // Recent Bookings
        $recentBookings = Booking::with(['user', 'trip.mountain'])
                                ->latest()
                                ->take(10)
                                ->get();

        // Monthly Revenue Chart Data
        $monthlyRevenue = Payment::where('status', 'success')
                                ->whereYear('created_at', Carbon::now()->year)
                                ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
                                ->groupBy('month')
                                ->pluck('total', 'month')
                                ->toArray();

        // Fill missing months with 0
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $monthlyRevenue[$i] ?? 0;
        }

        // Popular Mountains
        $popularMountains = Trip::with('mountain')
                                ->selectRaw('mountain_id, COUNT(*) as trip_count')
                                ->groupBy('mountain_id')
                                ->orderBy('trip_count', 'desc')
                                ->take(5)
                                ->get();

        return view('admin.dashboard', compact(
            'totalBookings',
            'totalRevenue',
            'pendingPayments',
            'upcomingTrips',
            'recentBookings',
            'chartData',
            'popularMountains'
        ));
    }
}