<?php

namespace App\Modules\Idea\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewIdeaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'action' => 'required|in:approve,reject,send_back',
            'remark' => 'required_if:action,reject,send_back|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'remark.required_if' => 'Remark is required for reject or send back.',
        ];
    }
}
