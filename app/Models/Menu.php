<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Menu extends LookupModel
{
    protected $table = 'menu';
    protected $defaultSelectColumn = ['id', 'name', 'url', 'route_name', 'icon', 'position'];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Menu::class, 'category_id', 'id');
    }

    public function sub_menu()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_has_menu', 'menu_id', 'role_id');
    }

    public function scopeValidMenu(Builder $query): void
    {
        $query->whereNotNull('route_name')
            ->whereNotNull('url')
            ->where('category', false)
            ->where('url', '<>', '');
    }

    public static function getAll()
    {
        $categories = self::where("category", true)->orderBy("position", "asc")->get();
        $menus = self::with("parent")
            ->where("category", false)
            ->orderBy("position", "asc")
            ->get();

        $hierarchy = self::buildHierarchy($menus);
        $allMenus = collect([]);
        foreach ($categories as $category) {
            $allMenus->push($category);
            $allMenus = $allMenus->merge($hierarchy->where("category_id", $category->id));
        }

        $allMenus = $allMenus->merge($hierarchy->whereNull("category_id"));

        return $allMenus;
    }

    protected static function buildHierarchy($menus, $parentId = null): Collection
    {
        return $menus
            ->where('parent_id', $parentId)
            ->map(function ($menu) use ($menus) {
                $sub_menu = self::buildHierarchy($menus, $menu->id);
                $menu->sub_menu = $sub_menu->isNotEmpty() ? $sub_menu : null;

                return $menu;
            })
            ->values();
    }

    protected static function isActive($menu, $routeName)
    {
        if($menu instanceof \Illuminate\Support\Collection || $menu instanceof \App\Models\Menu) {
            $menu = $menu->toArray();
        } else if(is_object($menu)) {
            $menu = (array)$menu;
        }

        return !empty($menu['route_name']) && $menu['route_name'] === $routeName;
    }

    protected static function subMenuIsActive($subMenu, $routeName)
    {
        foreach ($subMenu as $sub) {
            if (self::isActive($sub, $routeName)) {
                return true;
            }

            if (!empty($sub['sub_menu']) && self::subMenuIsActive($sub['sub_menu'], $routeName)) {
                return true;
            }
        }

        return false;
    }
}
