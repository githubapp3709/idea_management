<?php

namespace App\Modules\Employee\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')->id;

        return [
            'employee_code' => 'nullable|string|max:50|unique:users,employee_code,' . $userId,
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $userId,
            'password' => 'nullable|min:6',
            'status' => 'required|in:active,inactive',
            'team_id' =>'nullable|numeric',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        ];
    }
}
