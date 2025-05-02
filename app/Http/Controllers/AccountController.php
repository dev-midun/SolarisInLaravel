<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Models\Account;
use App\Repositories\AccountRepository;
use App\Helpers\DataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AccountController extends Controller
{
    protected $repo;

    public function __construct(AccountRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $breadcrumbs = [
            ['label' => 'Example App'],
            ['label' => 'Account']
        ];

        return view('pages.example.account.list', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function datatable(Request $request)
    {
        return DataTable::toDataTable($request, new Account());
    }

    public function store(AccountRequest $request)
    {
        $data = Arr::except($this->cleanData($request), 'profile_picture');
        $account = $this->repo->create($data);
        
        if($request->has('profile_picture')) {
            $this->repo->uploadAvatar($request, 'profile_picture_id', $account->id);
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function show(Request $request, string $id)
    {
        if(!$request->expectsJson()) {
            return redirect(route('accounts.edit', ['id' => $id]));
        }

        return response()->json($this->repo->findComplete($id));
    }

    public function edit(Request $request)
    {
        $breadcrumbs = [
            ['label' => 'Example App'],
            ['label' => 'Account'],
        ];
        $data = [
            "name" => "Romadan Saputra",
            "email" => "",
            "created_by_id" => ""
        ];

        return view('pages.example.account.page', [
            'data' => $data,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function update(AccountRequest $request, string $id)
    {
        $success = $this->repo->update($id, $this->cleanData($request));

        return response()->json([
            'success' => $success
        ]);
    }

    public function updateAvatar(AccountRequest $request, string $id)
    {
        if(!$request->hasFile('profile_picture')) {
            return response()->json(['success' => false, 'message' => 'File upload not found']);
        }

        return response()->json([
            'success' => $this->repo->uploadAvatar($request, 'profile_picture_id', $id)
        ]);
    }

    public function destroy(string $id)
    {
        return response()->json([
            'success' => $this->repo->delete($id)
        ]);
    }
}
