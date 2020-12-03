<?php

use App\Http\Controllers\BucketController;
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

Route::group(['prefix' => 'bucket', 'as' => 'bucket.'], function () {
    Route::get('/', [BucketController::class, 'index'])->name('index');
    Route::get('{id}', [BucketController::class, 'edit'])->name('edit');
});
