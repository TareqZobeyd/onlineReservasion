<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'phone_number',
        'cuisine_type',
        'price_range',
        'opening_time',
        'closing_time',
        'average_rating',
        'has_outdoor',
        'has_private',
        'has_parking',
        'image_url',
        'is_active',
        'has_delivery',
        'has_takeout',
        'has_reservation',
        'has_wifi',
        'has_outdoor_seating',
        'is_vegetarian_friendly',
        'is_vegan_friendly',
        'is_gluten_free_friendly',
        'user_id',
    ];

    protected $casts = [
        'opening_time' => 'datetime',
        'closing_time' => 'datetime',
        'average_rating' => 'decimal:2',
        'has_outdoor' => 'boolean',
        'has_private' => 'boolean',
        'has_parking' => 'boolean',
        'is_active' => 'boolean',
        'has_delivery' => 'boolean',
        'has_takeout' => 'boolean',
        'has_reservation' => 'boolean',
        'has_wifi' => 'boolean',
        'has_outdoor_seating' => 'boolean',
        'is_vegetarian_friendly' => 'boolean',
        'is_vegan_friendly' => 'boolean',
        'is_gluten_free_friendly' => 'boolean',
    ];

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }

    public function tables(): HasMany
    {
        return $this->hasMany(Table::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('status', 'approved');
    }

    public function calculateAverageRating(): void
    {
        $this->average_rating = $this->reviews()->avg('rating') ?? 0;
        $this->save();
    }

    public function getAverageFoodRating(): float
    {
        return $this->reviews()->avg('food_rating') ?? 0;
    }

    public function getAverageServiceRating(): float
    {
        return $this->reviews()->avg('service_rating') ?? 0;
    }

    public function getAverageAmbianceRating(): float
    {
        return $this->reviews()->avg('ambiance_rating') ?? 0;
    }

    public function getImageUrlAttribute($value)
    {
        if ($value) {
            // حذف 'restaurants/' از ابتدای مسیر اگر وجود داشته باشد
            $value = str_replace('restaurants/', '', $value);
            return asset('images/restaurants/' . $value);
        }

        // اگر عکس در دیتابیس ذخیره نشده باشد، یک عکس پیش‌فرض برمی‌گردانیم
        $defaultImages = [
            'istockphoto-1412465061-1024x1024.jpg',
            'istockphoto-1491469220-612x612.jpg',
            'istockphoto-1454553265-612x612.jpg',
            'istockphoto-655607216-612x612.jpg',
            'gettyimages-1158191245-612x612.jpg',
            'NzDGyPgjXKO5DDVav3.jpeg',
        ];

        return asset('images/restaurants/' . $defaultImages[array_rand($defaultImages)]);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 