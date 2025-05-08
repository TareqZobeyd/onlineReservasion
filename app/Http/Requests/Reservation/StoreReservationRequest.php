<?php

namespace App\Http\Requests\Reservation;

use App\Models\Table;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'restaurant_id' => ['required', 'exists:restaurants,id'],
            'table_id' => [
                'required',
                'exists:tables,id',
                Rule::exists('tables', 'id')->where(function ($query) {
                    return $query->where('restaurant_id', $this->restaurant_id)
                        ->where('is_available', true);
                }),
            ],
            'reservation_date' => ['required', 'date', 'after_or_equal:today'],
            'reservation_time' => ['required', 'date_format:H:i'],
            'number_of_guests' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    $table = Table::find($this->table_id);
                    if ($table && $value > $table->capacity) {
                        $fail('The number of guests exceeds the table capacity.');
                    }
                },
            ],
        ];
    }
} 