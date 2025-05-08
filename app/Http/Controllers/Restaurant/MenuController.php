<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasRole('restaurant_owner')) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        $restaurant = auth()->user()->restaurant;
        
        if (!$restaurant) {
            return redirect()->route('restaurant.create')
                ->with('error', 'لطفا ابتدا رستوران خود را ثبت کنید.');
        }

        $menus = $restaurant->menus()
            ->withCount('items')
            ->latest()
            ->paginate(10);

        return view('restaurant.menus.index', compact('menus'));
    }

    public function create()
    {
        if (!auth()->user()->hasRole('restaurant_owner')) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        $restaurant = auth()->user()->restaurant;
        
        if (!$restaurant) {
            return redirect()->route('restaurant.create')
                ->with('error', 'لطفا ابتدا رستوران خود را ثبت کنید.');
        }

        return view('restaurant.menus.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasRole('restaurant_owner')) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        $restaurant = auth()->user()->restaurant;
        
        if (!$restaurant) {
            return redirect()->route('restaurant.create')
                ->with('error', 'لطفا ابتدا رستوران خود را ثبت کنید.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('menus', 'public');
        }

        $menu = $restaurant->menus()->create($validated);

        return redirect()
            ->route('restaurant.menus.index')
            ->with('success', 'منو با موفقیت ایجاد شد.');
    }

    public function edit(Menu $menu)
    {
        if (!auth()->user()->hasRole('restaurant_owner')) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        $restaurant = auth()->user()->restaurant;
        
        if (!$restaurant) {
            return redirect()->route('restaurant.create')
                ->with('error', 'لطفا ابتدا رستوران خود را ثبت کنید.');
        }

        if ($menu->restaurant_id !== $restaurant->id) {
            abort(403, 'شما دسترسی به این منو را ندارید.');
        }

        return view('restaurant.menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        if (!auth()->user()->hasRole('restaurant_owner')) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        $restaurant = auth()->user()->restaurant;
        
        if (!$restaurant) {
            return redirect()->route('restaurant.create')
                ->with('error', 'لطفا ابتدا رستوران خود را ثبت کنید.');
        }

        if ($menu->restaurant_id !== $restaurant->id) {
            abort(403, 'شما دسترسی به این منو را ندارید.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $menu->update($validated);

        return redirect()
            ->route('restaurant.menus.index')
            ->with('success', 'منو با موفقیت بروزرسانی شد.');
    }

    public function destroy(Menu $menu)
    {
        if (!auth()->user()->hasRole('restaurant_owner')) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        $restaurant = auth()->user()->restaurant;
        
        if (!$restaurant) {
            return redirect()->route('restaurant.create')
                ->with('error', 'لطفا ابتدا رستوران خود را ثبت کنید.');
        }

        if ($menu->restaurant_id !== $restaurant->id) {
            abort(403, 'شما دسترسی به این منو را ندارید.');
        }

        $menu->delete();

        return redirect()
            ->route('restaurant.menus.index')
            ->with('success', 'منو با موفقیت حذف شد.');
    }
}
