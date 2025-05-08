<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_restaurants' => Restaurant::count(),
            'total_users' => User::count(),
            'total_reservations' => Reservation::count(),
            'total_reviews' => Review::count(),
            'recent_reviews' => Review::with(['user', 'restaurant'])->latest()->take(5)->get(),
        ];

        // رزروهای اخیر
        $recentReservations = Reservation::with(['user', 'restaurant'])
            ->latest()
            ->take(5)
            ->get();

        // رزروها در 7 روز گذشته
        $reservations_by_day = Reservation::select(
            DB::raw('DATE(reservation_date) as date'),
            DB::raw('count(*) as total')
        )
            ->where('reservation_date', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // رزروها به تفکیک ماه
        $monthlyReservations = Reservation::select(
            DB::raw('MONTH(reservation_date) as month'),
            DB::raw('count(*) as total')
        )
            ->whereYear('reservation_date', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // وضعیت رزروها
        $reservations_by_status = Reservation::select(
            'status',
            DB::raw('count(*) as total')
        )
            ->groupBy('status')
            ->get();

        // کاربران جدید
        $new_users = User::latest()
            ->take(5)
            ->get();

        // رستوران‌های پربازدید
        $popular_restaurants = Restaurant::withCount('reservations')
            ->orderByDesc('reservations_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'reservations_by_day',
            'reservations_by_status',
            'recentReservations',
            'new_users',
            'popular_restaurants',
            'monthlyReservations'
        ));
    }
} 
        return view('admin.dashboard', compact(
            'stats',
            'reservations_by_day',
            'reservations_by_status',
            'recentReservations',
            'new_users',
            'popular_restaurants',
            'monthlyReservations'
        ));
    }