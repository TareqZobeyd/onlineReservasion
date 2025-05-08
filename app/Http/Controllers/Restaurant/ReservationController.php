<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (!auth()->user()->hasRole('restaurant_owner')) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        $restaurant = auth()->user()->restaurant;
        
        if (!$restaurant) {
            return redirect()->route('restaurant.create')
                ->with('error', 'لطفا ابتدا رستوران خود را ثبت کنید.');
        }

        $reservations = $restaurant->reservations()
            ->with(['user', 'table'])
            ->latest()
            ->paginate(10);

        return view('restaurant.reservations.index', compact('reservations'));
    }

    public function show(Reservation $reservation): View|RedirectResponse
    {
        if (!auth()->user()->hasRole('restaurant_owner')) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        $restaurant = auth()->user()->restaurant;
        
        if (!$restaurant) {
            return redirect()->route('restaurant.create')
                ->with('error', 'لطفا ابتدا رستوران خود را ثبت کنید.');
        }

        if ($reservation->restaurant_id !== $restaurant->id) {
            abort(403, 'شما دسترسی به این رزرو را ندارید.');
        }

        $reservation->load(['user', 'table']);

        return view('restaurant.reservations.show', compact('reservation'));
    }

    public function updateStatus(Request $request, Reservation $reservation): RedirectResponse
    {
        if (!auth()->user()->hasRole('restaurant_owner')) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        $restaurant = auth()->user()->restaurant;
        
        if (!$restaurant) {
            return redirect()->route('restaurant.create')
                ->with('error', 'لطفا ابتدا رستوران خود را ثبت کنید.');
        }

        if ($reservation->restaurant_id !== $restaurant->id) {
            abort(403, 'شما دسترسی به این رزرو را ندارید.');
        }

        $validated = $request->validate([
            'status' => 'required|in:confirmed,cancelled,completed',
            'cancellation_reason' => 'required_if:status,cancelled|nullable|string|max:255',
        ]);

        $reservation->update($validated);

        return redirect()
            ->route('restaurant.reservations.show', $reservation)
            ->with('success', 'وضعیت رزرو با موفقیت بروزرسانی شد.');
    }

    public function calendar(): View|RedirectResponse
    {
        if (!auth()->user()->hasRole('restaurant_owner')) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        $restaurant = auth()->user()->restaurant;
        
        if (!$restaurant) {
            return redirect()->route('restaurant.create')
                ->with('error', 'لطفا ابتدا رستوران خود را ثبت کنید.');
        }

        $reservations = $restaurant->reservations()
            ->with(['user', 'table'])
            ->whereMonth('reservation_date', Carbon::now()->month)
            ->whereYear('reservation_date', Carbon::now()->year)
            ->get()
            ->groupBy(function ($reservation) {
                return Carbon::parse($reservation->reservation_date)->format('Y-m-d');
            });

        return view('restaurant.reservations.calendar', compact('reservations'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'table_id' => 'required|exists:tables,id',
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required|date_format:H:i',
            'number_of_guests' => 'required|integer|min:1|max:20',
        ]);

        // بررسی تکراری بودن رزرو
        $existingReservation = Reservation::where('table_id', $validated['table_id'])
            ->where('reservation_date', $validated['reservation_date'])
            ->where('reservation_time', $validated['reservation_time'])
            ->where('status', '!=', 'cancelled')
            ->first();

        if ($existingReservation) {
            return back()
                ->withInput()
                ->with('error', 'این میز در زمان انتخاب شده قبلاً رزرو شده است. لطفاً زمان دیگری را انتخاب کنید.');
        }

        $reservation = Reservation::create([
            'user_id' => auth()->id(),
            'restaurant_id' => $validated['restaurant_id'],
            'table_id' => $validated['table_id'],
            'reservation_date' => $validated['reservation_date'],
            'reservation_time' => $validated['reservation_time'],
            'number_of_guests' => $validated['number_of_guests'],
            'status' => 'pending',
        ]);

        return redirect()
            ->route('profile.edit')
            ->with('success', 'رزرو میز با موفقیت انجام شد. می‌توانید وضعیت رزرو خود را در پروفایل کاربری مشاهده کنید.');
    }
}
