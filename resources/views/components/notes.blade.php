@props([
    "id",
    "bind" => null,
    "value" => null,
    "lazy" => false,
    "ignore" => false
])

@php
    if(!empty($id) && empty($bind) && str_contains($id, ":")) {
        $splitId = explode(":", $id);
        $id = $splitId[0];
        $bind = $splitId[1];
    }
@endphp

<div id="{{ $id }}" value="{{ $value }}" {{ 
    $attributes->merge([
        "lazy" => $lazy === true, 
        "ignore" => $ignore === true,
        "solar-ui" => "notes",
        "solar-bind" => !empty($bind) ? $bind : $id,
    ]) 
}}></div>