<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Menu;
use Illuminate\Http\Request;

class RestaurantMenuController extends Controller
{
    /**
     * Display a listing of the restaurant's menus.
     */
    public function index(Restaurant $restaurant)
    {
        $menus = $restaurant->menus()->with('category')->get();
        return view('restaurants.menus.index', compact('restaurant', 'menus'));
    }

    /**
     * Show the form for creating a new menu item.
     */
    public function create(Restaurant $restaurant)
    {
        $categories = $restaurant->categories;
        return view('restaurants.menus.create', compact('restaurant', 'categories'));
    }

    /**
     * Store a newly created menu item.
     */
    public function store(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('menu-items', 'public');
        }

        $menu = $restaurant->menus()->create($validated);

        return redirect()
            ->route('restaurants.menus.index', $restaurant)
            ->with('success', 'منوی جدید با موفقیت اضافه شد.');
    }

    /**
     * Show the form for editing the specified menu item.
     */
    public function edit(Restaurant $restaurant, Menu $menu)
    {
        $categories = $restaurant->categories;
        return view('restaurants.menus.edit', compact('restaurant', 'menu', 'categories'));
    }

    /**
     * Update the specified menu item.
     */
    public function update(Request $request, Restaurant $restaurant, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('menu-items', 'public');
        }

        $menu->update($validated);

        return redirect()
            ->route('restaurants.menus.index', $restaurant)
            ->with('success', 'منو با موفقیت بروزرسانی شد.');
    }

    /**
     * Remove the specified menu item.
     */
    public function destroy(Restaurant $restaurant, Menu $menu)
    {
        $menu->delete();

        return redirect()
            ->route('restaurants.menus.index', $restaurant)
            ->with('success', 'منو با موفقیت حذف شد.');
    }
} 