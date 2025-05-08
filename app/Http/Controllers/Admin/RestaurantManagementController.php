<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RestaurantManagementController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::withCount(['reservations', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->latest()
            ->paginate(10);

        return view('admin.restaurants.index', compact('restaurants'));
    }

    public function create()
    {
        return view('admin.restaurants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'description' => 'required|string',
            'opening_hours' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('restaurants', 'public');
        }

        Restaurant::create($validated);

        return redirect()->route('admin.restaurants.index')
            ->with('success', 'رستوران با موفقیت ایجاد شد.');
    }

    public function edit(Restaurant $restaurant)
    {
        return view('admin.restaurants.edit', compact('restaurant'));
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'description' => 'required|string',
            'opening_hours' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            if ($restaurant->image) {
                Storage::disk('public')->delete($restaurant->image);
            }
            $validated['image'] = $request->file('image')->store('restaurants', 'public');
        }

        $restaurant->update($validated);

        return redirect()->route('admin.restaurants.index')
            ->with('success', 'رستوران با موفقیت بروزرسانی شد.');
    }

    public function destroy(Restaurant $restaurant)
    {
        if ($restaurant->image) {
            Storage::disk('public')->delete($restaurant->image);
        }
        
        $restaurant->delete();

        return redirect()->route('admin.restaurants.index')
            ->with('success', 'رستوران با موفقیت حذف شد.');
    }

    public function toggleStatus(Restaurant $restaurant)
    {
        $restaurant->update([
            'status' => $restaurant->status === 'active' ? 'inactive' : 'active'
        ]);

        return redirect()->route('admin.restaurants.index')
            ->with('success', 'وضعیت رستوران با موفقیت تغییر کرد.');
    }
} 