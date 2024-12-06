<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IncomingStockController;

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

Auth::routes(['reset' => true]);

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

    // カテゴリ管理
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // 管理者専用の製品管理ルート
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/load', [ProductController::class, 'loadMore'])->name('products.load');

    Route::delete('/incoming-stocks/{stock}', [IncomingStockController::class, 'destroy'])->name('incoming_stocks.destroy');
    Route::get('/incoming-stocks/{stock}/edit', [IncomingStockController::class, 'edit'])->name('incoming_stocks.edit');
    Route::put('/incoming-stocks/{stock}', [IncomingStockController::class, 'update'])->name('incoming_stocks.update');
});

// 一般ユーザー専用ルート
Route::middleware(['auth'])->group(function () {
    Route::get('/incoming-stocks', [IncomingStockController::class, 'index'])->name('incoming_stocks.index');
    Route::post('/incoming-stocks/{stock}/complete', [IncomingStockController::class, 'markAsComplete'])->name('incoming_stocks.complete');
    // ユーザーダッシュボード
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');

    // 商品管理
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/load', [ProductController::class, 'loadMore'])->name('products.load');

    // 在庫管理
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{inventory}', [InventoryController::class, 'show'])->name('inventory.show');
    Route::get('/inventory/{inventory}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{inventory}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{inventory}', [InventoryController::class, 'destroy'])->name('inventory.destroy');

    // 在庫登録 (カスタムルート)
    Route::post('/inventory/store', [InventoryController::class, 'store'])->name('inventory.store');

    // 商品を持ち出すルート
    Route::post('/products/{product}/reduce', [ProductController::class, 'reduce'])->name('products.reduce');

    // 入荷予定を在庫に反映するルート (手動実行用)
    Route::post('/inventory/reflect-stock', [InventoryController::class, 'reflectStock'])->name('inventory.reflectStock');
    
    Route::get('/incoming-stocks/{stock}/edit', [IncomingStockController::class, 'edit'])->name('incoming_stocks.edit');
    Route::put('/incoming-stocks/{stock}', [IncomingStockController::class, 'update'])->name('incoming_stocks.update');
});
