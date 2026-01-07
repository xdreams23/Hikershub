<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Trip;
use App\Models\Mountain;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function revenue(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());

        // Total revenue
        $totalRevenue = Payment::where('status', 'success')
                              ->whereBetween('verified_at', [$startDate, $endDate])
                              ->sum('amount');

        // Daily revenue
        $dailyRevenue = Payment::where('status', 'success')
                              ->whereBetween('verified_at', [$startDate, $endDate])
                              ->selectRaw('DATE(verified_at) as date, SUM(amount) as total')
                              ->groupBy('date')
                              ->orderBy('date')
                              ->get();

        // Revenue by payment method
        $revenueByMethod = Payment::where('status', 'success')
                                  ->whereBetween('verified_at', [$startDate, $endDate])
                                  ->selectRaw('payment_method, SUM(amount) as total, COUNT(*) as count')
                                  ->groupBy('payment_method')
                                  ->get();

        return view('admin.reports.revenue', compact(
            'totalRevenue',
            'dailyRevenue',
            'revenueByMethod',
            'startDate',
            'endDate'
        ));
    }

    public function bookings(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());

        // Bookings statistics
        $totalBookings = Booking::whereBetween('created_at', [$startDate, $endDate])->count();
        $paidBookings = Booking::where('status', 'paid')
                              ->whereBetween('created_at', [$startDate, $endDate])
                              ->count();
        $pendingBookings = Booking::where('status', 'pending')
                                 ->whereBetween('created_at', [$startDate, $endDate])
                                 ->count();
        $cancelledBookings = Booking::where('status', 'cancelled')
                                   ->whereBetween('created_at', [$startDate, $endDate])
                                   ->count();

        // Bookings by status
        $bookingsByStatus = Booking::whereBetween('created_at', [$startDate, $endDate])
                                  ->selectRaw('status, COUNT(*) as count')
                                  ->groupBy('status')
                                  ->get();

        // Daily bookings
        $dailyBookings = Booking::whereBetween('created_at', [$startDate, $endDate])
                               ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                               ->groupBy('date')
                               ->orderBy('date')
                               ->get();

        return view('admin.reports.bookings', compact(
            'totalBookings',
            'paidBookings',
            'pendingBookings',
            'cancelledBookings',
            'bookingsByStatus',
            'dailyBookings',
            'startDate',
            'endDate'
        ));
    }

    public function trips(Request $request)
    {
        // Most popular trips
        $popularTrips = Trip::withCount(['bookings' => function($q) {
                            $q->whereIn('status', ['paid', 'confirmed']);
                        }])
                           ->with('mountain')
                           ->orderBy('bookings_count', 'desc')
                           ->take(10)
                           ->get();

        // Trips by mountain
        $tripsByMountain = Mountain::withCount('trips')
                                  ->orderBy('trips_count', 'desc')
                                  ->get();

        // Upcoming trips
        $upcomingTrips = Trip::with('mountain')
                            ->where('start_date', '>', Carbon::now())
                            ->where('status', 'open')
                            ->orderBy('start_date')
                            ->take(10)
                            ->get();

        return view('admin.reports.trips', compact(
            'popularTrips',
            'tripsByMountain',
            'upcomingTrips'
        ));
    }

    public function mountains()
    {
        // Most popular mountains
        $popularMountains = Mountain::withCount(['trips' => function($q) {
                                      $q->whereHas('bookings', function($bq) {
                                          $bq->whereIn('status', ['paid', 'confirmed']);
                                      });
                                  }])
                                  ->orderBy('trips_count', 'desc')
                                  ->get();

        // Mountains by difficulty
        $mountainsByDifficulty = Mountain::selectRaw('difficulty_level, COUNT(*) as count')
                                        ->groupBy('difficulty_level')
                                        ->get();

        return view('admin.reports.mountains', compact(
            'popularMountains',
            'mountainsByDifficulty'
        ));
    }

    public function participants(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());

        // Total participants
        $totalParticipants = Booking::whereIn('status', ['paid', 'confirmed'])
                                   ->whereBetween('created_at', [$startDate, $endDate])
                                   ->sum('participants_count');

        // Participants by trip
        $participantsByTrip = Trip::with('mountain')
                                 ->withSum(['bookings as total_participants' => function($q) use ($startDate, $endDate) {
                                     $q->whereIn('status', ['paid', 'confirmed'])
                                       ->whereBetween('created_at', [$startDate, $endDate]);
                                 }], 'participants_count')
                                 ->orderBy('total_participants', 'desc')
                                 ->take(10)
                                 ->get();

        return view('admin.reports.participants', compact(
            'totalParticipants',
            'participantsByTrip',
            'startDate',
            'endDate'
        ));
    }
}