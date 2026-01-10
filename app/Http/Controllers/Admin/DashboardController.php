<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Trip;
use App\Models\User;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Tambahkan ini biar aman

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistics Cards
        $totalBookings = Booking::count();
        $totalRevenue = Payment::where('status', 'success')->sum('amount');
        $pendingPayments = Payment::where('status', 'pending')->count();
        $upcomingTrips = Trip::where('start_date', '>', Carbon::now())
                             ->where('status', 'open')
                             ->count();

        // 2. Recent Bookings List
        $recentBookings = Booking::with(['user', 'trip.mountain'])
                                ->latest()
                                ->take(10)
                                ->get();

        // 3. Monthly Revenue Chart (INI YANG KITA PERBAIKI)
        $monthlyRevenue = Payment::where('status', 'success')
            ->whereYear('created_at', Carbon::now()->year)
            // PERBAIKAN: Pakai CAST(... AS INTEGER) agar hasilnya angka bulat (1, 2, 3), bukan desimal (1.0)
            ->selectRaw('CAST(EXTRACT(MONTH FROM created_at) AS INTEGER) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Fill missing months with 0
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            // Karena sudah di-CAST jadi integer, sekarang $i pasti cocok dengan key array
            $chartData[] = $monthlyRevenue[$i] ?? 0;
        }

        // 4. Popular Mountains
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