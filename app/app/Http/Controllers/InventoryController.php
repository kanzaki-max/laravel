<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    public function index()
    {
        // 在庫データの取得
        $inventories = Inventory::with(['product', 'store'])->get();

        return view ('inventory.index', compact('inventories'));
    }
}
