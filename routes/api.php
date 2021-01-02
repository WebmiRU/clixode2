<?php

use App\Http\Controllers\API\BucketController;
use App\Http\Controllers\API\BucketImageController;
use App\Http\Controllers\API\FileController;
use App\Http\Controllers\API\ImageController;
use App\Http\Controllers\API\ImageProcessorController;
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

Route::middleware(['auth:sanctum'])->group(function () {
    //Bucket
    Route::group(['prefix' => 'bucket', 'as' => 'bucket.'], function () {
        Route::get('/', [BucketController::class, 'index'])->name('index');
        Route::get('{id}', [BucketController::class, 'get'])->name('get');
        Route::post('/', [BucketController::class, 'post'])->name('post');
    });

    //Bucket image
    Route::group(['prefix' => 'bucket-image', 'as' => 'bucket-image.'], function () {
        Route::get('/', [BucketImageController::class, 'index'])->name('index');
        Route::get('{id}', [BucketImageController::class, 'get'])->name('get');
        Route::post('/', [BucketImageController::class, 'post'])->name('post');
    });

    //Files
    Route::group(['prefix' => 'file', 'as' => 'file.'], function () {
        Route::get('{uri}', [FileController::class, 'get'])->name('get');
        Route::post('/', [FileController::class, 'post'])->name('post');
        Route::post('link', [FileController::class, 'link'])->name('link');
    });

    //Images
    Route::group(['prefix' => 'image', 'as' => 'image.'], function () {
        Route::get('{uri}', [ImageController::class, 'get'])->name('get');
        Route::post('/', [ImageController::class, 'post'])->name('post');
    });

    //Image processors
    Route::group(['prefix' => 'image-processor', 'as' => 'image-processor.'], function () {
        Route::get('actions', [ImageProcessorController::class, 'actions'])->name('actions');

        Route::get('/', [ImageProcessorController::class, 'index'])->name('index');
        Route::get('{id}', [ImageProcessorController::class, 'get'])->name('get');
        Route::post('/', [ImageProcessorController::class, 'post'])->name('post');
        Route::put('{id}', [ImageProcessorController::class, 'put'])->name('put');
    });
});
