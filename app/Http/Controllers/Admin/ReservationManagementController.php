<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with(['user', 'restaurant', 'table'])
            ->when($request->filled('restaurant_id'), function ($query) use ($request) {
                return $query->where('restaurant_id', $request->restaurant_id);
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->when($request->filled('date_from'), function ($query) use ($request) {
                return $query->where('reservation_date', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($query) use ($request) {
                return $query->where('reservation_date', '<=', $request->date_to);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                return $query->where(function ($q) use ($request) {
                    $q->whereHas('user', function ($q) use ($request) {
                        $q->where('name', 'like', "%{$request->search}%")
                          ->orWhere('email', 'like', "%{$request->search}%");
                    })
                    ->orWhereHas('restaurant', function ($q) use ($request) {
                        $q->where('name', 'like', "%{$request->search}%");
                    });
                });
            });

        $reservations = $query->latest()->paginate(10);
        $restaurants = Restaurant::all();

        return view('admin.reservations.index', compact('reservations', 'restaurants'));
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['user', 'restaurant', 'table']);
        return view('admin.reservations.show', compact('reservation'));
    }

    public function updateStatus(Request $request, Reservation $reservation)
    {
        $request->validate([
            'status' => 'required|in:confirmed,cancelled',
            'reason' => 'required_if:status,cancelled|string|max:255',
        ]);

        DB::transaction(function () use ($reservation, $request) {
            $reservation->update([
                'status' => $request->status,
                'cancellation_reason' => $request->reason,
            ]);

            // Notify user about the status change
            // TODO: Implement notification system
        });

        return redirect()
            ->route('admin.reservations.show', $reservation)
            ->with('success', 'Reservation status updated successfully.');
    }
} 