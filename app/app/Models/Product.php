<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    protected $fillable = ['name', 'category_id', 'quantity', 'weight', 'image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function incomingStocks()
    {
        return $this->hasMany(IncomingStock::class, 'product_id');
    }
}



