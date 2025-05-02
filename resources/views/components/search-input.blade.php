@props([
    "attribute" => [],
    "size" => null,
    "hidden" => false
]) 

@php
    $wrapAttr = new \Illuminate\View\ComponentAttributeBag(["class" => "custom-form-group"]);
    $wrapAttr = $wrapAttr->class([
        "d-none" => $hidden === true,
    ]);
@endphp

<div {{ $wrapAttr }}>
    <x-input 
        :attribute="$attributes->merge($attribute)->toArray()" 
        solar-ui="input:search" class="pe-5" size="{{ $size }}"/>
    <a href="javascript:void(0);" class="custom-form-btn text-muted">
        <i class="ri-close-line align-middle reset-search d-none"></i>
        <i class="ri-search-line align-middle do-search"></i>
    </a>
</div>