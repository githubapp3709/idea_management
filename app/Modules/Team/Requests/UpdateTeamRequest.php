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
        ];
    }
}
