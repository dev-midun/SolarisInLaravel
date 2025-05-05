@props([
    "size" => null, // sm, lg
    "rounded" => false,
    "square" => false,
    "hidden" => false,
    "options" => [], // [['text' => '', 'value' => '', 'selected' => false, 'disabled' => false]]
    "attribute" => [],
    "placeholder" => null,
    "multiple" => false,
    "lookup" => false,
    "value" => null, // json string
    "source" => null, // lookup model
    "pagination" => false,
    "lazy" => false,
    "ignore" => false,
    "dropdown_parent" => null,
    "extend_columns" => null
])

<select {{ 
    $attributes->merge([
        "solar-ui" => $multiple === true && $lookup === false ? "select:multiple" : ($lookup === false ? "select" : "select:lookup"),
        "multiple" => $multiple === true,
        "square" => $rounded === true && $square === false && $lookup === true,
        "rounded" => $rounded === false && $square === true && $lookup === true,
        "hidden" => $hidden === true && $lookup === true,
        "placeholder" => $lookup === true ? $placeholder : null,
        "value" => $lookup === true ? $value : null,
        "source" => $lookup === true ? $source : null,
        "pagination" => $lookup === true && $pagination === true && !is_null($source),
        "lazy" => $lazy === true,
        "ignore" => $ignore === true,
        "dropdown-parent" => !is_null($dropdown_parent) ? $dropdown_parent : null,
        "extend-columns" => !empty($extend_columns) ? $extend_columns : null,
    ])
    ->merge($attribute)
    ->class([
        "form-select",
        "form-select-{$size}" => !is_null($size) && in_array($size, ["sm", "lg"]) && $lookup === false,
        "rounded-pill" => $rounded === true && $square === false && $lookup === false,
        "rounded-0" => $rounded === false && $square === true && $lookup === false,
        "d-none" => $hidden === true && $lookup === false
    ])
}}>
    @if ($lookup === false)
    @php
        $isNotSelected = count(array_filter($options, fn($option) => is_array($option) ? $option['selected'] ?? false : $option->selected ?? false)) === 0;
    @endphp
    <option value="" {{ $isNotSelected && $multiple === false ? "selected" : "" }} {{ $multiple === true ? "disabled" : "" }}>{{ empty($placeholder) ? ($multiple === true ? "Choose multiple" : "Choose one") : $placeholder }}</option>
    @endif
    
    @if (is_null($source))
    
        @foreach ($options as $option)
            @php
                $_value = is_array($option) ? $option['value'] ?? '' : $option->value ?? '';
                $text = is_array($option) ? $option['text'] ?? '' : $option->text ?? '';
                $selected = is_array($option) ? $option['selected'] ?? false : $option->selected ?? false;
                
                if(!is_null($value) && $value == $_value) {
                    $selected = true;
                }
            @endphp
            <option value="{{ $_value }}" {{ $selected ? "selected" : "" }}>{{ $text }}</option>
        @endforeach

    @endif

</select>