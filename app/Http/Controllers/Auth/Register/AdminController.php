<?php

namespace App\Http\Controllers\Auth\Register;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminController extends Controller
{

    public function register(Request $request)
    {
        $user = new User([
            'name' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->save();

        // return Json Response for user
        return response()->json([
            'status' => 'با موفقیت ثبت شدید برای تایید ادمین منتطر بمانید',
        ], 201);
    }
}
