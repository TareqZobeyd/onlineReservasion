<?php

namespace App\Http\Controllers;

use App\Http\Requests\Restaurant\CheckAvailabilityRequest;
use App\Models\Restaurant;
use App\Services\RestaurantService;
use Illuminate\View\View;
use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RestaurantController extends Controller
{
    public function __construct(
        private readonly RestaurantService $restaurantService
    ) {}

    /**
     * Display a listing of active restaurants
     */
    public function index(Request $request): View
    {
        $query = Restaurant::query();

        // جستجو
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('cuisine_type', 'like', "%{$search}%");
            });
        }

        // فیلتر نوع غذا
        if ($request->has('cuisine') && $request->cuisine !== '') {
            $query->where('cuisine_type', $request->cuisine);
        }

        // فیلتر امتیاز
        if ($request->has('rating') && $request->rating !== '') {
            $query->where('average_rating', '>=', $request->rating);
        }

        // فیلتر قیمت
        if ($request->has('price_range') && $request->price_range !== '') {
            $query->where('price_range', $request->price_range);
        }

        // فیلتر ویژگی‌ها
        if ($request->has('features')) {
            foreach ($request->features as $feature) {
                $query->where("has_{$feature}", true);
            }
        }

        // فیلتر تاریخ، ساعت و تعداد نفرات
        if ($request->filled('date') && $request->filled('time') && $request->filled('guests')) {
            $date = Carbon::parse($request->date);
            $time = Carbon::parse($request->time);
            $guests = $request->guests;

            $query->whereHas('tables', function ($query) use ($guests) {
                $query->where('capacity', '>=', $guests);
            })->whereDoesntHave('tables.reservations', function ($query) use ($date, $time) {
                $query->whereDate('reservation_date', $date)
                    ->whereTime('reservation_time', $time);
            });
        }

        $restaurants = $query->paginate(12);

        return view('restaurants.index', compact('restaurants'));
    }

    /**
     * Display the specified restaurant
     */
    public function show(Restaurant $restaurant): View
    {
        $restaurant->load('menus');
        return view('restaurants.show', compact('restaurant'));
    }

    /**
     * Show the availability check form
     */
    public function showAvailability(Restaurant $restaurant): View
    {
        return view('restaurants.availability-form', compact('restaurant'));
    }

    /**
     * Check table availability for a restaurant
     */
    public function checkAvailability(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'guests' => 'required|integer|min:1|max:20',
        ]);

        $date = Carbon::parse($request->date);
        $time = Carbon::parse($request->time);
        $guests = $request->guests;

        // بررسی ساعات کاری رستوران
        $openingTime = Carbon::parse($restaurant->opening_time);
        $closingTime = Carbon::parse($restaurant->closing_time);
        
        if ($time->lt($openingTime) || $time->gt($closingTime)) {
            return back()->with('error', 'رستوران در این ساعت باز نیست.');
        }

        // بررسی میزهای موجود
        $availableTables = $restaurant->tables()
            ->where('capacity', '>=', $guests)
            ->whereDoesntHave('reservations', function ($query) use ($date, $time) {
                $query->where('reservation_date', $date->format('Y-m-d'))
                    ->where('reservation_time', $time->format('H:i:s'))
                    ->where('status', '!=', 'cancelled');
            })
            ->get();

        if ($availableTables->isEmpty()) {
            return back()->with('error', 'متأسفانه در این تاریخ و ساعت میز خالی موجود نیست.');
        }

        // ذخیره اطلاعات در سشن برای استفاده در صفحه رزرو
        session([
            'reservation_date' => $date->format('Y-m-d'),
            'reservation_time' => $time->format('H:i'),
            'number_of_guests' => $guests,
            'restaurant_id' => $restaurant->id,
        ]);

        return view('restaurants.availability', [
            'restaurant' => $restaurant,
            'date' => $date->format('Y-m-d'),
            'time' => $time->format('H:i'),
            'guests' => $guests,
            'availableTables' => $availableTables
        ]);
    }

    public function create()
    {
        if (!auth()->user()->hasRole('restaurant_owner')) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        if (auth()->user()->restaurant) {
            return redirect()->route('restaurant.dashboard');
        }

        return view('restaurant.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasRole('restaurant_owner')) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        if (auth()->user()->restaurant) {
            return redirect()->route('restaurant.dashboard');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'phone_number' => 'required|string|max:20',
            'cuisine_type' => 'required|string|max:255',
            'price_range' => 'required|string|max:255',
            'opening_time' => 'required|date_format:H:i',
            'closing_time' => 'required|date_format:H:i',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('restaurants', 'public');
        }

        $restaurant = Restaurant::create([
            ...$validated,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('restaurant.dashboard')
            ->with('success', 'رستوران با موفقیت ایجاد شد.');
    }
} 