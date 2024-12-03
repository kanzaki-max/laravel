<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        return view('users.dashboard');
    }

    public function adminIndex()
    {
        $users = User::all(); 
        return view('users.index', compact('users')); 
    }

    public function create()
    {
        return view('users.create');  // ユーザー登録画面の表示
    }

    public function store(Request $request)
    {
        // バリデーション
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:8|confirmed',
        //     'role' => 'required|in:admin,employee',
        // ]);

        // 新しいユーザーの作成
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),  // パスワードをハッシュ化
            'role' => $request->role,  // 役割の設定
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,employee',
        ]);

        $user = User::findOrFail($id);
        $user->update($validated);

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index');
    }
}
