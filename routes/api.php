<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\TagApiController;
use App\Http\Controllers\ContentTagApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('tags', [TagApiController::class, 'list'])->name('tags.list');
//Route::delete('tags', [TagApiController::class, 'delete'])->name('tags.delete');
//Route::put('tags/{id}', [TagApiController::class, 'update'])->name('tags.update');
//Route::post('tags', [TagApiController::class, 'create'])->name('tags.create');
//


Route::get('contents', [ContentTagApiController::class, 'list'])->name('contents.list');
Route::get('popular-tags', [ContentTagApiController::class, 'popularTag'])->name('contents.popularTag');

