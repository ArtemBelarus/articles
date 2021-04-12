<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'number' => 'sometimes|max:128',
            'code_type' => 'sometimes|in:original_codes,related_numbers,eans',
            'code_value' => 'sometimes|max:128',
        ];
    }
}
