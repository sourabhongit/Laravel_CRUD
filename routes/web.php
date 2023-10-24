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
use App\Http\Controllers\ExcelRecordController;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\RecordLogsController;

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

	//* Excel Export & Import

	Route::get('admin/excel/records', [ExcelRecordController::class, 'index'])->defaults('_action', [
		'view' => 'excel.index',
	])->name('admin.excel.records.index');
	Route::post('admin/excel/records/import', [ExcelRecordController::class, 'import'])->defaults('_action', [
		'redirect' => 'admin.excel.records.index',
	])->name('admin.excel.records.import');
	Route::get('admin/excel/reords/export', [ExcelRecordController::class, 'export'])->defaults('_action', [
		'redirect' => 'admin.excel.records.index',
	])->name('admin.excel.records.export');

	//* CSV Export & Import

	Route::get('admin/csv/records', [CsvController::class, 'index'])->defaults('_action', [
		'view' => 'csv.index',
	])->name('admin.csv.records.index');
	Route::post('admin/csv/records/import', [CsvController::class, 'import'])->defaults('_action', [
		'redirect' => 'admin.csv.records.index',
	])->name('admin.csv.records.import');
	Route::get('admin/csv/records/export', [CsvController::class, 'export'])->defaults('_action', [
		'redirect' => 'admin.csv.records.index',
	])->name('admin.csv.records.export');

	//* Import/export with Modal view
	Route::get('admin/records', [ExcelRecordController::class, 'index'])->defaults('_action', [
		'view' => 'records.index',
	])->name('admin.records.index');
	Route::post('admin/records/import', [ExcelRecordController::class, 'import'])->defaults('_action', [
		'redirect' => 'admin.records.index',
	])->name('admin.records.import');
	Route::get('admin/records/export', [ExcelRecordController::class, 'export'])->name('admin.records.export');
	Route::post('/admin/records/save', [ExcelRecordController::class, 'saveData'])->name('admin.records.save');
	Route::post('/admin/record/update-status', [ExcelRecordController::class, 'updateStatus'])->name('admin.record.update-status');

	//* Record Logs
	Route::get('/record/logs', [RecordLogsController::class, 'index'])->name('log.index');
	Route::post('/record/log/add', [RecordLogsController::class, 'log'])->name('log.add');
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
