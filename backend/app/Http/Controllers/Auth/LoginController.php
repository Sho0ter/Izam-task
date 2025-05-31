<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repository\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Facades\Hash;

use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{

    public function login(LoginUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if(!$user){
            return response()->json(['message' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }

        if (!Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }
       
        $token = $user->createToken('auth_token')->plainTextToken;

        $orderRepository = app(OrderRepositoryInterface::class);
        $order = $orderRepository->cart($user); 
        $order->load('orderProducts.product');
       
        return response()->json(['message' => 'Login successful',
            'user' => new UserResource($user),
            'token' => $token,
            'order' =>  new OrderResource($order),
        ],
            Response::HTTP_OK);
    }
}