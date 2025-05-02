<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleHasMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->roles();
        $this->permission();
        $this->adminRole();
        $this->userRole();
    }

    protected function roles(): void
    {
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'User']);
    }

    protected function permission(): void
    {
        $permissions = [
            "components.button",
            "components.form.input",
            "components.form.select_combobox",
            "components.form.checkbox_radio",
            "components.form.date_picker",
            "components.form.field",
            "components.form.form",
            "components.table",
            "components.attachment",
            "components.notes",
            "components.stages",
            "components.calendar",
            "components.others",
            "example.account.list",
            "example.account.edit_page",
            "example.contact.list",
            "example.contact.edit_page",
            "example.activity.list",
            "example.activity.edit_page",
            "setup.menu",
            "setup.access_right",
            "setup.lookup",
            "setup.user",
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }

    protected function adminRole(): void
    {
        $role = Role::findByName('Admin');
        foreach (Permission::all() as $value) {
            $role->givePermissionTo($value->name);
        }
        
        $menus = Menu::validMenu()->orderBy('position', 'asc')->get();
        foreach ($menus as $menu) {
            RoleHasMenu::create([
                'role_id' => $role->id,
                'menu_id' => $menu->id
            ]);
        }
    }

    protected function userRole(): void
    {
        $role = Role::findByName('User');
        $permissions = Permission::where('name', 'like', 'components.%')
            ->orWhere('name', 'like', 'example.%')
            ->get();
        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission->name);
        }

        $menus = Menu::validMenu()
            ->where(fn($query) => $query->where('route_name', 'like', 'components.%')->orWhere('route_name', 'like', 'example.%'))
            ->orderBy('position', 'asc')
            ->get();
        foreach ($menus as $menu) {
            RoleHasMenu::create([
                'role_id' => $role->id,
                'menu_id' => $menu->id
            ]);
        }
    }
}
