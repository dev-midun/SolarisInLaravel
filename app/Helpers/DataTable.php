<?php

namespace App\Helpers;

use App\Models\BaseModel;
use App\Models\LookupModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class DataTable
{
    public static function getColumns(Request $request): array
    {
        if(!$request->has('columns')) {
            throw new \Exception("Request does not have columns");
        }

        $columns = $request->input('columns');
        $validColumns = Arr::where($columns, fn($value, $key) => !empty($value["name"]));

        return array_values(Arr::map($validColumns, function($value, $key) {
            $split = explode(".", $value["name"]);
            return count($split) > 1 ? $split[0]."_id" : $value["name"];
        }));
    }

    /**
     * @return array ['search' => '', 'columns' => [['name' => '', 'type' => '']]]
     */
    public static function getSearch(Request $request): array
    {
        if(!$request->has('columns')) {
            throw new \Exception("Request does not have columns");
        }

        if(!$request->has('search')) {
            throw new \Exception("Request does not have search");
        }

        $search = $request->input('search');
        if(!isset($search)) {
            return [];
        }

        $columns = $request->input('columns');
        $searchableOnly = Arr::where($columns, fn($value, $key) => $value["searchable"] == "true");

        $searchable = [
            "search" => $search,
            "columns" => []
        ];
        foreach ($searchableOnly as $key => $value) {
            $searchable["columns"][] = [
                "name" => $value["name"],
                "isLookup" => $value["isLookup"]
            ];
        }

        return $searchable;
    }

    /**
     * @return array ['orderBy' => '', 'direction' => '']
     */
    public static function getOrderBy(Request $request): array
    {
        if(!$request->has('columns')) {
            throw new \Exception("Request does not have columns");
        }

        if(!$request->has('order') || empty($request->input('order'))) {
            return [];
        }

        $order = $request->input('order');
        $orderValue = Arr::first($order);

        $orderBy = $orderValue["name"];
        $direction = $orderValue["dir"];
        $column = Arr::first($request->input("columns"), fn($value, $key) => $value["name"] == $orderBy);

        if(empty($direction)) {
            return [];
        }

        return [
            "orderBy" => $orderBy,
            "direction" => $direction,
            "isLookup" => $column["isLookup"]
        ];
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query 
     * @param array $columns ['name' => '', 'type' => '']
     * @param string $searchValue
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function getSearchQuery(Builder $query, array $columns, string $searchValue): Builder
    {
        $likeOperator = env("DB_CONNECTION") == 'pgsql' ? 'ilike' : 'like';

        foreach ($columns as $column) {
            if($column["isLookup"]) {
                $belongsTo = Str::endsWith($column["name"], '_id') ? substr($column["name"], 0, -3) : $column["name"];
                $query->orWhereHas($belongsTo, function($query) use($searchValue) {
                    $query->when($query->getModel() instanceof BaseModel, fn($query) => $query->defaultWhere($searchValue));
                });
            } else {
                $query->orWhere($column["name"], $likeOperator, "%{$searchValue}%");
            }
        }

        return $query;
    }

    /**
     * @param Model|BaseModel|LookupModel $model
     * @param array $columns
     * @param array $searchBy ['search' => '', 'columns' => [['name' => '', 'type' => '']]]
     * @param array $orderBy ['orderBy' => '', 'direction' => '']
     * @param array $withs [belongTo => fn] | [belongTo]
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function getQuery(Model $model, array $columns, array $searchBy, array $orderBy, array $filter = []): Builder
    {
        $query = $model
            ->when($model instanceof BaseModel, fn($query) => $query->defaultSelect($columns))
            ->when(!empty($searchBy), function($query) use($searchBy) {
                $searchValue = $searchBy["search"];
                $columns = $searchBy["columns"];

                $query->where(function($query) use($searchValue, $columns) {
                    return self::getSearchQuery($query, $columns, $searchValue);
                });
            })
            ->when(!empty($filter) && $model instanceof BaseModel, function($query) use($filter) {
                $query->filter($filter);
            })
            ->when(!empty($orderBy), fn($query) => $query->orderBy($orderBy['orderBy'], $orderBy['direction']))
            ->when(empty($orderBy) && $model instanceof BaseModel, fn($query) => $query->orderBy($model::$orderBy, $model::$direction));
            

        return $query;
    }
    
    public static function toQuery(Request $request, Model $model): Builder
    {
        $columns = self::getColumns($request);
        $searchBy = self::getSearch($request);
        $orderBy = self::getOrderBy($request);
        $filter = $request->has('filter') ? $request->input('filter') : [];

        if(!in_array("id", $columns)) {
            array_unshift($columns, "id");
        }

        return self::getQuery($model, $columns, $searchBy, $orderBy, $filter);
    }

    public static function toDataTable(Request $request, Model $model, ?callable $callback = null)
    {
        $filter = $request->has('filter') ? $request->input('filter') : [];
        $totalData = $model::query()
            ->when(!empty($filter) && $model instanceof BaseModel, function($query) use($filter) {
                $query->filter($filter);
            })
            ->count();
        $query = self::toQuery($request, $model);

        return self::toJson($request, $totalData, $query, $callback);
    }

    public static function toJson(Request $request, int $totalData, Builder $query, ?callable $callback = null)
    {
        if(!$request->has('start')) {
            throw new \Exception("Request does not have start");
        }

        if(!$request->has('length')) {
            throw new \Exception("Request does not have length");
        }

        $draw = intval($request->input('draw'));
        $start = (int)$request->input('start');
        $length = (int)$request->input('length');
        $page = ceil(($start + 1) / $length);

        $query = $query->paginate($length, ['*'], 'page', $page);
        if($callback != null) {
            $query->through(fn ($item, $index) => $callback($item, $index));
        }

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $totalData,
            'recordsFiltered' => $query->total(),
            'data' => $query->items()
        ]);
    }
}