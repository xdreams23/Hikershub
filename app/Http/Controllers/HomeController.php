<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Mountain;
use App\Models\Review;
use App\Models\Gallery;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Featured/Upcoming Trips
        $featuredTrips = Trip::with('mountain')
                            ->open()
                            ->upcoming()
                            ->take(6)
                            ->get();

        // Popular Mountains
        $popularMountains = Mountain::withCount('trips')
                                   ->orderBy('trips_count', 'desc')
                                   ->take(4)
                                   ->get();

        // Latest Reviews
        $latestReviews = Review::with(['user', 'trip.mountain'])
                              ->latest()
                              ->take(3)
                              ->get();

        // Gallery highlights
        $galleryImages = Gallery::with('trip.mountain')
                               ->latest()
                               ->take(8)
                               ->get();

        return view('home', compact(
            'featuredTrips',
            'popularMountains',
            'latestReviews',
            'galleryImages'
        ));
    }
}