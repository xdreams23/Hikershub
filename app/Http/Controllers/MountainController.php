<?php

namespace App\Http\Controllers;

use App\Models\Mountain;
use Illuminate\Http\Request;

class MountainController extends Controller
{
    public function index(Request $request)
    {
        $query = Mountain::withCount('trips');

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->search($request->search);
        }

        // Filter by difficulty
        if ($request->has('difficulty') && $request->difficulty != '') {
            $query->where('difficulty_level', $request->difficulty);
        }

        $mountains = $query->paginate(12);

        return view('mountains.index', compact('mountains'));
    }

    public function show(Mountain $mountain)
    {
        $mountain->load('trips');

        // Get available trips for this mountain
        $upcomingTrips = $mountain->trips()
                                 ->open()
                                 ->upcoming()
                                 ->get();

        return view('mountains.show', compact('mountain', 'upcomingTrips'));
    }
}