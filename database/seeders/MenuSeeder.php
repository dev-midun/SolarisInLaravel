<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\RoleHasMenu;

class MenuSeeder extends Seeder
{
    private $data = [];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->add(
            id: (string) Str::orderedUuid(),
            name: 'Home',
            url: '/',
            routeName: 'home',
            icon: 'ri-home-heart-line',
            position: 1
        );

        DB::table('menu')->insert($this->data);

        $this->supervisorRoleMenu();
        $this->adminRoleMenu();
        $this->userRoleMenu();
    }

    protected function supervisorMenu()
    {
        $this->add(
            id: (string) Str::orderedUuid(),
            name: 'Users',
            url: '/users',
            routeName: 'users',
            icon: 'menu-icon tf-icons ti ti-users-group',
            position: 2
        );
        $this->add(
            id: (string) Str::orderedUuid(),
            name: 'Payments',
            url: '/payments',
            routeName: 'payments',
            icon: 'menu-icon tf-icons ti ti-database-dollar',
            position: 3
        );
        $this->add(
            id: (string) Str::orderedUuid(),
            name: 'License',
            url: '/license',
            routeName: 'license',
            icon: 'menu-icon tf-icons ti ti-license',
            position: 4
        );
        $this->add(
            id: (string) Str::orderedUuid(),
            name: 'Lookups',
            url: '/lookups',
            routeName: 'lookups',
            icon: 'menu-icon tf-icons ti ti-database-search',
            position: 5
        );
        $this->add(
            id: (string) Str::orderedUuid(),
            name: 'Setups',
            url: '/setups',
            routeName: 'setups',
            icon: 'menu-icon tf-icons ti ti-settings-cog',
            position: 6
        );
    }

    protected function adminMenu()
    {
        $this->add(
            id: (string) Str::orderedUuid(),
            name: 'Home',
            url: '/admin',
            routeName: 'admin.home',
            icon: 'menu-icon tf-icons ti ti-home',
            position: 1
        );
        $this->add(
            id: (string) Str::orderedUuid(),
            name: 'Users',
            url: '/admin/users',
            routeName: 'admin.users',
            icon: 'menu-icon tf-icons ti ti-users-group',
            position: 2
        );
        $this->add(
            id: (string) Str::orderedUuid(),
            name: 'Billing & Plans',
            url: '/admin/billing',
            routeName: 'admin.billing',
            icon: 'menu-icon tf-icons ti ti-cash-register',
            position: 3
        );
    }

    protected function userMenu()
    {
        $this->add(
            id: (string) Str::orderedUuid(),
            name: 'Accounts',
            url: '/accounts',
            routeName: 'accounts',
            icon: 'menu-icon tf-icons ti ti-buildings',
            position: 2
        );
        $this->add(
            id: (string) Str::orderedUuid(),
            name: 'Contacts',
            url: '/contacts',
            routeName: 'contacts',
            icon: 'menu-icon tf-icons ti ti-user',
            position: 3
        );
        $this->add(
            id: (string) Str::orderedUuid(),
            name: 'Products',
            url: '/products',
            routeName: 'products',
            icon: 'menu-icon tf-icons ti ti-packages',
            position: 4
        );
        $this->add(
            id: (string) Str::orderedUuid(),
            name: 'Leads',
            url: '/leads',
            routeName: 'leads',
            icon: 'menu-icon tf-icons ti ti-users',
            position: 5
        );
        $this->add(
            id: (string) Str::orderedUuid(),
            name: 'Opportunities',
            url: '/opportunities',
            routeName: 'opportunities',
            icon: 'menu-icon tf-icons ti ti-target-arrow',
            position: 6
        );
        $this->add(
            id: (string) Str::orderedUuid(),
            name: 'Activities',
            url: '/activities',
            routeName: 'activities',
            icon: 'menu-icon tf-icons ti ti-calendar-time',
            position: 7
        );
    }
    
    protected function supervisorRoleMenu()
    {
        $role = Role::findByName('Supervisor');
        
        $routes = ['home', 'users', 'payments', 'license', 'lookups', 'setups'];
        $menu = Menu::select('id')->whereIn('route_name', $routes)->get();
        foreach ($menu as $value) {
            RoleHasMenu::create([
                'role_id' => $role->id,
                'menu_id' => $value->id
            ]);
        }
    }

    protected function adminRoleMenu()
    {
        $role = Role::findByName('Admin');
        
        $routes = ['admin.home', 'admin.users', 'admin.billing'];
        $menu = Menu::select('id')->whereIn('route_name', $routes)->get();
        foreach ($menu as $value) {
            RoleHasMenu::create([
                'role_id' => $role->id,
                'menu_id' => $value->id
            ]);
        }
    }

    protected function userRoleMenu()
    {
        $role = Role::findByName('User');
        
        $routes = ['home', 'accounts', 'contacts', 'products', 'leads', 'opportunities', 'activities'];
        $menu = Menu::select('id')->whereIn('route_name', $routes)->get();
        foreach ($menu as $value) {
            RoleHasMenu::create([
                'role_id' => $role->id,
                'menu_id' => $value->id
            ]);
        }
    }

    protected function add($id, $name, $url, $icon, $routeName = null, $position = null, $parent_id = null)
    {
        $position = !isset($position) ? count($this->data) : $position;
        $this->data[] = [
            'id' => $id,
            'name' => $name,
            'url' => $url,
            'icon' => $icon,
            'position' => $position,
            'route_name' => $routeName,
            'parent_id' => $parent_id
        ];
    }
}
