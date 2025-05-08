<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuManagementController extends Controller
{
    public function index(Restaurant $restaurant)
    {
        $menus = $restaurant->menus()->withCount('items')->paginate(10);
        return view('admin.menus.index', compact('restaurant', 'menus'));
    }

    public function create(Restaurant $restaurant)
    {
        return view('admin.menus.create', compact('restaurant'));
    }

    public function store(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('menus', 'public');
        }

        $restaurant->menus()->create($validated);

        return redirect()->route('admin.restaurants.menus.index', $restaurant)
            ->with('success', 'منو با موفقیت ایجاد شد.');
    }

    public function edit(Restaurant $restaurant, Menu $menu)
    {
        return view('admin.menus.edit', compact('restaurant', 'menu'));
    }

    public function update(Request $request, Restaurant $restaurant, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            $validated['image'] = $request->file('image')->store('menus', 'public');
        }

        $menu->update($validated);

        return redirect()->route('admin.restaurants.menus.index', $restaurant)
            ->with('success', 'منو با موفقیت بروزرسانی شد.');
    }

    public function destroy(Restaurant $restaurant, Menu $menu)
    {
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()->route('admin.restaurants.menus.index', $restaurant)
            ->with('success', 'منو با موفقیت حذف شد.');
    }

    public function toggleStatus(Restaurant $restaurant, Menu $menu)
    {
        $menu->update([
            'status' => $menu->status === 'active' ? 'inactive' : 'active'
        ]);

        return redirect()->route('admin.restaurants.menus.index', $restaurant)
            ->with('success', 'وضعیت منو با موفقیت تغییر کرد.');
    }
} 