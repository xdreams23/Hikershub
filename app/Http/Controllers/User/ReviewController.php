<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Trip;
use App\Models\Booking;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Trip $trip)
    {
        // Check if user has joined this trip
        $hasJoined = Booking::where('user_id', auth()->id())
                           ->where('trip_id', $trip->id)
                           ->where('status', 'paid')
                           ->exists();

        if (!$hasJoined) {
            return redirect()->back()
                           ->with('error', 'You can only review trips you have joined.');
        }

        // Check if already reviewed
        $existingReview = Review::where('user_id', auth()->id())
                               ->where('trip_id', $trip->id)
                               ->first();

        if ($existingReview) {
            return redirect()->route('trips.show', $trip)
                           ->with('info', 'You have already reviewed this trip.');
        }

        return view('user.reviews.create', compact('trip'));
    }

    public function store(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        // Check if already reviewed
        $existingReview = Review::where('user_id', auth()->id())
                               ->where('trip_id', $trip->id)
                               ->first();

        if ($existingReview) {
            return redirect()->route('trips.show', $trip)
                           ->with('error', 'You have already reviewed this trip.');
        }

        Review::create([
            'trip_id' => $trip->id,
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->route('trips.show', $trip)
                        ->with('success', 'Thank you for your review!');
    }

    public function edit(Review $review)
    {
        // Check ownership
        if ($review->user_id != auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('user.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        // Check ownership
        if ($review->user_id != auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        $review->update($validated);

        return redirect()->route('trips.show', $review->trip)
                        ->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        // Check ownership
        if ($review->user_id != auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $tripId = $review->trip_id;
        $review->delete();

        return redirect()->route('trips.show', $tripId)
                        ->with('success', 'Review deleted successfully.');
    }
}