<?php

namespace App\Http\Controllers;

use App\Helpers\DataTable;
use App\Http\Requests\AttachmentRequest;
use App\Models\Attachment;
use App\Repositories\AttachmentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AttachmentController extends Controller
{
    protected $repo;

    public function __construct(AttachmentRepository $repo)
    {
        $this->repo = $repo;
    }

    public function datatable(Request $request)
    {
        return DataTable::toDataTable($request, new Attachment(), function($item) {
            $item->file_size_human = $item->getHumanReadableSize();
            return $item;
        });
    }

    public function store(AttachmentRequest $request)
    {
        $upload = $this->repo->upload($request);
        return response()->json(is_array($upload) ? $upload : true);
    }

    public function download(string $id)
    {
        return $this->repo->download($id);
    }

    public function destroy(string $id)
    {
        return response()->json([
            'success' => $this->repo->delete($id)
        ]);
    }
}
