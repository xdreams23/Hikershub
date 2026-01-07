<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        return view('admin.galleries.index', compact('galleries', 'trips'));
    }

    public function create()
    {
        $trips = Trip::with('mountain')->get();
        return view('admin.galleries.create', compact('trips'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        // Upload multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = uploadImage($image, 'galleries');
                
                Gallery::create([
                    'trip_id' => $validated['trip_id'],
                    'image_path' => $path,
                    'caption' => $validated['caption'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.galleries.index')
                        ->with('success', 'Images uploaded successfully.');
    }

    public function edit(Gallery $gallery)
    {
        $trips = Trip::with('mountain')->get();
        return view('admin.galleries.edit', compact('gallery', 'trips'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'caption' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload new image if provided
        if ($request->hasFile('image')) {
            // Delete old image
            if ($gallery->image_path) {
                deleteImage($gallery->image_path);
            }
            $validated['image_path'] = uploadImage($request->file('image'), 'galleries');
        }

        $gallery->update($validated);

        return redirect()->route('admin.galleries.index')
                        ->with('success', 'Gallery updated successfully.');
    }

    public function destroy(Gallery $gallery)
    {
        // Delete image
        if ($gallery->image_path) {
            deleteImage($gallery->image_path);
        }

        $gallery->delete();

        return redirect()->route('admin.galleries.index')
                        ->with('success', 'Gallery deleted successfully.');
    }
}