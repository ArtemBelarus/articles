<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEanRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'value' => 'required|max:128',
        ];
    }
}
