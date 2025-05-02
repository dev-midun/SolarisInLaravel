<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use App\Models\LookupModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use ReflectionClass;

class LookupController extends Controller
{
    public function index(Request $request, $name) 
    {
        $modelClass = "App\\Models\\{$name}";
        $isModelExists = class_exists($modelClass);
        $isCustomExists = $this->isCustomLookupExists($name);

        if($isModelExists && !$isCustomExists) {
            $model = new $modelClass;
            if(!$model instanceof BaseModel) {
                return response()->json(['success' => false, 'meessage' => "Lookup {$name} not found"], 404);
            }

            return $this->getLookup($request, $model);
        }

        // untuk custom lookup yang tidak sesuai dengan standar / model yg tidak extend base model / lookup model
        if($isCustomExists) {
            return $this->$name($request);
        }

        return response()->json(['success' => false, 'meessage' => "Lookup {$name} not found"], 404);
    }

    // custom lookup here

    // end custom lookup here

    protected function getLookup(Request $request, BaseModel $model)
    {
        $isPagination = $request->has('page') && $request->has('length');
        $isSearch = $request->has('search') && !empty(trim($request->input('search')));
        $isFilter = $request->has('filter') && !empty($request->input('filter'));
        $isFromCache = !$isPagination && !$isSearch && !$isFilter;

        if($isFromCache && $model instanceof LookupModel) {
            $cacheName = "lookup_".get_class($model);
            $data = Cache::remember($cacheName, 7200, fn () => $model->defaultSelect()->defaultOrder()->toLookup());
            return response()->json($data);
        }

        $page = $request->input('page');
        $length = $request->input('length');
        $search = $request->input('search');
        $filter = $request->input('filter');

        $data = $this->getLookupQuery($model, $search, $filter, $page, $length);
        if($isPagination) {
            return response()->json([
                'results' => $data->items(),
                'pagination' => [
                    'more' => $data->hasMorePages()
                ]
            ]);
        }

        return response()->json($data->get());
    }

    protected function getLookupQuery(BaseModel $model, $search, $filter, $page, $length)
    {
        $query = $model->defaultSelect()
            ->defaultOrder()
            ->when(!empty($search), function($query) use($search) {
                $query->defaultWhere($search);
            })
            ->when(!empty($filter), function($query) use($filter) {
                $query->filter($filter);
            });

        if($model instanceof LookupModel && (isset($page) && isset($length))) {
            return $query->toLookupPagination($page, $length);
        }

        if(isset($page) && isset($length)) {
            return $query->paginate($length, ['*'], 'page', $page);
        }

        return $query;
    }

    private function isCustomLookupExists(string $publicMethodName): bool
    {
        $reflection = new ReflectionClass($this);
        if ($reflection->hasMethod($publicMethodName)) {
            $method = $reflection->getMethod($publicMethodName);

            return $method->isPublic();
        }

        return false;
    }
}
