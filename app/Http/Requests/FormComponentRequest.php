<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;

class FormComponentRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'birthdate' => 'required|date_format:Y-m-d',
            'gender' => 'required|uuid',
            'religion' => 'required|uuid',
            'password' => [
                'required', 
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'active' => 'nullable|boolean'
        ];
    }
}