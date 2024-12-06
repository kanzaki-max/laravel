<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncomingStock;

class IncomingStockController extends Controller
{
    public function index()
    {
        $incomingStocks = IncomingStock::with(['product'])->orderBy('income_date', 'asc')->get();
        return view('incoming_stock.index', compact('incomingStocks'));
    }

    public function markAsComplete(Request $request, $stockId)
    {
        $stock = IncomingStock::with('product')->findOrFail($stockId);

        if ($stock->status === 'completed') {
            return redirect()->route('incoming_stocks.index');
        }

        // 商品の在庫数に反映
        $product = $stock->product;
        $product->quantity += $stock->quantity;
        $product->weight += $stock->weight;
        $product->save();

        // ステータスを「完了」に変更
        $stock->status = 'completed';
        $stock->save();

        // $stock->delete();

        return redirect()->route('incoming_stocks.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'weight' => 'required|numeric|min:1',
            'income_date' => 'required|date',
        ]);

        $validated['weight'] = $validated['weight'] ?? 0.00;

        IncomingStock::create($validated);

        return redirect()->route('incoming_stocks.index');
    }

    public function destroy($stockId)
    {
        $stock = IncomingStock::findOrFail($stockId);

        if ($stock->status !== 'completed') {
        return redirect()->route('incoming_stocks.index');
        }

        $stock->delete();

        return redirect()->route('incoming_stocks.index');
    }

    public function edit($stockId)
    {
        $stock = IncomingStock::findOrFail($stockId);
        return view('incoming_stock.edit', compact('stock'));
    }

    public function update(Request $request, $stockId)
    {
        $stock = IncomingStock::findOrFail($stockId);

        $stock->income_date = $request->input('income_date');
        $stock->quantity = $request->input('quantity');
        $stock->weight = $request->input('weight');
        $stock->save();

        return redirect()->route('incoming_stocks.index');
    }
}
