@props([
    "attribute" => [],
    "hidden" => false
]) 

@php
    $wrapAttr = new \Illuminate\View\ComponentAttributeBag(["class" => "position-relative"]);
    $wrapAttr = $wrapAttr->class([
        "d-none" => $hidden === true,
    ]);
@endphp

<div {{ $wrapAttr }}>
    <x-input 
        :attribute="$attributes->merge($attribute)->toArray()" 
        type="password"
        solar-ui="input:password"
        :placeholder="html_entity_decode('&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;')" />
    <a href="javascript:void(0);" class="show-password-button text-muted">
        <i class="ri-eye-line align-middle"></i>
    </a>
</div>