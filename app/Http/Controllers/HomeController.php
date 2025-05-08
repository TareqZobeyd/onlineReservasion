<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $popularRestaurants = Restaurant::withCount('reservations')
            ->withAvg('reviews', 'rating')
            ->orderBy('reservations_count', 'desc')
            ->take(6)
            ->get();

        return view('home', compact('popularRestaurants'));
    }