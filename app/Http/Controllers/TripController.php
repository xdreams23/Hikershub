<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Mountain;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $query = Trip::with('mountain')->open();

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->search($request->search);
        }

        // Filter by difficulty
        if ($request->has('difficulty') && $request->difficulty != '') {
            $query->filterByDifficulty($request->difficulty);
        }

        // Filter by mountain
        if ($request->has('mountain_id') && $request->mountain_id != '') {
            $query->where('mountain_id', $request->mountain_id);
        }

        // Filter by price range
        if ($request->has('min_price') && $request->has('max_price')) {
            $query->filterByPrice($request->min_price, $request->max_price);
        }

        // Sort
        $sortBy = $request->get('sort', 'date');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'date':
            default:
                $query->orderBy('start_date', 'asc');
                break;
        }

        $trips = $query->paginate(12)->withQueryString();
        $mountains = Mountain::all();

        return view('trips.index', compact('trips', 'mountains'));
    }

    public function show(Trip $trip)
    {
        $trip->load([
            'mountain',
            'reviews.user',
            'galleries'
        ]);

        // Related trips (same mountain, different dates)
        $relatedTrips = Trip::where('mountain_id', $trip->mountain_id)
                           ->where('id', '!=', $trip->id)
                           ->open()
                           ->take(3)
                           ->get();

        return view('trips.show', compact('trip', 'relatedTrips'));
    }
}