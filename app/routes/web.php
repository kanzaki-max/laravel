<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;

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

// 未認証のユーザーに対して /home ルートにアクセスするとログイン画面にリダイレクト
Route::get('/', function () {
    return redirect('login'); 
})->name('home');

Route::middleware('auth')->get('/home', function () {
    return redirect(auth()->user()->role === 'admin' ? '/admin/dashboard' : '/user/dashboard');
});

// 管理者ダッシュボード
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard')->middleware('auth');

// 一般ユーザーダッシュボード
Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard')->middleware('auth');

Route::resource('products', ProductController::class)->middleware('auth');

Route::resource('inventory', InventoryController::class)->middleware('auth');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/user/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/user', [UserController::class, 'store'])->name('users.store');
});

Route::resource('categories', CategoryController::class);

Route::get('products', [ProductController::class, 'index'])->name('products.index');