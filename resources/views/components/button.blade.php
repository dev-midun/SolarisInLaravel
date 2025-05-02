@props([
    "type" => "button",
    "variant" => "default", // default, outline, ghost, light, gradient, link
    "size" => "md", // xs, sm, md, lg
    "color" => "primary", // primary, secondary, success, danger, info, light, dark,
    "rounded" => false,
    "square" => false,
    "icon" => false,
    "ignore" => false
])

<button {{ 
    $attributes->merge([
        "type" => $type,
        "solar-ui" => "button",
        "ignore" => $ignore === true
    ])
    ->class([
        "btn",
        "btn-wave",
        "btn-{$color}" => strtolower($variant) == "default",
        "btn-{$color}-light" => strtolower($variant) == "light",
        "btn-outline-{$color}" => strtolower($variant) == "outline",
        "btn-{$color}-gradient" => strtolower($variant) == "gradient",
        "btn-{$color}-ghost" => strtolower($variant) == "ghost",
        "btn-link" => strtolower($variant) == "link",
        "btn-icon" => $icon === true,
        "btn-{$size}" => $size != "md",
        "rounded-pill" => $rounded === true && $square === false,
        "rounded-0" => $rounded === false && $square === true
    ]) 
}}>
    {{ $slot }}
</button>