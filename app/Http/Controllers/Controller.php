<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

abstract class Controller
{
    public function cleanData(Request $request): array
    {
        $rules = array_keys($request->rules());
        return Arr::map($request->only($rules), fn($value, $key) => $request->{$key});
    }
}