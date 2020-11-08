<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreAnnouncementRequest extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'max:200'],
            'description' => ['required', 'max:1000'],
            'price' => ['required', 'int', 'min:0'],
            'images' => ['required', 'array', 'min:1', 'max:3'],
            'images.*' => ['url']
        ];
    }
}
