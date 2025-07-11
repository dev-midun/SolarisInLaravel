<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class LookupModel extends BaseModel
{
    public $isLookup = true;
    public static $orderBy = "position";
    public static $direction = "asc";
    public static $displayValue = 'name';
    protected $defaultSelectColumn = ['id', 'name', 'position'];
    protected $defaultWhereColumn = ['name'];
    
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'position' => 'integer',
        ]);
    }

    public function scopeToLookup(Builder $query)
    {
        return $query->defaultOrder()->get()->map(function($item) {
            $item->id = $item->id;
            // $item->name = $item->{static::$displayValue};
            $item->name = $item->getDisplayValue();
            
            return $item;
        })
        ->toArray();
    }

    public function scopeToSelect(Builder $query)
    {
        return $query->defaultOrder()->get()->map(function($item) {
            $item->value = $item->id;
            // $item->text = $item->{static::$displayValue};
            $item->text = $item->getDisplayValue();
            
            return $item;
        })
        ->toArray();
    }

    public function scopeToLookupPagination(Builder $query, $page, $length)
    {
        return $query->paginate($length, ['*'], 'page', $page)
            ->through(function($item) {
                $item->id = $item->id;
                $item->name = $item->getDisplayValue();

                return $item;
            });
    }

    public function scopeToRadio(Builder $query, ?string $checked = null)
    {
        return $query->get()->map(function($item) use($checked) {
            $newItem = (object)[];
            $newItem->id = $item->id;
            // $newItem->label = $item->{static::$displayValue};
            $newItem->label = $item->getDisplayValue();

            if($checked == $newItem->id) {
                $newItem->checked = true;
            }
            
            return $newItem;
        });
    }

    public function scopeToStage(Builder $query, bool|array|string $confirm = false)
    {
        $parentStage = $query->defaultSelect()
            ->whereNull('group_id')
            ->orderBy('position', 'asc')
            ->get();

        $isConfirmAll = is_bool($confirm);
        $isSpecificConfirm = Str::isUuid($confirm);
        $isArrayConfirm = is_array($confirm);

        return $this->getStageMenu($parentStage, $confirm)
            ->map(function($item) use($confirm, $isConfirmAll, $isSpecificConfirm, $isArrayConfirm) {
                $_confirm = false;
                if($isConfirmAll) {
                    $_confirm = $confirm;
                } else if($isSpecificConfirm) {
                    $_confirm = $confirm == $item->id ? true : false;
                } else if($isArrayConfirm) {
                    $_confirm = in_array($item->id, $confirm);
                }

                $item->confirm = $_confirm;

                unset($item->group, $item->group_id);
                if(!is_null($item->menu)) {
                    $menu = [];
                    $menu[] = [
                        'id' => $item->id,
                        'name' => $item->name,
                        'color' => $item->color,
                        'confirm' => $_confirm
                    ];

                    foreach ($item->menu as $value) {
                        unset($value->group, $value->group_id, $value->position, $value->menu);
                        $menu[] = $value->toArray();
                    }

                    unset($item->menu);
                    $item->menu = $menu;
                }

                return $item;
            })
            ->toArray();
    }

    protected function getStageMenu($parentStage)
    {
        $group = collect([]);

        foreach ($parentStage as $stage) {
            $menu = self::getStageMenu($stage->menu);
            $stage->menu = $menu->isNotEmpty() ? $menu : null;
            $group->push($stage);
        }

        return $group;
    }
}
