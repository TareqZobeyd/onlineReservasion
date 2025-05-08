<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RestaurantManagementController as AdminRestaurantController;
use App\Http\Controllers\Admin\UserManagementController as AdminUserController;
use App\Http\Controllers\Admin\ReservationManagementController as AdminReservationController;
use App\Http\Controllers\Admin\ReviewManagementController as AdminReviewController;
use App\Http\Controllers\Restaurant\DashboardController as RestaurantDashboardController;
use App\Http\Controllers\Restaurant\MenuController as RestaurantMenuController;
use App\Http\Controllers\Restaurant\ReservationController as RestaurantReservationController;
use App\Http\Controllers\Restaurant\MenuItemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // روت‌های رستوران‌ها
    Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
    Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show'])->name('restaurants.show');
    Route::get('/restaurants/{restaurant}/check-availability', [RestaurantController::class, 'showAvailability'])->name('restaurants.show-availability');
    Route::post('/restaurants/{restaurant}/check-availability', [RestaurantController::class, 'checkAvailability'])->name('restaurants.check-availability');

    // روت‌های رزرو
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    // روت‌های ادمین
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('restaurants', AdminRestaurantController::class);
        Route::resource('users', AdminUserController::class);
        Route::resource('reservations', AdminReservationController::class);
        Route::resource('reviews', AdminReviewController::class);
    });

    // روت‌های رستوران
    Route::prefix('restaurant')->name('restaurant.')->group(function () {
        Route::get('/create', [RestaurantController::class, 'create'])->name('create');
        Route::post('/store', [RestaurantController::class, 'store'])->name('store');
        Route::get('/dashboard', [RestaurantDashboardController::class, 'index'])->name('dashboard');
        Route::resource('menus', RestaurantMenuController::class);
        Route::resource('menu-items', MenuItemController::class);
        Route::resource('reservations', RestaurantReservationController::class);
        Route::get('/reservations', [RestaurantReservationController::class, 'index'])->name('reservations.index');
        Route::get('/reservations/{reservation}', [RestaurantReservationController::class, 'show'])->name('reservations.show');
        Route::patch('/reservations/{reservation}/status', [RestaurantReservationController::class, 'updateStatus'])->name('reservations.update-status');
        Route::get('/reservations/calendar', [RestaurantReservationController::class, 'calendar'])->name('reservations.calendar');
    });
});

require __DIR__.'/auth.php';
