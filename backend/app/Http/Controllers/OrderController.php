<?php

namespace App\Http\Controllers;
 
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Repository\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Order::class, 'order');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderRepository = app(OrderRepositoryInterface::class);
        $orders = $orderRepository->allByUser(auth()->user());
       
        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Order $order)
    {
        Gate::authorize('storeOrder', [$order]);

       $orderRepository = app(OrderRepositoryInterface::class);
       $ressult = $orderRepository->create($order, auth()->user());
       $order = $orderRepository->findByUser($order->id, auth()->user());
       return response()->json([    
           'message' => $ressult['message'],
           'data' => new OrderResource($order),
       ],  $ressult['status']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $orderRepository = app(OrderRepositoryInterface::class);
        $order = $orderRepository->findByUser($order->id, auth()->user());
        if(!$order){
            return response()->json([
                'message' => 'Order not belongs to you',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'data' => new OrderResource($order),
        ], Response::HTTP_OK);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $orderRepository = app(OrderRepositoryInterface::class);
        $ressult = $orderRepository->delete($order, auth()->user());
    
        return response()->json([
            'message' => $ressult['message'],
        ], $ressult['status']);
    }
}
