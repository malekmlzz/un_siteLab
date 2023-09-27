<?php

namespace App\Http\Controllers\Auth\Login;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $credentials = $request->only('email', 'password');


        if (!JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $accesstoken = JWTAuth::attempt($credentials);
        return response()->json([
            'success' =>true,
            'data'=> $accesstoken,
         ],200)->withCookie(cookie()->forever('access_token' , $accesstoken , 1440));


        // return response()->json([
        //     'success' =>true,
        //     'data'=> $accesstoken,
        //  ],200)->cookie('jwt_token', $token,config('jwt.ttl'),60,true,true);
    }
}
