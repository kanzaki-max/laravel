<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
// use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;
// use App\Http\Controllers\CategoryController;

Auth::routes();

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

// 未認証のユーザーをログインページにリダイレクト
Route::get('/', function () {
    return redirect('login'); 
})->name('home');

// ログイン後、ユーザーのロールに応じてリダイレクト
Route::middleware('auth')->get('/home', function () {
    return redirect(auth()->user()->role === 'admin' ? '/admin/dashboard' : '/user/dashboard');
});

// 管理者専用ルート
Route::middleware(['auth', 'admin'])->group(function () {
    // 管理者ダッシュボード
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // 管理者専用のユーザー管理ルート
    Route::get('/admin/users', [UserController::class, 'adminIndex'])->name('users.index');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // 管理者専用の製品管理ルート
    Route::resource('products', ProductController::class)->only(['index', 'edit', 'update', 'destroy']);
});

// 一般ユーザー専用ルート
Route::middleware(['auth'])->group(function () {
    // ユーザーダッシュボード
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');

    // 商品管理
    Route::resource('products', ProductController::class);

    // 在庫管理
    Route::resource('inventory', InventoryController::class);

    // カテゴリ管理
    Route::resource('categories', CategoryController::class);

    // 在庫登録
    Route::post('/inventory/store', [InventoryController::class, 'store'])->name('inventory.store'); 
});
