@props([
    "mode" => "date", // date, datetime, time
    "range" => false,
    "lazy" => false,
    "attribute" => []
])

<x-input :attribute="$attributes->merge($attribute)->toArray()" solar-ui="input:{{ $mode }}" :lazy="$lazy" :range="$range" />