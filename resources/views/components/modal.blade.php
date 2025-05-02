@props([
    "id",
    "static" => false,
    "fullscreen" => false,
    "size" => null, // xl, lg, sm
    "center" => false,
    "animation" => null, // scale, slide-in-right, slide-in-bottom, newspaper, fall, flip-horizontal, flip-vertical, super-scaled, sign, rotate-bottom, rotate-left
    "title" => null,
    "close" => true
])

@php
    $headerAttr = new \Illuminate\View\ComponentAttributeBag(
        collect($attributes->whereStartsWith('header:')->all())
            ->mapWithKeys(fn($value, $key) => [Str::after($key, 'header:') => $value])
            ->all()
    );
    $headerAttr = $headerAttr->class(["modal-header"]);

    $bodyAttr = new \Illuminate\View\ComponentAttributeBag(
        collect($attributes->whereStartsWith('body:')->all())
            ->mapWithKeys(fn($value, $key) => [Str::after($key, 'body:') => $value])
            ->all()
    );
    $bodyAttr = $bodyAttr->class(["modal-body"]);

    $modalDialogAttr = new \Illuminate\View\ComponentAttributeBag(["class" => "modal-dialog"]);
    $modalDialogAttr = $modalDialogAttr->class([
        "modal-fullscreen" => $fullscreen === true,
        "modal-{$size}" => !is_null($size) && in_array($size, ["sm", "lg", "xl"]),
        "modal-dialog-centered" => $center === true
    ]);
@endphp

<div {{ 
    $attributes->class([
        "modal",
        "fade",
        "effect-{$animation}" => !is_null($animation) && in_array($animation, ["scale", "slide-in-right", "slide-in-bottom", "newspaper", "fall", "flip-horizontal", "flip-vertical", "super-scaled", "sign", "rotate-bottom", "rotate-left"])
    ])
    ->merge([
        "id" => $id,
        "solar-ui" => "modal",
        "tabindex" => "-1",
        "aria-labelledby" => "{$id}Label",
        "aria-modal" => "true",
        "role" => "dialog",
        "data-bs-backdrop" => $static === true ? "static" : null,
        "data-bs-keyboard" => $static === true ? "false" : null,
    ]) 
}}>
    <div {{ $modalDialogAttr }}>
        <div class="modal-content">

            @if (isset($header))
            <div {{ $header->attributes->class(['modal-header']) }}>
                {{ $header }}
            </div>
            @else

            <div {{ $headerAttr }}>
                @if (!empty($title))
                <h6 class="modal-title" id="{{ $id }}_title">{{ $title }}</h6>
                @endif

                @if ($close === true)
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                @endif
            </div>

            @endif

            <div {{ $bodyAttr }}>
                {{ $slot }}
            </div>

            @if (isset($footer))
            <div {{ $footer->attributes->class(['modal-footer']) }}>
                {{ $footer }}
            </div>
            @endif
        </div> 
    </div> 
</div>