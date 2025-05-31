<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function user()
    {
        return response()->json([
            'user' => new UserResource(auth()->user()),
        ], Response::HTTP_OK);
    }
}