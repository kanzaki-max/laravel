<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Inventory extends Model
{
    // use HasFactory;

    // 対応するテーブル名を指定
    protected $table = 'inventories';

    // 更新可能なカラムを指定
    protected $fillable = [
        'product_id',  // 商品ID
        'store_id',    // 店舗ID
        'quantity',    // 在庫数
        'weight',      // 重量
    ];

    // 商品リレーション
    public function product()
    {
        return $this->belongsTo(App\Models\Product::class);
    }

    // 店舗リレーション
    public function store()
    {
        return $this->belongsTo(App\Models\Store::class);
    }
}
