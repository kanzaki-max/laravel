<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // 商品詳細画面表示
    public function show($id)
    {
        // 指定された商品を取得するコード
        $product = product::with('category')->findOrFail($id);

        return view('product.show', compact('product'));
    }
}
