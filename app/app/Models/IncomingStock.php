<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingStock extends Model
{

    // 一括代入可能な属性を指定
    protected $fillable = [
        'product_id',
        'income_date',
        'quantity',
        'status',
        'weight',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
