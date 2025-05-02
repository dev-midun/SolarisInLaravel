@props([
    "url" => "javascript:void(0)",
    "icon" => "",
    "name" => "",
    "submenu" => false,
    "active" => false,
    "root" => false
])

<li {{ 
    $attributes->class([
        "slide",
        "has-sub" => $submenu === true,
        "open" => $active === true
    ]) 
}}>
    <a href="{{ $url }}" class="side-menu__item {{ $active ? "active" : "" }}">
        @if ($submenu)
        <i class="ri-arrow-right-s-line side-menu__angle"></i>
        @endif

        @if (!empty($icon))
        <i class="{{ $icon }} w-6 h-6 side-menu__icon"></i>
        @endif
        
        @if ($root)
        <span class="side-menu__label">{{ $name }}</span>
        @else
        {{ $name }}
        @endif
    </a>
    {{ $slot }}
</li>