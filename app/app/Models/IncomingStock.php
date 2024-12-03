<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingStock extends Model
{

    // 一括代入可能な属性を指定
    protected $fillable = [
        'product_id',  // 商品ID
        'quantity',    // 数量
        'income_date', // 入荷予定日
        'status',      // ステータス
    ];

    // 商品リレーション
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
