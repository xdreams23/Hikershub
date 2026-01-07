<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\Mountain;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $query = Trip::with('mountain');

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('mountain', function($mq) use ($search) {
                      $mq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by mountain
        if ($request->has('mountain_id') && $request->mountain_id != '') {
            $query->where('mountain_id', $request->mountain_id);
        }

        $trips = $query->latest()->paginate(10);
        $mountains = Mountain::all();

        return view('admin.trips.index', compact('trips', 'mountains'));
    }

    public function create()
    {
        $mountains = Mountain::all();
        return view('admin.trips.create', compact('mountains'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mountain_id' => 'required|exists:mountains,id',
            'title' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'duration_days' => 'required|integer|min:1',
            'meeting_point' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'max_participants' => 'required|integer|min:1',
            'min_participants' => 'required|integer|min:1|lte:max_participants',
            'status' => 'required|in:open,full,closed,cancelled',
            'itinerary' => 'nullable|string',
            'include_items' => 'nullable|string',
            'exclude_items' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
        ]);

        Trip::create($validated);

        return redirect()->route('admin.trips.index')
                        ->with('success', 'Trip created successfully.');
    }

    public function show(Trip $trip)
    {
        $trip->load(['mountain', 'bookings.user', 'reviews.user', 'galleries']);
        return view('admin.trips.show', compact('trip'));
    }

    public function edit(Trip $trip)
    {
        $mountains = Mountain::all();
        return view('admin.trips.edit', compact('trip', 'mountains'));
    }

    public function update(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'mountain_id' => 'required|exists:mountains,id',
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'duration_days' => 'required|integer|min:1',
            'meeting_point' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'max_participants' => 'required|integer|min:1',
            'min_participants' => 'required|integer|min:1|lte:max_participants',
            'status' => 'required|in:open,full,closed,cancelled',
            'itinerary' => 'nullable|string',
            'include_items' => 'nullable|string',
            'exclude_items' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
        ]);

        $trip->update($validated);

        return redirect()->route('admin.trips.index')
                        ->with('success', 'Trip updated successfully.');
    }

    public function destroy(Trip $trip)
    {
        // Check if trip has bookings
        if ($trip->bookings()->count() > 0) {
            return redirect()->route('admin.trips.index')
                           ->with('error', 'Cannot delete trip with existing bookings.');
        }

        $trip->delete();

        return redirect()->route('admin.trips.index')
                        ->with('success', 'Trip deleted successfully.');
    }

    public function updateStatus(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,full,closed,cancelled'
        ]);

        $trip->update($validated);

        return redirect()->back()
                        ->with('success', 'Trip status updated successfully.');
    }
}