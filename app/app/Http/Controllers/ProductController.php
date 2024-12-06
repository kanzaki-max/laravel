<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\IncomingStock;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // 商品名の検索
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // カテゴリ検索
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // 入荷日検索
        if ($request->filled('arrival_date')) {
            $query->whereHas('incomingStocks', function ($subQuery) use ($request) {
                $subQuery->where('income_date', $request->arrival_date); 
            });
        }

        $products = $query->paginate(10);
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all(); 
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // バリデーション
    // $request->validate([
    //         'name' => 'required|string|max:255',
    //         'category_id' => 'required|exists:categories,id',
    //         'quantity' => 'required|integer|min:1',
    //         'weight' => 'required|numeric|min:0',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

        $filePath = null;
        if ($request->hasFile('image')) {
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $filePath = $request->file('image')->storeAs('uploads/products', $fileName, 'public');
        }

        Product::create(array_merge($request->all(), ['image' => $filePath]));
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // バリデーション
        // $validated = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'category_id' => 'required|exists:categories,id',
        //     'quantity' => 'required|integer|min:0',
        //     'weight' => 'required|numeric|min:0',
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        // ]);
        $data = $request->only(['name', 'category_id', 'quantity', 'weight', 'image']);

        // 画像処理
        if ($request->hasFile('image')) {
            // 古い画像を削除
            if ($product->image) {
                \Storage::delete('public/uploads/products' . $product->image);
            }

            // 新しい画像を保存
            $path = $request->file('image')->store('uploads/products', 'public');
            $data['image'] = $path;
        }

        // データ更新
        $product->update($data);

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index');
    }

    public function reduce(Request $request, Product $product)
    {
        $quantityToReduce = $request->input('quantity');
        $weightToReduce = $request->input('weight');

        // 在庫数をマイナスする
        if ($product->quantity >= $quantityToReduce && $product->weight >= $weightToReduce) {
            $product->quantity -= $quantityToReduce;
            $product->weight -= $weightToReduce;
            $product->save();

            session(['outgoing' => [
                'quantity' => $quantityToReduce,
                'weight' => $weightToReduce,
            ]]);

            return redirect()->route('products.show', $product->id);
        } else {
            return redirect()->route('products.show', $product->id);
        }
    }

    public function loadMore(Request $request)
    {
        
        $query = Product::query();

        // 検索条件を適用
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
    
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
    
        if ($request->filled('arrival_date')) {
            $query->whereHas('incomingStocks', function ($subQuery) use ($request) {
                $subQuery->where('income_date', $request->arrival_date);
            });
        }
    
        // ページ番号に基づいてスキップと取得するレコード数を指定
        // $products = $query->skip($request->page * 10)->take(10)->get();  // 10件ずつ取得
        $products = $query->skip(($request->page - 1) * 10)->take(10)->get();  // 1ベースのページの場合

        // dd($products);
    
        if ($products->isEmpty()) {
            // データがなければ空のレスポンスを返す
            return response()->json(['message' => 'No more products available.'], 404);
        }
    
        return view('products.partials.product-list', compact('products'))->render();
    }
}