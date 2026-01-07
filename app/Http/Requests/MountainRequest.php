<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MountainRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $mountainId = $this->route('mountain') ? $this->route('mountain')->id : null;

        return [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'altitude' => 'required|integer|min:0',
            'difficulty_level' => 'required|in:easy,medium,hard,extreme',
            'description' => 'required|string',
            'facilities' => 'nullable|string',
            'image' => $mountainId ? 'nullable|image|mimes:jpeg,png,jpg|max:2048' : 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Mountain name is required.',
            'altitude.required' => 'Altitude is required.',
            'altitude.integer' => 'Altitude must be a number.',
            'difficulty_level.required' => 'Difficulty level is required.',
            'difficulty_level.in' => 'Invalid difficulty level.',
            'image.required' => 'Mountain image is required.',
            'image.image' => 'File must be an image.',
            'image.max' => 'Image size must not exceed 2MB.',
        ];
    }
}