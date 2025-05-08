<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'number',
        'capacity',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function isAvailable(string $date, string $time): bool
    {
        return !$this->reservations()
            ->where('reservation_date', $date)
            ->where('reservation_time', $time)
            ->where('status', '!=', 'cancelled')
            ->exists();
    }
} 