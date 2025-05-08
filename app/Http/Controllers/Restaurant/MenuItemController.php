<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuItemController extends Controller
{
    public function create(Menu $menu)
    {
        if (!auth()->user()->hasRole('restaurant_owner')) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        $restaurant = auth()->user()->hasRole('restaurant_owner');

        if (!$restaurant || $menu->restaurant_id !== $restaurant->id) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        return view('restaurant.menu-items.create', compact('menu'));
    }

    public function store(Request $request, Menu $menu)
    {
        if (!auth()->user()->hasRole('restaurant_owner')) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        $restaurant = auth()->user()->restaurant;

        if (!$restaurant || $menu->restaurant_id !== $restaurant->id) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('menu-items', 'public');
        }

        $menu->items()->create($validated);

        return redirect()
            ->route('restaurant.menus.edit', $menu)
            ->with('success', 'آیتم منو با موفقیت ایجاد شد.');
    }

    public function edit(Menu $menu, MenuItem $menuItem)
    {
        if (!auth()->user()->hasRole('restaurant_owner')) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        $restaurant = auth()->user()->restaurant;

        if (!$restaurant || $menu->restaurant_id !== $restaurant->id || $menuItem->menu_id !== $menu->id) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        return view('restaurant.menu-items.edit', compact('menu', 'menuItem'));
    }

    public function update(Request $request, Menu $menu, MenuItem $menuItem)
    {
        if (!auth()->user()->hasRole('restaurant_owner')) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        $restaurant = auth()->user()->restaurant;

        if (!$restaurant || $menu->restaurant_id !== $restaurant->id || $menuItem->menu_id !== $menu->id) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($menuItem->image_url) {
                Storage::disk('public')->delete($menuItem->image_url);
            }
            $validated['image_url'] = $request->file('image')->store('menu-items', 'public');
        }

        $menuItem->update($validated);

        return redirect()
            ->route('restaurant.menus.edit', $menu)
            ->with('success', 'آیتم منو با موفقیت بروزرسانی شد.');
    }

    public function destroy(Menu $menu, MenuItem $menuItem)
    {
        if (!auth()->user()->hasRole('restaurant_owner')) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        $restaurant = auth()->user()->restaurant;

        if (!$restaurant || $menu->restaurant_id !== $restaurant->id || $menuItem->menu_id !== $menu->id) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        // Delete image if exists
        if ($menuItem->image_url) {
            Storage::disk('public')->delete($menuItem->image_url);
        }

        $menuItem->delete();

        return redirect()
            ->route('restaurant.menus.edit', $menu)
            ->with('success', 'آیتم منو با موفقیت حذف شد.');
    }
}
