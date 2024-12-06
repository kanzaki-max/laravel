<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // カテゴリ一覧表示
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // カテゴリ追加画面の表示
    public function create()
    {
        return view('categories.create');
    }

    // カテゴリの登録処理
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        // カテゴリの保存
        Category::create($request->all());

        return redirect()->route('products.create');
    }

    // カテゴリ編集画面の表示
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // カテゴリの更新処理
    public function update(Request $request, Category $category)
    {
        // バリデーション
        // $request->validate([
        //     'name' => 'required|string|max:255|unique:categories,name,',
        // ]);

        // カテゴリの更新
        $category->update($request->all());

        return redirect()->route('categories.index');
    }

    // カテゴリ削除
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index');
    }
}
