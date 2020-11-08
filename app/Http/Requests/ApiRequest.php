<?php


namespace App\Http\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class ApiRequest extends FormRequest
{

    protected function failedValidation(Validator $validator)
    {
        return response()->json(['status' => 'validation_error', 'errors' => $validator->errors()])->setStatusCode(422)->throwResponse();
    }

}
