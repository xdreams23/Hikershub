<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TripRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mountain_id' => 'required|exists:mountains,id',
            'title' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'duration_days' => 'required|integer|min:1',
            'meeting_point' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'max_participants' => 'required|integer|min:1',
            'min_participants' => 'required|integer|min:1|lte:max_participants',
            'status' => 'required|in:open,full,closed,cancelled',
            'itinerary' => 'nullable|string',
            'include_items' => 'nullable|string',
            'exclude_items' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'mountain_id.required' => 'Please select a mountain.',
            'mountain_id.exists' => 'Selected mountain does not exist.',
            'start_date.after_or_equal' => 'Start date must be today or future date.',
            'end_date.after' => 'End date must be after start date.',
            'min_participants.lte' => 'Minimum participants cannot exceed maximum participants.',
        ];
    }
}