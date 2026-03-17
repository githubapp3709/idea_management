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
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:20480',

            'videos' => 'nullable|array|max:2',
            'videos.*' => 'file|mimes:mp4,mov,avi|max:91200',

        ];
    }
}
