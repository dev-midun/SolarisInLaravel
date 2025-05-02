<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as ParentFormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\File;

class BaseFormRequest extends ParentFormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            $errors = $validator->errors()->messages();
            $errorList = [];
            foreach ($errors as $key => $value) {
                $errorList[$key] = implode(" ", $value);
            }

            $response = [
                'success' => false,
                'message' => null,
                'errors' => $errorList,
            ];

            throw new HttpResponseException(response()->json($response, 200));
        } 

        parent::failedValidation($validator);
    }

    protected function pictureValidation(int $min = 1, int $max = 1024)
    {
        return ['nullable', File::image()->min($min)->max($max)];
    }
}