<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Category;
use App\Models\IncomingStock;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventories = Inventory::with(['product', 'store'])->get();
        return view('inventory.index', compact('inventories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all(); 
        $products = Product::all();   
        return view('inventory.create', compact('categories', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'arrival_date' => 'required|date',
        ]);
    
        IncomingStock::create([
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'income_date' => $validated['arrival_date'], 
            'status' => 'pending',
        ]);
    
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inventory = IncomingStock::findOrFail($id);
        $products = Product::all();
        return view('inventory.edit', compact('inventory', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    $validated = $request->validate([
        'quantity' => 'required|integer|min:1',
        'income_date' => 'required|date',
    ]);

    $inventory = IncomingStock::findOrFail($id);
    $inventory->update($validated);

    return redirect()->route('products.index')->with('success', '在庫情報が更新されました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inventory = IncomingStock::findOrFail($id);
        $inventory->delete();
        
        return redirect()->route('products.index');
    }
}
