<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $trip = $this->route('trip');

        return [
            'participants_count' => [
                'required',
                'integer',
                'min:1',
                'max:' . ($trip ? $trip->available_slots : 10)
            ],
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'participants_count.required' => 'Number of participants is required.',
            'participants_count.min' => 'Minimum 1 participant.',
            'participants_count.max' => 'Not enough slots available.',
        ];
    }
}