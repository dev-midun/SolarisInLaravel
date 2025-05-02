<?php

namespace App\Repositories;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AttachmentRepository extends BaseRepository
{
    public function __construct(Attachment $model)
    {
        parent::__construct($model);
    }

    public function findComplete($id)
    {
        return $this->model
            ->defaultSelect([
                'id',
                'file_name',
                'file_size',
                'file_extension',
                'path',
                'table_name',
                'record_id',
                'created_by_id'
            ])
            ->with(['created_by' => fn($query) => $query->select('id', 'name')])
            ->where('id', $id)
            ->first();
    }

    public function upload(Request $request)
    {
        return Attachment::chunkUpload($request);
    }

    public function download(string $id)
    {
        return Attachment::download($id);
    }

    public function delete($id): bool
    {
        $success = false;
        try {
            DB::beginTransaction();

            $record = $this->find($id);
            Storage::disk('public')->delete($record->path);

            $thumbnailPath = "thumbnail/".str_replace(".{$record->file_extension}", ".webp", $record->path);
            if (Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }

            $success = $record->delete($id);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }

        return $success;
    }
}