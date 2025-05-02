@props([
    "menus" => [] // ["name", "url", "icon", "route_name", "sub_menu", "category"]
])

@php
    $logoAttrs = new \Illuminate\View\ComponentAttributeBag(
        collect($attributes->whereStartsWith('logo:')->all())
            ->mapWithKeys(fn($value, $key) => [Str::after($key, 'logo:') => $value])
            ->all()
    );
    $logoAttrs = $logoAttrs->toArray();

    $logo_desktop = $logoAttrs["desktop"] ?? Vite::asset('resources/assets/images/logo/solaris-white-logo.png');
    $logo_toggle = $logoAttrs["toggle"] ?? Vite::asset('resources/assets/images/logo/solaris-logo-only.png');
    $logo_white = $logoAttrs["white"] ?? Vite::asset('resources/assets/images/logo/solaris-white-logo.png');
    $logo_toggleWhite = $logoAttrs["toggle-white"] ?? Vite::asset('resources/assets/images/logo/solaris-logo-only.png');
    $logo_dark = $logoAttrs["dark"] ?? Vite::asset('resources/assets/images/logo/solaris-dark-logo.png');
    $logo_toggleDark = $logoAttrs["toggle-dark"] ?? Vite::asset('resources/assets/images/logo/solaris-logo-only.png');
@endphp

<aside class="app-sidebar sticky" id="sidebar">
    <div class="main-sidebar-header">
        <a href="index.html" class="header-logo">
            <img src="{{ $logo_desktop }}" alt="logo" class="desktop-logo">
            <img src="{{ $logo_toggle }}" alt="logo" class="toggle-logo">
            <img src="{{ $logo_white }}" alt="logo" class="desktop-white">
            <img src="{{ $logo_toggleWhite }}" alt="logo" class="toggle-white">
            <img src="{{ $logo_dark }}" alt="logo" class="desktop-dark">
            <img src="{{ $logo_toggleDark }}" alt="logo" class="toggle-dark">
        </a>
    </div>

    <div class="main-sidebar" id="sidebar-scroll">

        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> </svg>
            </div>

            <ul class="main-menu">
                <x-sidebar-menu :menus="$menus" />
            </ul>

            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg>
            </div>
        </nav>
        
    </div>

</aside>