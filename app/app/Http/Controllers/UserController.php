<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view('user.dashboard');
    }

    public function create()
    {
        return view('user.create');  // ユーザー登録画面の表示
    }

    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,employee',
        ]);

        // 新しいユーザーの作成
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),  // パスワードをハッシュ化
            'role' => $request->role,  // 役割の設定
        ]);

        return redirect()->route('admin.dashboard');
    }
}
