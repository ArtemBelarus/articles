<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'number' => 'required|max:128|unique:articles,number,' . $this->route('article'),
        ];
    }
}
