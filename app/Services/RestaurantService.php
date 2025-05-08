<?php

namespace App\Services;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RestaurantService
{
    /**
     * Get all active restaurants with pagination
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getActiveRestaurants(int $perPage = 10): LengthAwarePaginator
    {
        return Restaurant::where('is_active', true)
            ->with(['tables' => function ($query) {
                $query->where('is_available', true);
            }])
            ->paginate($perPage);
    }

    /**
     * Get available tables for a restaurant on a specific date and time
     *
     * @param Restaurant $restaurant
     * @param string $date
     * @param string $time
     * @return Collection
     */
    public function getAvailableTables(Restaurant $restaurant, string $date, string $time): Collection
    {
        return $restaurant->tables()
            ->where('is_available', true)
            ->whereDoesntHave('reservations', function ($query) use ($date, $time) {
                $query->where('reservation_date', $date)
                    ->where('reservation_time', $time)
                    ->where('status', '!=', 'cancelled');
            })
            ->get();
    }
} 