<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BaseModel extends Model
{
    use HasUuids;

    public $isLookup = false;
    public $incrementing = false;
    public static $orderBy = "created_at";
    public static $direction = "desc";
    public static $displayValue = null;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $guarded = ['created_at', 'updated_at', 'created_by_id', 'updated_by_id'];
    protected $defaultSelectColumn = [];
    protected $defaultWhereColumn = [];

    protected static function booted()
    {
        static::creating(function ($query) {
            $userId = Auth::user()?->id ?? null;
            
            if(!empty($userId)) {
                $query->created_by_id = $userId;
                $query->updated_by_id = $userId;
            }
        });

        static::updating(function ($query) {
            $userId = Auth::user()?->id ?? null;

            if(!empty($userId)) {
                $query->updated_by_id = $userId;
            }
        });
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:d M Y H:i:s',
            'updated_at' => 'datetime:d M Y H:i:s'
        ];
    }

    public function getDisplayValue() 
    {
        if(empty(static::$displayValue)) {
            return null;
        }

        return $this->{static::$displayValue};
    }

    public function scopeDefaultSelect(Builder $query, $column = null)
    {
        $totalColArg = func_num_args();
        $colArg = array_slice(func_get_args(), 1);

        if($totalColArg == 1 || empty($column)) {
            return $query
                ->when(!empty($this->defaultSelectColumn), fn($query) => $query->defaultSelect($this->defaultSelectColumn))
                ->when(empty($this->defaultSelectColumn) && !empty(static::$displayValue), fn($query) => $query->select('id', static::$displayValue));
        }

        $selectColumn = [];
        foreach ($colArg as $arg) {
            if(is_array($arg)) {
                $selectColumn = array_merge($selectColumn, $arg);
            } else if(is_string($arg)) {
                $selectColumn[] = $arg;
            }
        }

        if(!empty($this->defaultSelectColumn)) {
            $selectColumn = array_merge($selectColumn, $this->defaultSelectColumn);
        }

        $selectColumn = array_values(array_unique($selectColumn));        
        $lookupColumn = Arr::map(
            array_flip(Arr::map(
                Arr::where($selectColumn, fn($item) => $this->isLookup($item)),
                fn($item) => Str::endsWith($item, '_id') ? substr($item, 0, -3) : $item
            )),
            fn($item) => fn($query) => $query->getModel() instanceof BaseModel ? $query->defaultSelect() : $query 
        );

        return $query->select($selectColumn)
            ->when(!empty($lookupColumn), fn($query) => $query->with($lookupColumn));
    }

    public function scopeDefaultWhere(Builder $query, $searchValue)
    {
        $likeOperator = env("DB_CONNECTION") == 'pgsql' ? 'ilike' : 'like';

        if(empty($this->defaultWhereColumn) || !isset($searchValue)) {
            return $query->when(!empty(static::$displayValue), fn($query) => $query->where(static::$displayValue, $likeOperator, "%{$searchValue}%"));
        }

        $scope = $this;
        return $query->where(function($query) use($searchValue, $likeOperator, $scope) {
            foreach ($this->defaultWhereColumn as $column) {
                $query->when(
                    $scope->isLookup($column), 
                    function($query) use($column, $searchValue) {
                        $belongTo = Str::endsWith($column, '_id') ? substr($column, 0, -3) : $column;
                        $query->orWhereHas(
                            $belongTo, 
                            fn($query) => $query->getModel() instanceof BaseModel ? $query->defaultWhere($searchValue) : $query
                        );
                    },
                    fn($query) => $query->orWhere($column, $likeOperator, "%{$searchValue}%")
                );
            }
        });
    }

    public function scopeDefaultOrder(Builder $query)
    {
        if(empty(static::$orderBy)) {
            return $query;
        }
        
        $query->orderBy(static::$orderBy, static::$direction ?? "asc");
    }

    public function scopeFilter(Builder $query, $filters)
    {
        $query->where(function($query) use($filters) {
            foreach ($filters as $filter) {
                if(Arr::exists($filter, 'groups')) {
                    $this->buildGroupFilter($query, $filter);
                } else if(Arr::exists($filter, 'logical') && Arr::exists($filter, 'comparison') && Arr::exists($filter, 'conditions')) {
                    $this->buildFilter($query, $filter);
                }
            }
        });
    }

    protected function buildFilter(Builder $query, array $filter): Builder
    {
        $logical = $filter['logical'];
        $comparison = $this->getOperator($filter['comparison']);
        $left = $filter['conditions']['left'];
        $right = $filter['conditions']['right'];
        $isNullComparison = $comparison == 'IS_NULL' || $comparison == 'IS_NOT_NULL';
        $isBetweenComparison = $comparison == 'BETWEEN';
        $isInComparison = $comparison == 'IN';
        $isDefaultComparison = !$isNullComparison && !$isBetweenComparison && !$isInComparison;
        
        if(str_ends_with($comparison, 'LIKE') ) {
            $right = $this->getLikeValue($filter['comparison'], $filter['conditions']['right']);
        }

        if(is_null($logical) || $logical == 'AND') {
            $query
                ->when($isNullComparison && $comparison == 'IS_NULL', 
                    fn($query) => $query->whereNull($left))
                ->when($isNullComparison && $comparison == 'IS_NOT_NULL', 
                    fn($query) => $query->whereNotNull($left))
                ->when($isBetweenComparison, fn($query) => $query->whereBetween($left, $right))
                ->when($isInComparison, fn($query) => $query->whereIn($left, $right))
                ->when($isDefaultComparison, fn($query) => $query->where($left, $comparison, $right));
        } else {
            $query
                ->when($isNullComparison && $comparison == 'IS_NULL', 
                    fn($query) => $query->orWhereNull($left))
                ->when($isNullComparison && $comparison == 'IS_NOT_NULL', 
                    fn($query) => $query->orWhereNotNull($left))
                ->when($isBetweenComparison, fn($query) => $query->orWhereBetween($left, $right))
                ->when($isInComparison, fn($query) => $query->orWhereIn($left, $right))
                ->when($isDefaultComparison, fn($query) => $query->orWhere($left, $comparison, $right));
        }

        return $query;
    }

    protected function buildGroupFilter(Builder $query, $groups): Builder
    {
        return $query->where(function($query) use($groups) {

        });
    }

    protected function getOperator(string $comparison): string
    {
        $likeOperator = env("DB_CONNECTION") == 'pgsql' ? 'ILIKE' : 'LIKE';
        return match ($comparison) {
            'EQUAL' => '=',
            'NOT_EQUAL' => '!=',
            'GREATER' => '>',
            'GREATER_OR_EQUAL' => '>=',
            'LESS' => '<',
            'LESS_OR_EQUAL' => '<=',
            'LIKE' => 'LIKE',
            'LIKE_START_WITH' => $likeOperator,
            'LIKE_END_WITH' => $likeOperator,
            'BETWEEN' => 'BETWEEN',
            'IN' => 'IN',
            'IS_NULL' => 'IS_NULL',
            'IS_NOT_NULL' => 'IS_NOT_NULL',
            default => '='
        };
    }

    protected function getLikeValue(string $comparison, string $value): string
    {
        return match ($comparison) {
            'LIKE' => "%{$value}%",
            'LIKE_START_WITH' => "%{$value}",
            'LIKE_END_WITH' => "{$value}%",
            default => "%{$value}%"
        };
    }

    public function isLookup($attribute)
    {
        $relationMethod = Str::endsWith($attribute, '_id') ? substr($attribute, 0, -3) : $attribute;
        $isMethodExists = method_exists($this, $relationMethod);
        
        return $isMethodExists && $this->$relationMethod() instanceof \Illuminate\Database\Eloquent\Relations\BelongsTo;
    }

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id')
            ->select('id', 'name', 'email');
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_id')
            ->select('id', 'name', 'email');
    }
}