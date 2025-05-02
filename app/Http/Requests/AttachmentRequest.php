<?php

namespace App\Http\Requests;

class AttachmentRequest extends BaseFormRequest
{
    public function rules(): array
    {
        $rules = [
            'param_name' => 'required|string',
            'table_name' => 'required|string',
            'record_id' => 'required|uuid',
        ];

        return $rules;
    }
}