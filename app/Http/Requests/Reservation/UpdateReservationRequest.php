<?php

namespace App\Http\Requests\Reservation;

use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->id === $this->route('reservation')->user_id;
    }

    public function rules(): array
    {
        return [
            'table_id' => [
                'sometimes',
                'exists:tables,id',
                Rule::exists('tables', 'id')->where(function ($query) {
                    return $query->where('restaurant_id', $this->route('reservation')->restaurant_id)
                        ->where('is_available', true);
                }),
            ],
            'reservation_date' => ['sometimes', 'date', 'after_or_equal:today'],
            'reservation_time' => ['sometimes', 'date_format:H:i'],
            'number_of_guests' => [
                'sometimes',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    $table = Table::find($this->input('table_id', $this->route('reservation')->table_id));
                    if ($table && $value > $table->capacity) {
                        $fail('The number of guests exceeds the table capacity.');
                    }
                },
            ],
            'meal_type' => ['sometimes', 'string', Rule::in(array_keys(Reservation::MEAL_TYPES))],
        ];
    }
} 