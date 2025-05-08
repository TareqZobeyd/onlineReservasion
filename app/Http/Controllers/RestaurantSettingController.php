<?php

namespace App\Http\Controllers;

use App\Http\Requests\Restaurant\UpdateRestaurantSettingsRequest;
use App\Models\Restaurant;
use App\Models\RestaurantSetting;
use Illuminate\Http\Request;

class RestaurantSettingController extends Controller
{
    public function edit(Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);
        
        $settings = $restaurant->settings ?? new RestaurantSetting([
            'working_hours' => [
                'monday' => ['open' => '09:00', 'close' => '22:00'],
                'tuesday' => ['open' => '09:00', 'close' => '22:00'],
                'wednesday' => ['open' => '09:00', 'close' => '22:00'],
                'thursday' => ['open' => '09:00', 'close' => '22:00'],
                'friday' => ['open' => '09:00', 'close' => '23:00'],
                'saturday' => ['open' => '09:00', 'close' => '23:00'],
                'sunday' => ['open' => '09:00', 'close' => '22:00'],
            ],
            'holidays' => [],
            'min_reservation_notice' => 60,
            'max_reservation_notice' => 43200,
            'max_guests_per_reservation' => 20,
            'is_active' => true,
        ]);

        return view('restaurants.settings.edit', compact('restaurant', 'settings'));
    }

    public function update(UpdateRestaurantSettingsRequest $request, Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);

        $settings = $restaurant->settings ?? new RestaurantSetting();
        $settings->fill($request->validated());
        $restaurant->settings()->save($settings);

        return redirect()
            ->route('restaurants.settings.edit', $restaurant)
            ->with('success', 'Restaurant settings updated successfully.');
    }
} 