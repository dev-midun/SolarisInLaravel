@props([
    "size" => null, // sm, lg
    "rounded" => false,
    "square" => false,
    "hidden" => false,
    "attribute" => [],
    "lazy" => false,
    "number" => false,
    "numeric" => false,
    "thousand_separator" => ".",
    "decimal_separator" => ",",
    "decimal" => 0,
    "uppercase" => false,
    "lowercase" => false,
    "prefix" => null,
    "credit_card" => null,
    "phone" => null,
    "blocks" => null,
    "delimiters" => null
])

@php
    $isNumber = $number === true;
    $isPhoneNumber = isset($phone) && !empty($phone) ? true : false;
    $isCreditCard = $credit_card === true;
    $isNumeric = $numeric === true;
    
    $isCanNumber = $isNumber && !$isPhoneNumber && !$isCreditCard && !$isNumeric;
    $isCanPhoneNumber = $isPhoneNumber && !$isNumber && !$isCreditCard && !$isNumeric;
    $isCanCreditCard = $isCreditCard && !$isNumber && !$isPhoneNumber && !$isNumeric;
    $isCanNumeric = $isNumeric && !$isCreditCard && !$isNumber && !$isPhoneNumber;
    $isCanPrefix = !$isPhoneNumber && !$isCreditCard && !empty($prefix);
    $isCanUpper = $uppercase === true && $lowercase === false;
    $isCanLower = $lowercase === true && $uppercase === false;
    $isCanBlocks = !$isNumber && !$isPhoneNumber && !$isCreditCard && !empty($blocks);
    $isCanDelimiters = !$isNumber && !$isPhoneNumber && !empty($delimiters);
@endphp

<input {{
    $attributes->merge([
        "type" => "text",
        "solar-ui" => "input",
        "lazy" => $lazy === true,
        "mask" => $isNumber || $uppercase === true || $lowercase === true || $isPhoneNumber || $isCreditCard || !empty($blocks) || !empty($delimiters),
        "number" => $isCanNumber,
        "thousand-separator" => $isCanNumber && !empty($thousand_separator) ? $thousand_separator : null,
        "decimal-separator" => $isCanNumber && !empty($decimal_separator) ? $decimal_separator : null,
        "decimal" => $isCanNumber && isset($decimal) ? $decimal : null,
        "uppercase" => $isCanUpper,
        "lowercase" => $isCanLower,
        "prefix" => $isCanPrefix ? $prefix : null,
        "credit-card" => $isCanCreditCard,
        "phone" => $isCanPhoneNumber ? (is_string($phone) ? $phone : (is_bool($phone) ? "ID" : null)) : null,
        "blocks" => $isCanBlocks ? $blocks : null,
        "delimiters" => $isCanDelimiters ? $delimiters : null,
        "numeric" => $isCanNumeric
    ])
    ->merge($attribute)
    ->class([
        "form-control",
        "form-control-{$size}" => !is_null($size) && in_array($size, ["sm", "lg"]),
        "rounded-pill" => $rounded === true && $square === false,
        "rounded-0" => $rounded === false && $square === true,
        "d-none" => $hidden === true
    ])
}}>