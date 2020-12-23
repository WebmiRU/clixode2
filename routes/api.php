<?php

use App\Http\Controllers\API\FileController;
use App\Http\Controllers\API\ImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Images
Route::group(['prefix' => 'file', 'as' => 'image.'], function () {
    Route::get('{uri}', [FileController::class, 'get'])->name('get');
    Route::post('/', [FileController::class, 'post'])->name('post');
});

//Images
Route::group(['prefix' => 'image', 'as' => 'image.'], function () {
    Route::get('{uri}', [ImageController::class, 'get'])->name('get');
    Route::post('/', [ImageController::class, 'post'])->name('post');
});
