<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        $stats = [
            'total_restaurants' => Restaurant::count(),
            'total_users' => User::count(),
            'total_reservations' => Reservation::count(),
            'total_reviews' => 0, // اگر مدل Review دارید، اینجا اضافه کنید
            'recent_reviews' => collect([]), // فعلاً خالی
        ];

        $recentReservations = Reservation::with(['user', 'restaurant'])
            ->latest()
            ->take(5)
            ->get();

        $reservations_by_day = Reservation::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total')
        )
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $reservations_by_status = Reservation::select(
            'status',
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('status')
            ->get();

        $monthlyReservations = Reservation::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();

        $popular_restaurants = Restaurant::withCount('reservations')
            ->orderByDesc('reservations_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentReservations',
            'reservations_by_day',
            'reservations_by_status',
            'monthlyReservations',
            'popular_restaurants'
        ));
    }

    public function restaurants()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        $restaurants = Restaurant::with('user')->paginate(10);
        return view('admin.restaurants.index', compact('restaurants'));
    }

    public function users()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        $users = User::with('restaurant')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function reservations()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        $reservations = Reservation::with(['user', 'restaurant'])->paginate(10);
        return view('admin.reservations.index', compact('reservations'));
    }
} 