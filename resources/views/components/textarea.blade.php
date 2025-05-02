@props([
    "size" => null, // sm, lg
    "rounded" => false,
    "square" => false,
    "hidden" => false,
    "value" => "",
    "attribute" => [],
    "lazy" => false
])

<textarea {{
    $attributes->merge([
        "solar-ui" => "textarea",
        "lazy" => $lazy === true
    ])
    ->merge($attribute)
    ->class([
        "form-control",
        "form-control-{$size}" => !is_null($size) && in_array($size, ["sm", "lg"]),
        "rounded-pill" => $rounded === true && $square === false,
        "rounded-0" => $rounded === false && $square === true,
        "d-none" => $hidden === true
    ])
}}>{{ $value }}</textarea>