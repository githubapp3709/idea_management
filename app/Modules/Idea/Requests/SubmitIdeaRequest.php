<?php

namespace App\Modules\Idea\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitIdeaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }
}
