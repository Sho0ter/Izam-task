<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'quantity',
        'category_id',
    ];

    public function category()
    {
        return  $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product') 
        ->using(OrderProduct::class)
        ->withPivot('quantity','price','total','created_at','updated_at')
        ->withTimestamps();
    }
    
}
