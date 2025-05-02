@props([
    "id",
    "value" => null,
    "lazy" => false,
    "ignore" => false
])

<div id="{{ $id }}" solar-ui="notes" value="{{ $value }}" {{ $attributes->merge(["lazy" => $lazy === true, "ignore" => $ignore === true]) }}></div>