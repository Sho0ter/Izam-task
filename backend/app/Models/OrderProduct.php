<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\Product;
use App\Models\Order;

class OrderProduct extends Pivot
{
    protected $table = 'order_product';

    public $timestamps = true;
    
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price','total'];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeByProduct($query, $productId)
    {
        return $query->wherePivot('product_id', $productId);
    }

    public function scopeByOrder($query, $orderId)
    {
        return $query->wherePivot('order_id', $orderId);
    }
}
