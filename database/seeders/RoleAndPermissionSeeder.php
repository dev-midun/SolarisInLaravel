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
    private array $defaultAccess = ['create', 'read', 'update', 'delete'];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->roles();
        $this->permission();
        
        // $this->supervisorRole();
        // $this->adminRole();
        $this->userRole();
    }

    protected function roles(): void
    {
        Role::create(['name' => 'Supervisor']);
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'User']);
    }

    protected function permission(): void
    {
        $permissions = [
            "accounts", 
            "contacts",
            "products",
            "leads",
            "opportunities",
            "activities"
        ];

        foreach ($permissions as $permission) {
            foreach ($this->defaultAccess as $access) {
                Permission::create(['name' => "{$permission}.{$access}"]);
            }
        }
    }

    // protected function supervisorRole(): void
    // {
    //     $role = Role::findByName('Supervisor');
    // }

    // protected function adminRole(): void
    // {
    //     $role = Role::findByName('Admin');
    //     $permissions = [];
    //     foreach (Permission::all() as $value) {
    //         $role->givePermissionTo($value->name);
    //     }

    //     foreach ($menuForAdmin as $value) {
    //         RoleHasMenu::create([
    //             'role_id' => $role->id,
    //             'menu_id' => $value->id
    //         ]);
    //     }
    // }

    protected function userRole(): void
    {
        $role = Role::findByName('User');
        $permissions = [
            "accounts", 
            "contacts",
            "products",
            "leads",
            "opportunities",
            "activities"
        ];
        foreach ($permissions as $permission) {
            foreach ($this->defaultAccess as $access) {
                $role->givePermissionTo("{$permission}.{$access}");
            }
        }
    }
}
