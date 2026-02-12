<?php

namespace App\Modules\Idea\Requests;

use Illuminate\Foundation\Http\FormRequest;


class StoreIdeaRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'nullable|string|max:100',
            'impact_level' => 'required|in:low,medium,high',
        ];
    }
}
