<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repository\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        
        $orderRepository = app(OrderRepositoryInterface::class);
        $order = $orderRepository->cart($user); 
        $order->load('orderProducts.product');
       
        return response()->json(['message' => 'User created successfully',
        'user' => new UserResource($user),
        'order' =>  new OrderResource($order),
        'token' => $token], Response::HTTP_CREATED);
    }
}
