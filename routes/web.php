<?php

use App\Http\Controllers\BucketController;
use App\Http\Controllers\BucketFileController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ImageProcessorController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [IndexController::class, 'index']);
Route::post('login', [IndexController::class, 'login']);

//////Buckets
////Route::group(['prefix' => 'bucket', 'as' => 'bucket.'], function () {
//
//Route::middleware(['auth:sanctum', 'verified'])->group(function () {
////    return view('dashboard');
////    return view('dashboard');
//
////    Route::get('dashboard', function () {return view('dashboard');})->name('dashboard');
////    Route::get('/', [IndexController::class, 'index']);
//
//    //Image processors
//    Route::group(['prefix' => 'image-processor', 'as' => 'image-processor.'], function () {
//        Route::get('/', [ImageProcessorController::class, 'index'])->name('index');
//        Route::get('{id}', [ImageProcessorController::class, 'edit'])->name('edit');
//        Route::post('{id}', [ImageProcessorController::class, 'post'])->name('post');
//        Route::put('{id}', [ImageProcessorController::class, 'put'])->name('put');
//        Route::delete('{id}', [ImageProcessorController::class, 'delete'])->name('delete');
//    });
//
//    //Buckets
//    Route::group(['prefix' => 'bucket', 'as' => 'bucket.'], function () {
//        Route::get('/', [BucketController::class, 'index'])->name('index');
//        Route::get('{id}', [BucketController::class, 'edit'])->name('edit');
//        Route::post('{id}', [BucketController::class, 'post'])->name('post');
//        Route::put('{id}', [BucketController::class, 'put'])->name('put');
//        Route::delete('{id}', [BucketController::class, 'delete'])->name('delete');
//    });
//
//    //Bucket files
//    Route::group(['prefix' => 'bucket-file', 'as' => 'bucket-file.'], function () {
//        Route::get('{id}', [BucketFileController::class, 'edit'])->name('edit');
//        Route::post('{id}', [BucketFileController::class, 'post'])->name('post');
//        Route::put('{id}', [BucketFileController::class, 'put'])->name('put');
//        Route::delete('{id}', [BucketFileController::class, 'delete'])->name('delete');
//    });
//
//    //Files
//    Route::group(['prefix' => 'file', 'as' => 'file.'], function () {
//        Route::get('{uri}', [FileController::class, 'get'])->name('get');
//        Route::post('/', [FileController::class, 'post'])->name('post');
//    });
//
//    //Files
//    Route::group(['prefix' => 'image', 'as' => 'image.'], function () {
//        Route::get('{uri}', [ImageController::class, 'get'])->name('get');
//        Route::post('/', [ImageController::class, 'post'])->name('post');
//    });
//});


//    Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//    return view('dashboard');
//})->name('dashboard');
