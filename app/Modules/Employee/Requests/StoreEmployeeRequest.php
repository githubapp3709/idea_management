<?php

namespace App\Modules\Employee\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // later we can add policy check
    }

    public function rules(): array
    {
        return [
            'employee_code' => 'nullable|string|max:50|unique:users,employee_code',

            'name' => 'required|string|max:255',

            'email' => 'required|email|max:255|unique:users,email',

            'password' => 'nullable|min:6',

            'status' => 'required|in:active,inactive',

            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Full name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Enter valid email address.',
            'email.unique' => 'This email already exists.',
            'employee_code.unique' => 'Employee code already exists.',
            'profile_image.image' => 'Uploaded file must be an image.',
            'profile_image.max' => 'Image must not exceed 5MB.',
        ];
    }
}
