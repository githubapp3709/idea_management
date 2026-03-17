<?php

namespace App\Modules\Team\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeamRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->role->name === 'super_admin';
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'team_lead_id' => 'nullable|exists:users,id',
            'members' => 'required|array',
            'members.*' => 'exists:users,id',
            'leader_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        ];
    }

    public function messages(): array
    {
        return [

            'leader_id.required' => 'Choose Team Lead among the members',
            'name.required' => 'Team name is required.',
            'name.string'   => 'Team name must be a valid string.',
            'name.max'      => 'Team name cannot exceed 255 characters.',
            'team_lead_id.exists' => 'Selected team lead does not exist.',
        ];
    }
}
