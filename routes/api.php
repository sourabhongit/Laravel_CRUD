<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ItemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [CategoryController::class, 'login'])->name('api.login');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('category', [CategoryController::class, 'index'])->name('api.category.index');
    Route::post('category/store', [CategoryController::class, 'store'])->name('api.category.store');
    Route::get('category/edit/{id}', [CategoryController::class, 'edit'])->name('api.category.edit');
    Route::post('category/update/{id}', [CategoryController::class, 'update'])->name('api.category.update');
    Route::get('category/{id}/delete/', [CategoryController::class, 'delete'])->name('api.category.delete');

    Route::get('items', [ItemController::class, 'index'])->name('api.item.index');
    Route::post('item/store', [ItemController::class, 'store'])->name('api.item.store');
    Route::get('item/edit/{id}', [ItemController::class, 'edit'])->name('api.item.edit');
    Route::post('item/update/{id}', [ItemController::class, 'update'])->name('api.item.update');
    Route::get('item/delete/{id}', [ItemController::class, 'delete'])->name('api.item.delete');
});
