<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\Attachment;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;
    
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function list($search, $filter, $orderBy, $direction, $page = 1, $length = 10)
    {
        return $this->model
            ->defaultSelect()
            ->when(!empty($search), fn($query) => $query->defaultWhere($search))
            ->when(!empty($filter) && $this->model instanceof BaseModel, fn($query) => $query->filter($filter))
            ->when(
                !empty($orderBy), 
                fn($query) => $query->orderBy($orderBy, $direction ?? "asc"),
                fn($query) => $query->defaultOrderBy()
            )
            ->paginate($length, ['*'], 'page', $page)
            ->items();
    }

    public function find(string $id)
    {
        return $this->model->findOrFail($id);
    }

    public function findComplete(string $id)
    {
        return $this->model
            ->defaultSelect()
            ->where('id', $id)
            ->first();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->find($id);
        foreach ($data as $key => $value) {
            $record->{$key} = $value;
        }

        return $record->save();
    }

    public function uploadAvatar(Request $request, $column, $id, $fileParamName = 'profile_picture')
    {
        $attachmentRelation = Str::endsWith($column, '_id') ? substr($column, 0, -3) : $column;
        $data = $this->model
            ->select('id', $column)
            ->with([$attachmentRelation => fn($query) => $query->defaultSelect('path')])
            ->where('id', $id)
            ->first();

        try {
            DB::beginTransaction();

            $isDeleteOldAvatar = false;
            $oldProfilePicture = $data->{$attachmentRelation};
            $oldPath = $oldProfilePicture?->path;
            if (!empty($oldPath)) {
                if(Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }

                $thumbnailPath = "thumbnail/".str_replace(".{$oldProfilePicture->file_extension}", ".webp", $oldPath);
                if(Storage::disk('public')->exists($thumbnailPath)) {
                    Storage::disk('public')->delete($thumbnailPath);
                }

                $isDeleteOldAvatar = true;
            }

            $file = $request->file($fileParamName);
            $imgInfo = [
                'thumbnail' => 120
            ];

            if($request->has('image_height') && $request->has('image_width')) {
                $imgInfo['image_height'] = $request->input('image_height');
                $imgInfo['image_width'] = $request->input('image_width');
            }

            $avatar = Attachment::upload(
                file: $file, 
                saveTo: (new \ReflectionClass($this->model))->getShortName(), 
                imageInfo: $imgInfo
            );
            $data->{$column} = $avatar->id;
            $data->save();

            if($isDeleteOldAvatar) {
                $oldAvatar = Attachment::find($oldProfilePicture->id);
                $oldAvatar->delete();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }

        return true;
    }

    public function delete($id): bool
    {
        $record = $this->find($id);

        return $record->delete();
    }
}
