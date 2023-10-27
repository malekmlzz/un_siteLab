<?php

namespace App\Http\Controllers\Auth\logOut;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LogOutController extends Controller
{
   public function logout()
   {
    Auth::user()->token()->revoke(); // ابطال توکن

    // منقضی کردن کوکی‌ها
    Cookie::queue(Cookie::forget('access_token'));

    return response()->json(['message' => 'شما با موفقیت خارج شده‌اید.']);
   }
}
