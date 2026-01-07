<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Trip;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::with('trip.mountain');

        // Filter by trip
        if ($request->has('trip_id') && $request->trip_id != '') {
            $query->where('trip_id', $request->trip_id);
        }

        $galleries = $query->latest()->paginate(20);
        $trips = Trip::with('mountain')->get();

        return view('gallery.index', compact('galleries', 'trips'));
    }
}