<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

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
            $item->name = $item->{static::$displayValue};
            
            return $item;
        })
        ->toArray();
    }

    public function scopeToSelect(Builder $query)
    {
        return $query->defaultOrder()->get()->map(function($item) {
            $item->value = $item->id;
            $item->text = $item->{static::$displayValue};
            
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
            $newItem->label = $item->{static::$displayValue};

            if($checked == $newItem->id) {
                $newItem->checked = true;
            }
            
            return $newItem;
        });
    }

    public function scopeToStage(Builder $query)
    {
        $parentStage = $query->defaultSelect()
            ->whereNull('group_id')
            ->orderBy('position', 'asc')
            ->get();

        return $this->getStageMenu($parentStage)
            ->map(function($item) {
                unset($item->group, $item->group_id);
                if(!is_null($item->menu)) {
                    $menu = [];
                    $menu[] = [
                        'id' => $item->id,
                        'name' => $item->name,
                        'color' => $item->color
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
