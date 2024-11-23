<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;



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

Route::get('/', function () {
    return redirect('/login');
})->name('home');

// 認証ルート
Auth::routes();

// 在庫管理画面
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');

// 商品詳細画面
Route::get('product/{id}', [ProductController::class, 'show'])->name('product.show');

Route::resource('inventory', InventoryController::class);
Route::resource('products', ProductController::class);
Route::resource('user', UserManagementController::class);

// 管理者関連ルート
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
});

// 一般ユーザー関連ルート
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
});

// 在庫管理画面
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
// 商品詳細画面
Route::get('product/{id}', [ProductController::class, 'show'])->name('product.show');

Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');

