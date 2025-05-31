<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'status',
        'total_price',
    ];
    public function products()
    {
        return $this->belongsToMany(Product::class)
        ->using(OrderProduct::class)
        ->withPivot('quantity','price','total','created_at','updated_at')
        ->withTimestamps();
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
    public function scopeCart($query)
    {
        return $query->where('status', 'cart');
    }   

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }   
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    } 
    public function scopeByUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }     

}
