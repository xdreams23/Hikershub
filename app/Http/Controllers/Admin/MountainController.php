<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mountain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MountainController extends Controller
{
    public function index(Request $request)
    {
        $query = Mountain::query();

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter by difficulty
        if ($request->has('difficulty') && $request->difficulty != '') {
            $query->where('difficulty_level', $request->difficulty);
        }

        $mountains = $query->latest()->paginate(10);

        return view('admin.mountains.index', compact('mountains'));
    }

    public function create()
    {
        return view('admin.mountains.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'altitude' => 'required|integer|min:0',
            'difficulty_level' => 'required|in:easy,medium,hard,extreme',
            'description' => 'required|string',
            'facilities' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload image
        if ($request->hasFile('image')) {
            $validated['image'] = uploadImage($request->file('image'), 'mountains');
        }

        Mountain::create($validated);

        return redirect()->route('admin.mountains.index')
                        ->with('success', 'Mountain created successfully.');
    }

    public function show(Mountain $mountain)
    {
        $mountain->load('trips');
        return view('admin.mountains.show', compact('mountain'));
    }

    public function edit(Mountain $mountain)
    {
        return view('admin.mountains.edit', compact('mountain'));
    }

    public function update(Request $request, Mountain $mountain)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'altitude' => 'required|integer|min:0',
            'difficulty_level' => 'required|in:easy,medium,hard,extreme',
            'description' => 'required|string',
            'facilities' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload new image
        if ($request->hasFile('image')) {
            // Delete old image
            if ($mountain->image) {
                deleteImage($mountain->image);
            }
            $validated['image'] = uploadImage($request->file('image'), 'mountains');
        }

        $mountain->update($validated);

        return redirect()->route('admin.mountains.index')
                        ->with('success', 'Mountain updated successfully.');
    }

    public function destroy(Mountain $mountain)
    {
        // Check if mountain has trips
        if ($mountain->trips()->count() > 0) {
            return redirect()->route('admin.mountains.index')
                           ->with('error', 'Cannot delete mountain with existing trips.');
        }

        // Delete image
        if ($mountain->image) {
            deleteImage($mountain->image);
        }

        $mountain->delete();

        return redirect()->route('admin.mountains.index')
                        ->with('success', 'Mountain deleted successfully.');
    }
}