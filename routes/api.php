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

Route::post('admin/login', [CategoryController::class, 'login'])->name('api.admin.login');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('admin/categories', [CategoryController::class, 'index'])->name('api.admin.category.index');
    Route::post('admin/category/store', [CategoryController::class, 'store'])->name('api.admin.category.store');
    Route::get('admin/category/{id}/edit', [CategoryController::class, 'edit'])->name('api.admin.category.edit');
    Route::post('admin/category/{id}/update', [CategoryController::class, 'update'])->name('api.admin.category.update');
    Route::delete('admin/category/{id}/delete', [CategoryController::class, 'delete'])->name('api.admin.category.delete');

    Route::get('admin/items', [ItemController::class, 'index'])->name('api.admin.item.index');
    Route::post('admin/item/store', [ItemController::class, 'store'])->name('api.admin.item.store');
    Route::get('admin/item/{id}/edit', [ItemController::class, 'edit'])->name('api.admin.item.edit');
    Route::post('admin/item/{id}/update', [ItemController::class, 'update'])->name('api.admin.item.update');
    Route::get('admin/item/{id}/delete', [ItemController::class, 'delete'])->name('api.admin.item.delete');
});
