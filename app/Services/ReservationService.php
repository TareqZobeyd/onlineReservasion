<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\Table;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationService
{
    /**
     * Create a new reservation
     */
    public function create(array $data): Reservation
    {
        $restaurant = Restaurant::findOrFail($data['restaurant_id']);
        $table = Table::findOrFail($data['table_id']);

        // بررسی ساعات کاری رستوران
        $reservationTime = Carbon::parse($data['reservation_time']);
        $openingTime = Carbon::parse($restaurant->opening_time);
        $closingTime = Carbon::parse($restaurant->closing_time);

        if ($reservationTime->lt($openingTime) || $reservationTime->gt($closingTime)) {
            throw new \Exception('رستوران در این ساعت باز نیست.');
        }

        // بررسی موجودی میز
        $isTableAvailable = $table->isAvailable(
            $data['reservation_date'],
            $data['reservation_time']
        );

        if (!$isTableAvailable) {
            throw new \Exception('این میز در زمان انتخاب شده رزرو شده است.');
        }

        // ایجاد رزرو
        return Reservation::create([
            'user_id' => Auth::id(),
            'restaurant_id' => $data['restaurant_id'],
            'table_id' => $data['table_id'],
            'reservation_date' => $data['reservation_date'],
            'reservation_time' => $data['reservation_time'],
            'number_of_guests' => $data['number_of_guests'],
            'status' => 'pending'
        ]);
    }

    /**
     * Cancel a reservation
     */
    public function cancel(Reservation $reservation): bool
    {
        if ($reservation->status === 'cancelled') {
            throw new \Exception('این رزرو قبلاً لغو شده است.');
        }

        $reservation->status = 'cancelled';
        return $reservation->save();
    }

    /**
     * Get user's active reservations
     */
    public function getUserActiveReservations()
    {
        return Reservation::where('user_id', Auth::id())
            ->where('status', '!=', 'cancelled')
            ->where('reservation_date', '>=', Carbon::today())
            ->orderBy('reservation_date')
            ->orderBy('reservation_time')
            ->paginate(10);
    }
} 