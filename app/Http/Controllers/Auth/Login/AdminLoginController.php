<?php

namespace App\Http\Controllers\Auth\Login;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminLoginController extends Controller
{
    public function login(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->first(),
            ], 422);
        }
        $credentilas = $request->only('email', 'password');

        if (!JWTAuth::attempt($credentilas)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $token = JWTAuth::attempt($credentilas);
        return response()->json([
            'success' =>true,
         ],200)->cookie('jwt_token', $token,60,true,true);
    }
}
