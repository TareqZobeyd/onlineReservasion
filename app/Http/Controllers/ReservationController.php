<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateReservationRequest;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Services\ReservationService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;

class ReservationController extends Controller
{
    public function __construct(
        private readonly ReservationService $reservationService
    ) {}

    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        try {
            $this->reservationService->update($reservation, $request->validated());
            
            return redirect()
                ->route('reservations.show', $reservation)
                ->with('success', 'Reservation updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function create()
    {
        if (!session()->has('reservation_date')) {
            return redirect()->route('home')->with('error', 'لطفاً ابتدا تاریخ و ساعت رزرو را انتخاب کنید.');
        }

        $restaurant = Restaurant::findOrFail(session('restaurant_id'));

        return view('reservations.create', [
            'restaurant' => $restaurant,
            'date' => session('reservation_date'),
            'time' => session('reservation_time'),
            'guests' => session('number_of_guests'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'table_id' => 'required|exists:tables,id',
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required',
            'number_of_guests' => 'required|integer|min:1|max:20',
        ]);

        try {
            $reservation = $this->reservationService->create($validated);
            return redirect()->route('reservations.show', $reservation)
                ->with('success', 'رزرو با موفقیت انجام شد.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Reservation $reservation)
    {
        $this->authorize('view', $reservation);

        return view('reservations.show', compact('reservation'));
    }

    public function cancel(Reservation $reservation)
    {
        try {
            $this->reservationService->cancel($reservation);
            return back()->with('success', 'رزرو با موفقیت لغو شد.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Reservation $reservation): RedirectResponse
    {
        // بررسی مالکیت رزرو
        if ($reservation->user_id !== auth()->id()) {
            abort(403, 'شما دسترسی به این رزرو را ندارید.');
        }

        // بررسی وضعیت رزرو
        if ($reservation->status !== 'pending') {
            return back()->with('error', 'فقط رزروهای در انتظار تایید قابل لغو هستند.');
        }

        $reservation->update([
            'status' => 'cancelled',
            'cancellation_reason' => 'لغو شده توسط کاربر'
        ]);

        return redirect()
            ->route('profile.edit')
            ->with('success', 'رزرو با موفقیت لغو شد.');
    }
} 