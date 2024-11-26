<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * 管理者用のダッシュボード画面を表示
     */
    public function index()
    {
        return view('admin.dashboard'); // admin/dashboard.blade.php を表示
    }
}
