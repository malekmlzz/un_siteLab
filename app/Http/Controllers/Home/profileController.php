<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class profileController extends Controller
{
    public function getUserInfo()
    {
        // دریافت اطلاعات کاربر جاری با توجه به توکن JWT
        $user = Auth::user();

        // ارسال اطلاعات به صورت ریسپانس
        return response()->json(['user' => $user]);
    }
}
