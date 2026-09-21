<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 'video_id' => ['required', 'integer', 'exists:videos,id'],
            'body' => ['sometimes', 'string', 'max:500'],
        ];
    }
}
