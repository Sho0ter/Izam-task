<?php

namespace App\Repository;

use App\Events\OrderProcessed;
use App\Models\Order;
use App\Models\User;
use App\Repository\Contracts\OrderRepositoryInterface;
use App\Repository\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class OrderRepository implements OrderRepositoryInterface
{
    public function find(int $id): Order
    {
        return Order::findOrFail($id);
    }


    public function findByUser(int $id, User $user): Order
    {
        return Order::byUser($user->id)->findOrFail($id);
    }

    public function all(): \Illuminate\Support\Collection
    {
        return Order::all();
    }

    public function allByUser(User $user): \Illuminate\Support\Collection
    {
        return Order::byUser($user->id)->get();
    }

    public function cart(User $user): Order
    {
        $order = $user->orders()->cart()->firstOrNew([
            'user_id' => $user->id,
            'status' => 'cart',
            'total_price' => 0,
            ]);
        $order->save();
        return $order;
    }

    public function create(Order $order, User $user): array
    {
        $order = Order::byUser($user->id)->cart()->find($order->id);

        if (!$order) {
            return ['message' => 'Order not found','status' => Response::HTTP_NOT_FOUND];
        }

        // validate order products count
        $orderProducts = $order->products()->get();
        if ($orderProducts->count() == 0) {
            return ['message' => 'Order is empty','status' => Response::HTTP_BAD_REQUEST];
        }

        //validate order products stock
        $productsOutStock = [];
        foreach ($orderProducts as $orderProduct) {
            if ($orderProduct->pivot->quantity > $orderProduct->quantity) {
                $productsOutStock[] = $orderProduct->name;
            }
        }

        if (count($productsOutStock) > 0) {
            return ['message' => "Order product " . implode(',', $productsOutStock) . " stock is not enough","status" => Response::HTTP_BAD_REQUEST];
        }

        $total = $order->products->sum(function ($product) {
            return $product->pivot->total;
        });

        DB::beginTransaction();
        try {

            $this->update($order, [
                'status' => 'pending',
                'total_price' => $total,
            ]);

            // decrease product stock
            $productRepository = app(ProductRepositoryInterface::class);
            foreach ($orderProducts as $orderProduct) {
                $productRepository->decrementQuantity($orderProduct, $orderProduct->pivot->quantity);
            }

            DB::commit();
            event(new OrderProcessed($order));
        } catch (\Exception $e) {
            DB::rollBack();
            return ['message' => 'Order failed to create','status' => Response::HTTP_BAD_REQUEST];
        }

        return ['message' => 'Order created successfully','status' => Response::HTTP_OK];
    }

    public function update(Order $order, array $data): Order
    {
        $order->update($data);
        return $order;
    }

    public function delete(Order $order, User $user): array
    {
        $order = $this->findByUser($order->id, $user);
      
        if (!$order) {
            return ['message' => 'Order not deleted','status' => Response::HTTP_NOT_FOUND];
        }
        
        DB::beginTransaction();
        try {
            $productRepository = app(ProductRepositoryInterface::class);
            // increase product stock   
            $orderProducts = $order->products()->get();
            foreach ($orderProducts as $orderProduct) {
                $productRepository->incrementQuantity($orderProduct, $orderProduct->pivot->quantity);
            } 
            $order->delete();
            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollBack();
            return ['message' => 'Order not deleted','status' => Response::HTTP_BAD_REQUEST];   
        }

        return ['message' => 'Order deleted successfully','status' => Response::HTTP_OK];
    }
}
