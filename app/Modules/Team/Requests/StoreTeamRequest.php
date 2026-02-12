<?php

namespace App\Modules\Team\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This runs BEFORE validation.
     */
    public function authorize(): bool
    {
        // Safety check: user must be logged in
        if (!auth()->check()) {
            return false;
        }

        // Only Super Admin can create teams
        return auth()->user()->role->name === 'super_admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * This runs ONLY if authorize() returns true.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',

            // Team lead is optional at creation time
            'team_lead_id' => 'nullable|exists:users,id',
        ];
    }

    /**
     * Custom validation error messages.
     *
     * Optional but very useful.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Team name is required.',
            'name.string'   => 'Team name must be a valid string.',
            'name.max'      => 'Team name cannot exceed 255 characters.',

            'team_lead_id.exists' => 'Selected team lead does not exist.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * Runs BEFORE rules().
     */
    protected function prepareForValidation(): void
    {
        // Trim team name (clean input)
        if ($this->has('name')) {
            $this->merge([
                'name' => trim($this->name),
            ]);
        }
    }
}
