@props([
    "id",
    "circle" => true,
    "rounded" => false,
    "square" => false,
    "size" => null, // sm, lg
    "source" => null, // image id
    "upload_to" => null,
    "param_name" => "profile_picture",
    "max" => 1,
    "preview" => true,
    "preview_width" => null,
    "preview_height" => null
])

@php
    $style = "rounded-circle";
    if($circle === false && $rounded === true && $square === false) {
        $style = "rounded";
    } else if($circle === false && $rounded === false && $square === true) {
        $style = "rounded-0";
    }

    $dummyImg = Vite::asset('resources/assets/images/user-dummy-img.jpg');
    $imgSrc = $dummyImg;
    $isImgAttachment = false;
    if(!empty($source) && \Illuminate\Support\Str::isUuid($source)) {
        $imgSrc = route('images.thumbnail', ['id' => $source]);
        $isImgAttachment = true;
    } else if(!empty($source)) {
        $imgSrc = $source;
    }

    $isPreview = $preview === true && !is_null($preview_width) && !is_null($preview_height) && $isImgAttachment;
@endphp

<div id="{{ $id }}" class="profile-picture" solar-ui="profile-picture">

    @if ($isPreview)
    <a href="{{ route('images', ['id' => $source]) }}" data-pswp-width="{{ $preview_width }}" data-pswp-height="{{ $preview_height }}" target="_blank">
    @endif

    <img src="{{ $imgSrc }}" class="{{ $style }} {{ in_array($size, ['sm', 'lg']) ? 'profile-picture-'.$size : '' }} img-thumbnail" alt="profile-picture">
    
    @if ($isPreview)
    </a>    
    @endif

    <div class="p-0 {{ $style }} profile-picture-upload">
        <input id="{{ $id }}_input" type="file" accept="image/png, image/jpeg" upload-to="{{ $upload_to }}" max="{{ $max }}" param-name="{{ $param_name }}">
        <label for="{{ $id }}_input">
            <span class="{{ $style }} bg-light text-body">
                <i class="ri-camera-fill"></i>
            </span>
        </label>
    </div>
</div>