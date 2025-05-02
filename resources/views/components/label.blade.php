@props([
    "required" => false,
    "horizontal" => false,
    "attribute" => []
])

<label {{ 
    $attributes->class([
        "form-label" => $horizontal === false,
        "col-sm-3 col-form-label" => $horizontal === true
    ])
    ->merge($attribute)
}}>
    {{ $slot }}
    @if($required)
    <span class="text-danger">*</span>
    @endif
</label>