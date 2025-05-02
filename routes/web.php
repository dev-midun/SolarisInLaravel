<?php

use App\Helpers\ResultStatus;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\LookupController;
use App\Http\Requests\FormComponentRequest;
use App\Models\Attachment;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Password;

Route::get('/', function () {
    return view('layouts/main');
});

Route::prefix('components')->group(function() {
    Route::get('/button', fn() => view('pages/components/button'))->name("components.button");
    Route::prefix('form')->group(function() {
        Route::get('/input', fn() => view('pages/components/form/input'))->name("components.form.input");
        Route::get('/select-combobox', fn() => view('pages/components/form/select-combobox'))->name("components.form.select_combobox");
        Route::get('/checkbox-radio', fn() => view('pages/components/form/checkbox-radio'))->name("components.form.checkbox_radio");
        Route::get('/date-picker', fn() => view('pages/components/form/date-picker'))->name("components.form.date_picker");
        Route::get('/field', fn() => view('pages/components/form/field'))->name("components.form.field");
        Route::get('/form', fn() => view('pages/components/form/form'))->name("components.form.form");
        Route::post('/form', fn(FormComponentRequest $request) => (new ResultStatus(true))->toJson())->name("components.form.form.post");
    });

    Route::get('/table', fn() => view('pages/components/other'))->name("components.other");
    Route::get('/attachment', fn() => view('pages/components/other'))->name("components.other");
    Route::get('/notes', fn() => view('pages/components/other'))->name("components.other");
    Route::get('/stages', fn() => view('pages/components/other'))->name("components.other");
    Route::get('/calendar', fn() => view('pages/components/other'))->name("components.other");
    Route::get('/others', fn() => view('pages/components/other'))->name("components.other");
});

Route::get('/images/{id}', fn ($id) => Attachment::getImage($id))->whereUuid('id')->name('images');
Route::get('/images/thumbnail/{id}', fn ($id) => Attachment::getThumbnail($id))->whereUuid('id')->name('images.thumbnail');
Route::post('/lookup/{name}', [LookupController::class, 'index'])->name('lookup');

Route::prefix('attachment')->group(function () {
    Route::post('/', [AttachmentController::class, 'store'])->name('attachment.store');
    Route::post('/datatable', [AttachmentController::class, 'datatable'])->name('attachment.datatable');
    Route::get('/download/{id}', [AttachmentController::class, 'download'])
        ->whereUuid('id')
        ->name('attachment.download');
    Route::delete('/{id}', [AttachmentController::class, 'destroy'])
        ->whereUuid('id')
        ->name('attachment.delete');
});

Route::post('/account', [AccountController::class, 'store'])->name("account.create");
Route::post('/account/datatable', [AccountController::class, 'datatable'])->name("account.create");
Route::get('/account/{id}', [AccountController::class, 'show'])->whereUuid('id')->name('account.read');
Route::put('/account/{id}', [AccountController::class, 'update'])->whereUuid('id')->name('account.update');
Route::delete('/account/{id}', [AccountController::class, 'destroy'])->whereUuid("id")->name("account.destroy");
Route::post('/account/avatar/{id}', [AccountController::class, 'updateAvatar'])->whereUuid('id')->name('account.update.avatar');

Route::prefix('example')->group(function() {
    Route::prefix('account')->group(function() {
        Route::get('/list', [AccountController::class, 'index'])->name("example.account.list");
        Route::get('/edit-page', [AccountController::class, 'edit'])->name("example.account.edit_page");
        Route::post('/', [AccountController::class, 'store'])->name("example.account.create");
    });

    Route::prefix('form')->group(function() {
        
    });
});