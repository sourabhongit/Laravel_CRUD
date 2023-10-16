<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\SendMailableController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\CsvController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Guest Routes
Route::get('/', [GuestController::class, 'index'])->name('guest.index');
Route::get('/guest/category/{id}', [GuestController::class, 'fetch_items'])->name('guest.category');
Route::get('/guest/category/{id}', [GuestController::class, 'fetch_items'])->name('guest.category');
Route::post('/guest/categories', [GuestController::class, 'show_category'])->name('category.show');
Route::post('/guest/category/items', [GuestController::class, 'show_items_on_search'])->name('items.show');

// Normal Email using jobs
Route::get('send-email', [EmailController::class, 'sendEmail']);
// Send mail using Mailable
Route::get('sendMail', [SendMailableController::class, 'mailSend']);

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/user/create', [UsersController::class, 'create'])->name('user.create');
    Route::get('/user/delete/{id}', [UsersController::class, 'delete'])->name('user.delete');
    Route::post('/user/store', [UsersController::class, 'store'])->name('user.store');
    Route::get('/user/edit/{id}', [UsersController::class, 'edit'])->name('user.edit');

    Route::get('/item/create', [ItemController::class, 'create'])->name('item.create');
    Route::post('/item/store', [ItemController::class, 'store'])->name('item.store');
    Route::get('/item/delete/{id}', [ItemController::class, 'delete'])->name('item.delete');
    Route::post('/item/update-status', [ItemController::class, 'updateStatus'])->name('item.update-status');

    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');
    Route::post('/category/update-status', [CategoryController::class, 'updateStatus'])->name('category.update-status');

    // Excel Export & Import
    Route::get('admin/bulk/data', [ExcelController::class, 'index'])->defaults('_action', [
        'view' => 'excel.index',
    ])->name('admin.bulk.data.excel.index');
    Route::post('admin/bulk/data/import', [ExcelController::class, 'import'])->defaults('_action', [
        'redirect' => 'admin.bulk.data.excel.edit',
    ])->name('admin.bulk.data.excel.import');
    Route::get('admin/bulk/data/edit', [ExcelController::class, 'edit'])->defaults('_action', [
        'view' => 'excel.edit',
    ])->name('admin.bulk.data.excel.edit');
    Route::get('admin/bulk/data/export', [ExcelController::class, 'export'])->defaults('_action', [
        'return' => 'excel.index',
    ])->name('admin.bulk.data.excel.export');

    // CSV Export & Import
    Route::get('admin/bulk/CSV/data', [CsvController::class, 'index'])->defaults('_action', [
        'view' => 'csv.index',
    ])->name('admin.bulk.data.csv.index');
    Route::post('admin/bulk/CSV/data/import', [CsvController::class, 'import'])->defaults('_action', [
        'redirect' => 'admin.bulk.data.csv.edit',
    ])->name('admin.bulk.data.csv.import');
    Route::get('admin/bulk/CSV/data/edit', [CsvController::class, 'edit'])->defaults('_action', [
        'view' => 'csv.edit',
    ])->name('admin.bulk.data.csv.edit');
    Route::get('admin/bulk/CSV/data/export', [CsvController::class, 'export'])->defaults('_action', [
        'return' => 'csv.index',
    ])->name('admin.bulk.data.csv.export');
});

Route::middleware(['auth', 'role:admin|editor'])->group(function () {
    Route::get('/user', [UsersController::class, 'index'])->name('user.index');
    Route::post('/user/update/{id}', [UsersController::class, 'update'])->name('user.update');
    Route::get('/user/edit/{id}', [UsersController::class, 'edit'])->name('user.edit');

    Route::get('/item', [ItemController::class, 'index'])->name('item.index');
    Route::get('/item/edit/{id}', [ItemController::class, 'edit'])->name('item.edit');
    Route::post('/item/update/{id}', [ItemController::class, 'update'])->name('item.update');

    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::patch('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');

    Route::get('export-categories', [CategoryController::class, 'exportUsers'])->name('export-categories');
    Route::get('generate-pdf', [PDFController::class, 'generatePDF'])->name('generatePDF');
});

require __DIR__ . '/auth.php';
