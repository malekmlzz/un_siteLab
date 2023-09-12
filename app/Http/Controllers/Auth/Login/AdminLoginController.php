<?php

namespace App\Http\Controllers\Auth\Login;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminLoginController extends Controller
{
    public function login(Request $request)
    {
        $credentilas = $request->only('email', 'password');
        $vrefiyAdmin = User::where('email', $request->email)->first();
        if ($vrefiyAdmin) {
            if ($vrefiyAdmin->role == 'admin') {
                try {
                    $token = JWTAuth::attempt($credentilas);
                    return response()->json([
                        'token' => $token,
                    ], 400);
                } catch (JWTException $e) {
                    return response()->json($e, 400);
                }
            } else {
                return response()->json([
                    'massege' => 'این حساب ادمین نمی باشد!',
                ]);
            }
        } else {
            return response()->json([
                'massege' => 'کاربر موجود نمیباشد',
            ]);
        }
        
    }
}
