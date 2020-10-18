<?php

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


Route::group(['middleware' => ['auth', 'sharedData']], function () {
    Route::resource('posts', App\Http\Controllers\PostController::class);
});

Route::group(['middleware' => ['sharedData']], function(){
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
    Route::get('category/{id}', [App\Http\Controllers\CategoryController::class, 'showCategoryPosts']);
});

Auth::routes();