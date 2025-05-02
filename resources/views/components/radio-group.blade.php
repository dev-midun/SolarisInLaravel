@props([
    "name",
    "size" => null, // md, lg
    "outline" => false,
    "color" => "primary", // primary, secondary, success, danger, info, light, dark,
    "square" => false,
    "inline" => false,
    "reverse" => false,
    "options" => [], // [['label' => '', 'id' => '', 'checked' => false]]
    "hidden" => false,
    "disabled" => false,
    "lazy" => false
])

@php
    $wrapAttr = new \Illuminate\View\ComponentAttributeBag(
        collect($attributes->whereStartsWith('wrap:')->all())
            ->mapWithKeys(fn($value, $key) => [Str::after($key, 'wrap:') => $value])
            ->all()
    );
    $wrapAttr = $wrapAttr->merge([
        "solar-ui" => "input:radio-group",
        "lazy" => $lazy === true,
        "solar-id" => $name,
        "disabled" => $disabled === true
    ])
    ->class([
        "d-none" => $hidden === true
    ]);
@endphp

<div {{ $wrapAttr }}>
    @foreach ($options as $option)
        @php
            $id = is_array($option) ? $option['id'] ?? '' : $option->id ?? '';
            $label = is_array($option) ? $option['label'] ?? '' : $option->label ?? '';
            $checked = is_array($option) ? $option['checked'] ?? false : $option->checked ?? false;
        @endphp

        <x-radio 
            :name="$name"
            :id="$id"
            :label="$label"
            :size="$size"
            :outline="$outline"
            :square="$square"
            :inline="$inline"
            :reverse="$reverse"
            :checked="$checked"
            :lazy="$lazy"
        />
    @endforeach
</div>