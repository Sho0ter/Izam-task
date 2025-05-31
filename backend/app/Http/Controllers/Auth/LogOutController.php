<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class LogOutController extends Controller
{
    public function logOut()
    {
        auth()->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout successful'], Response::HTTP_OK);
    }
}