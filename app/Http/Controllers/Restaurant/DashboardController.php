<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        if (!auth()->user()->hasRole('restaurant_owner')) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        $restaurant = auth()->user()->restaurant;
        
        if (!$restaurant) {
            return view('restaurant.no-restaurant');
        }

        // آمار کلی
        $stats = [
            'total_reservations' => $restaurant->reservations()->count(),
            'today_reservations' => $restaurant->reservations()
                ->whereDate('reservation_date', Carbon::today())
                ->count(),
            'pending_reservations' => $restaurant->reservations()
                ->where('status', 'pending')
                ->count(),
            'average_rating' => $restaurant->reviews()->avg('rating') ?? 0,
        ];

        // رزروهای اخیر
        $recentReservations = $restaurant->reservations()
            ->with(['user', 'table'])
            ->latest()
            ->take(5)
            ->get();

        // منوهای فعال
        $activeMenus = $restaurant->menus()
            ->where('is_active', true)
            ->withCount('items')
            ->get();

        // رزروها در 7 روز گذشته
        $reservations_by_day = $restaurant->reservations()
            ->select(
                DB::raw('DATE(reservation_date) as date'),
                DB::raw('count(*) as total')
            )
            ->where('reservation_date', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // رزروها به تفکیک ماه
        $monthlyReservations = $restaurant->reservations()
            ->select(
                DB::raw('MONTH(reservation_date) as month'),
                DB::raw('count(*) as total')
            )
            ->whereYear('reservation_date', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // وضعیت رزروها
        $reservations_by_status = $restaurant->reservations()
            ->select(
                'status',
                DB::raw('count(*) as total')
            )
            ->groupBy('status')
            ->get();

        return view('restaurant.dashboard', compact(
            'restaurant',
            'stats',
            'recentReservations',
            'reservations_by_day',
            'reservations_by_status',
            'monthlyReservations',
            'activeMenus'
        ));
    }
}
