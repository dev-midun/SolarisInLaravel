@props([
    "menus" => [] // ["id", "name", "url", "icon", "route_name", "sub_menu", "category"]
])
@aware(['__level'])
@php
    $__level = isset($__level) ? $__level + 1 : 1;
    $currentRouteName = Route::currentRouteName();
@endphp

@foreach ($menus as $menu)
    @php
        if($menu instanceof \Illuminate\Support\Collection || $menu instanceof \App\Models\Menu) {
            $menu = $menu->toArray();
        } else if(is_object($menu)) {
            $menu = (array)$menu;
        }

        $hasSubmenu = !empty($menu['sub_menu']);
        $active = \App\Models\Menu::isActive($menu, $currentRouteName);
        $submenuActive = false;
        if($hasSubmenu) {
            $submenuActive = \App\Models\Menu::subMenuIsActive($menu['sub_menu'], $currentRouteName);
        }
    @endphp

    @if ($menu["category"] ?? false)
        <li class="slide__category"><span class="category-name">{{ $menu["name"] }}</span></li>
    @else
        @if (!$hasSubmenu)
            <x-sidebar-menu-item :url="empty($menu['url']) ? null : $menu['url']" :name="$menu['name']" :icon="$menu['icon']" :active="$active" :root="empty($menu['parent_id'])" />
        @else
            <x-sidebar-menu-item :url="empty($menu['url']) ? null : $menu['url']" :name="$menu['name']" :icon="$menu['icon']" submenu :active="$submenuActive" :root="empty($menu['parent_id'])">
                <ul class="slide-menu child{{ $__level }}">
                    <x-sidebar-menu :menus="$menu['sub_menu']" :__level="$__level" />
                </ul>
            </x-sidebar-menu-item>
        @endif
    @endif
@endforeach