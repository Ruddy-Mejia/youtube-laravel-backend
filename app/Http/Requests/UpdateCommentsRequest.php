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
            'video_id' => ['integer', 'exists:videos,id'],
            'comment_id' => ['integer', 'exists:comments,id'],
            'body' => ['sometimes', 'string', 'max:500'],
        ];
    }
}
