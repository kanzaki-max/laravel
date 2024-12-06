<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'category_id', 'quantity', 'weight', 'image'];

    // カテゴリリレーション
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 在庫リレーション
    public function incomingStocks()
    {
        return $this->hasMany(IncomingStock::class, 'product_id');
    }

    // 在庫合計を取得するアクセサ
    public function getTotalStockAttribute()
    {
        return $this->incomingStocks->sum('quantity');
    }
}



