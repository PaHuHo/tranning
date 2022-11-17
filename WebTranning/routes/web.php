<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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


Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [UserController::class, 'store'])->name('store-login');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/product', [ProductController::class, 'index'])->name('list-product');
    Route::get('/product/fetch_data', [ProductController::class, 'fetchData'])->name("fetch-data-product");
    Route::get('/product/search', [ProductController::class, 'searchProduct'])->name("search-product");
    Route::get('/product/add', [ProductController::class, 'addProduct'])->name("add-product");
    Route::Post('/product/add', [ProductController::class, 'storeAddProduct'])->name("add-product");
    Route::get('/product/edit/{id}', [ProductController::class, 'editProduct'])->name("edit-product");
    Route::Post('/product/edit/{id}', [ProductController::class, 'storeEditProduct'])->name("edit-product");
    Route::post('/product/delete/{id}', [ProductController::class, 'deleteProduct'])->name("delete-product");

    Route::get('/user', [UserController::class, 'index'])->name('list-user');
    Route::get('/user/fetch_data', [UserController::class, 'fetchData'])->name("fetch-data-user");
    Route::post('/user/add', [UserController::class, 'storeAdd'])->name("add-user");
    Route::post('/user/edit', [UserController::class, 'storeEdit'])->name("edit-user");
    Route::post('/user/delete/{id}', [UserController::class, 'storeDelete'])->name("delete-user");
    Route::post('/user/lock/{id}', [UserController::class, 'storeLock'])->name("lock-user");


    Route::get('/customer', [CustomerController::class, 'index'])->name('list-customer');
    Route::get('/customer/fetch_data', [CustomerController::class, 'fetchData'])->name("fetch-data-customer");
    Route::post('/customer/add', [CustomerController::class, 'storeAdd'])->name("add-customer");
    Route::post('/customer/edit', [CustomerController::class, 'storeEdit'])->name("edit-customer");
    Route::post('/customer/import', [CustomerController::class, 'import'])->name("import-customer");
    Route::get('/customer/export', [CustomerController::class, 'export'])->name("export-customer");
});
