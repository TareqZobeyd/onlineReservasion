<?php

namespace App\Http\Requests\Restaurant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRestaurantSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->id === $this->route('restaurant')->user_id;
    }

    public function rules(): array
    {
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        return [
            'working_hours' => ['required', 'array'],
            'working_hours.*' => ['required', 'array'],
            'working_hours.*.open' => ['required', 'date_format:H:i'],
            'working_hours.*.close' => ['required', 'date_format:H:i', 'after:working_hours.*.open'],
            'holidays' => ['nullable', 'array'],
            'holidays.*' => ['date', 'after_or_equal:today'],
            'min_reservation_notice' => ['required', 'integer', 'min:0'],
            'max_reservation_notice' => ['required', 'integer', 'min:0', 'gt:min_reservation_notice'],
            'max_guests_per_reservation' => ['required', 'integer', 'min:1'],
            'is_active' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'working_hours.*.close.after' => 'The closing time must be after the opening time.',
            'holidays.*.after_or_equal' => 'Holiday dates must be today or later.',
            'max_reservation_notice.gt' => 'The maximum reservation notice must be greater than the minimum notice.',
        ];
    }
} 