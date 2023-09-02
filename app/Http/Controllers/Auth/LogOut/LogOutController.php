<?php

namespace App\Http\Controllers\Auth\logOut;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogOutController extends Controller
{
   public function logout()
   {
    Auth::logout();
    $token = JWTAuth::getToken();
    JWTAuth::invalidate($token);
    return response()->json([
        'message' => 'Successfully logged out',
    ]);
   }
}
