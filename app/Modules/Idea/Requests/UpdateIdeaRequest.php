<?php

namespace App\Modules\Idea\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIdeaRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Policy will decide
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'impact_level' => 'required|in:low,medium,high',
            'swot' => 'nullable|string|max:2000',
            'attachments' => 'nullable|array|max:5',
            'attachments.*' => 'file|max:51200|mimes:jpg,jpeg,png,mp4,mov,avi,pdf,doc,docx,xls,xlsx|max:10240',
        ];
    }
}
