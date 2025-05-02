@props([
    'error' => false,
    'valid' => false,
    "attribute" => []
])

<div {{ 
    $attributes->class([
        'invalid-feedback' => $error === true && $valid === false,
        'valid-feedback' => $error === false && $valid === true
    ])
    ->merge($attribute)
}}>
    {{ $slot }}
</div>