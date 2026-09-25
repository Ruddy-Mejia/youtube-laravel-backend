<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommentsRequest extends FormRequest
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
            'body' => ['required', 'string', 'max:500'],
        ];
    }
}
