<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    private $componentId;
    private $accountId;
    private $contactId;
    private $activityId;
    private $componentFormId;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->componentId = (string)Str::orderedUuid();
        $this->accountId = (string)Str::orderedUuid();
        $this->contactId = (string)Str::orderedUuid();
        $this->activityId = (string)Str::orderedUuid();
        $this->componentFormId = (string)Str::orderedUuid();

        $componentCategoryId = (string)Str::orderedUuid();
        $exampleCategoryId = (string)Str::orderedUuid();
        $setupCategoryId = (string)Str::orderedUuid();

        $data = [
            [
                "id" => $componentCategoryId,
                "name" => "Component UI",
                "url" => null,
                "icon" => null,
                "position" => 1,
                "route_name" => null,
                "parent_id" => null,
                "category" => true,
                "category_id" => null
            ],
            [
                "id" => $this->componentId,
                "name" => "Component",
                "url" => "",
                "icon" => "bx bx-component",
                "position" => 2,
                "route_name" => null,
                "parent_id" => null,
                "category" => false,
                "category_id" => $componentCategoryId
            ],
            [
                "id" => $exampleCategoryId,
                "name" => "Example App",
                "url" => null,
                "icon" => null,
                "position" => 3,
                "route_name" => null,
                "parent_id" => null,
                "category" => true,
                "category_id" => null
            ],
            [
                "id" => $this->accountId,
                "name" => "Account",
                "url" => null,
                "icon" => "bx bx-buildings",
                "position" => 4,
                "route_name" => null,
                "parent_id" => null,
                "category" => false,
                "category_id" => $exampleCategoryId,
            ],
            [
                "id" => $this->contactId,
                "name" => "Contact",
                "url" => null,
                "icon" => "bx bxs-user-account",
                "position" => 5,
                "route_name" => null,
                "parent_id" => null,
                "category" => false,
                "category_id" => $exampleCategoryId
            ],
            [
                "id" => $this->activityId,
                "name" => "Activity",
                "url" => null,
                "icon" => "bx bx-calendar",
                "position" => 6,
                "route_name" => null,
                "parent_id" => null,
                "category" => false,
                "category_id" => $exampleCategoryId
            ],
            [
                "id" => $setupCategoryId,
                "name" => "Setup",
                "url" => null,
                "icon" => null,
                "position" => 7,
                "route_name" => null,
                "parent_id" => null,
                "category" => true,
                "category_id" => null
            ],
            [
                "id" => (string)Str::orderedUuid(),
                "name" => "Menu",
                "url" => "/setup/menu",
                "icon" => "bx bx-menu",
                "position" => 8,
                "route_name" => "setup.menu",
                "parent_id" => null,
                "category" => false,
                "category_id" => $setupCategoryId
            ],
            [
                "id" => (string)Str::orderedUuid(),
                "name" => "Access Right",
                "url" => "/setup/access-right",
                "icon" => "bx bx-accessibility",
                "position" => 9,
                "route_name" => "setup.access_right",
                "parent_id" => null,
                "category" => false,
                "category_id" => $setupCategoryId
            ],
            [
                "id" => (string)Str::orderedUuid(),
                "name" => "Lookup",
                "url" => "/setup/lookup",
                "icon" => "bx bx-data",
                "position" => 10,
                "route_name" => "setup.lookup",
                "parent_id" => null,
                "category" => false,
                "category_id" => $setupCategoryId
            ],
            [
                "id" => (string)Str::orderedUuid(),
                "name" => "User",
                "url" => "/setup/user",
                "icon" => "bx bx-user",
                "position" => 11,
                "route_name" => "setup.user",
                "parent_id" => null,
                "category" => false,
                "category_id" => $setupCategoryId
            ],
        ];
        DB::table('menu')->insert($data);

        $this->component_menu();
        $this->form_menu();
        $this->account_menu();
        $this->contact_menu();
        $this->activity_menu();
    }

    protected function component_menu(): void
    {
        $data = [
            [
                "id" => (string)Str::orderedUuid(),
                "name" => "Button",
                "url" => "/components/button",
                "icon" => "bx bxs-component",
                "position" => 1,
                "route_name" => "components.button",
                "parent_id" => $this->componentId
            ],
            [
                "id" => $this->componentFormId,
                "name" => "Form",
                "url" => null,
                "icon" => null,
                "position" => 2,
                "route_name" => null,
                "parent_id" => $this->componentId
            ],
            [
                "id" => (string)Str::orderedUuid(),
                "name" => "Table",
                "url" => "/components/table",
                "icon" => null,
                "position" => 3,
                "route_name" => "components.table",
                "parent_id" => $this->componentId
            ],
            [
                "id" => (string)Str::orderedUuid(),
                "name" => "Attachment",
                "url" => "/components/attachment",
                "icon" => null,
                "position" => 4,
                "route_name" => "components.attachment",
                "parent_id" => $this->componentId
            ],
            [
                "id" => (string)Str::orderedUuid(),
                "name" => "Notes",
                "url" => "/components/notes",
                "icon" => null,
                "position" => 5,
                "route_name" => "components.notes",
                "parent_id" => $this->componentId
            ],
            [
                "id" => (string)Str::orderedUuid(),
                "name" => "Stages",
                "url" => "/components/stages",
                "icon" => null,
                "position" => 6,
                "route_name" => "components.stages",
                "parent_id" => $this->componentId
            ],
            [
                "id" => (string)Str::orderedUuid(),
                "name" => "Calendar",
                "url" => "/components/calendar",
                "icon" => null,
                "position" => 7,
                "route_name" => "components.calendar",
                "parent_id" => $this->componentId
            ],
            [
                "id" => (string)Str::orderedUuid(),
                "name" => "Others",
                "url" => "/components/others",
                "icon" => null,
                "position" => 8,
                "route_name" => "components.others",
                "parent_id" => $this->componentId
            ]
        ];
        DB::table('menu')->insert($data);
    }

    protected function form_menu(): void
    {
        $data = [
            [
                "id" => (string)Str::orderedUuid(),
                "name" => "Input text",
                "url" => "/components/form/input",
                "icon" => null,
                "position" => 1,
                "route_name" => "components.form.input",
                "parent_id" => $this->componentFormId
            ],
            [
                "id" => (string)Str::orderedUuid(),
                "name" => "Select and Combobox",
                "url" => "/components/form/select-combobox",
                "icon" => null,
                "position" => 2,
                "route_name" => "components.form.select_combobox",
                "parent_id" => $this->componentFormId
            ],
            [
                "id" => (string)Str::orderedUuid(),
                "name" => "Checkbox and Radio",
                "url" => "/components/form/checkbox-radio",
                "icon" => null,
                "position" => 3,
                "route_name" => "components.form.checkbox_radio",
                "parent_id" => $this->componentFormId
            ],
            [
                "id" => (string)Str::orderedUuid(),
                "name" => "Date Picker",
                "url" => "/components/form/date-picker",
                "icon" => null,
                "position" => 4,
                "route_name" => "components.form.date_picker",
                "parent_id" => $this->componentFormId
            ],
            [
                "id" => (string)Str::orderedUuid(),
                "name" => "Field",
                "url" => "/components/form/field",
                "icon" => null,
                "position" => 5,
                "route_name" => "components.form.field",
                "parent_id" => $this->componentFormId
            ],
            [
                "id" => (string)Str::orderedUuid(),
                "name" => "Form",
                "url" => "/components/form/form",
                "icon" => null,
                "position" => 6,
                "route_name" => "components.form.form",
                "parent_id" => $this->componentFormId
            ],
        ];
        DB::table('menu')->insert($data);
    }

    protected function account_menu(): void
    {
        $data = [
            [
                "id" => (string)Str::orderedUuid(),
                "name" => "List",
                "url" => "/exampla/account/list",
                "icon" => null,
                "position" => 1,
                "route_name" => "example.account.list",
                "parent_id" => $this->accountId
            ],
            [
                "id" => (string)Str::orderedUuid(),
                "name" => "Edit page",
                "url" => "/example/account/edit-page",
                "icon" => null,
                "position" => 2,
                "route_name" => "example.account.edit_page",
                "parent_id" => $this->accountId
            ]
        ];
        DB::table('menu')->insert($data);
    }

    protected function contact_menu(): void
    {
        $data = [
            [
                "id" => (string)Str::orderedUuid(),
                "name" => "List",
                "url" => "/example/contact/list",
                "icon" => null,
                "position" => 1,
                "route_name" => "example.contact.list",
                "parent_id" => $this->contactId
            ],
            [
                "id" => (string)Str::orderedUuid(),
                "name" => "Edit page",
                "url" => "/example/contact/edit-page",
                "icon" => null,
                "position" => 2,
                "route_name" => "example.contact.edit_page",
                "parent_id" => $this->contactId
            ]
        ];
        DB::table('menu')->insert($data);
    }

    protected function activity_menu(): void
    {
        $data = [
            [
                "id" => (string)Str::orderedUuid(),
                "name" => "List",
                "url" => "/example/activity/list",
                "icon" => null,
                "position" => 1,
                "route_name" => "example.activity.list",
                "parent_id" => $this->activityId
            ],
            [
                "id" => (string)Str::orderedUuid(),
                "name" => "Edit page",
                "url" => "/example/activity/edit-page",
                "icon" => null,
                "position" => 2,
                "route_name" => "example.activity.edit_page",
                "parent_id" => $this->activityId
            ]
        ];
        DB::table('menu')->insert($data);
    }
}
