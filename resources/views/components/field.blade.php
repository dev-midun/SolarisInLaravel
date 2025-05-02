@props([
    "id" => null,
    "bind" => null,
    "label" => "",
    "required" => false,
    "disabled" => false,
    "hidden" => false,
    "message" => "",
    "error" => false,
    "valid" => false,
    "horizontal" => false,
    "lazy" => false
])

@php
    if(!empty($id) && empty($bind) && str_contains($id, ":")) {
        $splitId = explode(":", $id);
        $id = $splitId[0];
        $bind = $splitId[1];
    }

    $labelAttrs = new \Illuminate\View\ComponentAttributeBag(
        collect($attributes->whereStartsWith('label:')->all())
            ->mapWithKeys(fn($value, $key) => [Str::after($key, 'label:') => $value])
            ->all()
    );
    $labelAttrs = $labelAttrs->toArray();

    $fieldAttrs = new \Illuminate\View\ComponentAttributeBag(
        collect($attributes->whereStartsWith('field:')->all())
            ->mapWithKeys(fn($value, $key) => [Str::after($key, 'field:') => $value])
            ->all()
    );
    $fieldAttrs = $fieldAttrs->merge([
        "solar-id" => $id,
        "solar-ui" => "field",
        "solar-bind" => !empty($bind) ? $bind : $id,
        "required" => $required === true,
        "disabled" => $disabled === true,
        "lazy" => $lazy === true
    ])
    ->class([
        "mb-3", 
        "row" => $horizontal === true,
        "d-none" => $hidden === true
    ]);

    $messageAttrs = new \Illuminate\View\ComponentAttributeBag(
        collect($attributes->whereStartsWith('message:')->all())
            ->mapWithKeys(fn($value, $key) => [Str::after($key, 'message:') => $value])
            ->all()
    );
    $messageAttrs = $messageAttrs->toArray();
@endphp

<div {{ $fieldAttrs }}>
    <x-label 
        for="{{ $id }}" 
        :horizontal="$horizontal"
        :attribute="$labelAttrs" 
        :required="$required">
        {{ $label }}
    </x-label>

    @if ($horizontal === true)
    <div class="col-sm-9">
    @endif
    
    {{ $slot }}

    @if ($horizontal === true)
    
    <x-message-feedback 
        id="{{ $id }}-message"
        :error="$error"
        :valid="$valid">
        {{ $message }}
    </x-message-feedback>
    </div>

    @else
    
    <x-message-feedback 
        id="{{ $id }}-message"
        :error="$error"
        :valid="$valid">
        {{ $message }}
    </x-message-feedback>
    
    @endif
</div>