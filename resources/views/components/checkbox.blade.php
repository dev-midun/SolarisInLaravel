@props([
    "id",
    "name" => null,
    "label" => null,
    "size" => null, // md, lg
    "outline" => false,
    "color" => "primary", // primary, secondary, success, danger, info, light, dark,
    "square" => false,
    "inline" => false,
    "switch" => false,
    "reverse" => false,
    "checked" => false,
    "hidden" => false,
    "lazy" => false
])

@php
    $inputAttr = $attributes
        ->class([
            "form-check-input",
            "form-checked-outline" => $outline === true && $switch === false,
            "form-checked-{$color}" => !is_null($color) && in_array($color, ["primary", "secondary", "success", "danger", "info", "light", "dark"]),
            "rounded-0" => $square === true,
        ])
        ->merge([
            "role" => $switch === true ? "switch" : null,
            "solar-ui" => "input:checkbox",
            "lazy" => $lazy === true,
            "checked" => $checked === true,
            "name" => !is_null($name)
        ])
        ->except(["id", "type"]);

    $wrapAttr = new \Illuminate\View\ComponentAttributeBag(
        collect($attributes->whereStartsWith('wrap:')->all())
            ->mapWithKeys(fn($value, $key) => [Str::after($key, 'wrap:') => $value])
            ->all()
    );
    $wrapAttr = $wrapAttr->class([
        "form-check",
        "form-switch" => $switch === true,
        "form-check-inline" => $inline === true,
        "form-check-{$size}" => !is_null($size) && in_array($size, ["md", "lg"]),
        "form-check-reverse" => $reverse === true,
        "d-none" => $hidden === true,
    ]);
@endphp

<div {{ $wrapAttr }}>
    <input {{ $inputAttr }} type="checkbox" id="{{ $id }}">
    @if (!is_null($label))
    <label class="form-check-label" for="{{ $id }}">{{ $label }}</label>
    @endif
</div>