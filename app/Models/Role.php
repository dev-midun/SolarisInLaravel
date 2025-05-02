<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasUuids;

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'role_has_menu', 'role_id', 'menu_id');
    }
}
