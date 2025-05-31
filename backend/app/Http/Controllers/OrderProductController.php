<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderProduct\StoreOrderProductRequest;
use App\Models\Order;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\OrderProductResource;
use App\Models\Product;

class OrderProductController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderProductRequest $request, Order $order)
    {   
    
        $order = Order::byUser(auth()->user()->id)->cart()->findOrFail($order->id);
        if(!$order){
            return response()->json([
                'message' => 'Order not belongs to you or order is not in cart',
            ], Response::HTTP_NOT_FOUND);
        }
        
        $product = Product::findOrFail($request->validated()['product_id']);
       
        $orderProduct = $order->products()->wherePivot('product_id', $product->id)->first();
       
        if ($orderProduct) {
            $quantity = $request->validated()['quantity'] + $orderProduct->pivot->quantity;
            $order->products()->updateExistingPivot($product->id, [
                'quantity' => $quantity,
                'price' => $product->price,
                'total' => $product->price * $quantity,
            ]);
        } else {
            $order->products()->attach($product->id, [
                'quantity' => $request->validated()['quantity'],
                'price' => $product->price,
                'total' => $product->price * $request->validated()['quantity'],
            ]);
        }
        
        $orderProduct = $order->products()->wherePivot('product_id', $product->id)->first();
       
        return response()->json([
            'message' => 'Product added to order successfully',
            'data' => new OrderProductResource($orderProduct->pivot),
        ], Response::HTTP_CREATED); 
    }
}
        
        