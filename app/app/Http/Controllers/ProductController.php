<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
// use App\Models\IncomingStock;


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

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('arrival_date')) {
            $query->whereHas('incomingStock', function ($query) use ($search) {
                $q->where('income_date', $request->arrival_date);
            });
        }

        $products = Product::all();
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
        // $validated = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'category_id' => 'required|exists:categories,id',
        //     'quantity' => 'required|integer|min:0',
        //     'weight' => 'required|numeric|min:0',
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        // ]);

        // $filePath = $product->image;
        if ($request->hasFile('image')) {
            if ($product->image){
                \Storage::delete($product->image);
            }

            $path = $request->file('image')->store('products');
            $product->image = $path;
        }

        $product->save();

        return redirect()->route('products.index');

        // $product = Product::findOrFail($id);
        // $product->update(array_merge($request->all(), ['image' => $filePath]));
        // $product->update($validated);
        // return redirect()->route('products.index');
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
}