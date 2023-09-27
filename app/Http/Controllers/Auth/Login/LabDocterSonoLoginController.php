<?php

namespace App\Http\Controllers\Auth\Login;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class LabDocterSonoLoginController extends Controller
{
    public function login(Request $request)
    {
        // Login Docters
        if ($request->national_code) {
            $validate = Validator::make($request->all(), [
                'national_code' => ['required', 'numeric'],
                'password' => ['required'],
            ]);
            if ($validate->fails()) {
                return response()->json([
                    'message' => $validate->errors()->first(),
                ] , 422);
            }

            $credentials = $request->only('national_code', 'password');

            if (!JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            $user = Auth::user();
            if (!$user->is_approved) {
                return response()->json(['error' => 'حساب کاربری تایید نشده است'], 401);
            }
            $accesstoken = JWTAuth::attempt($credentials);
           
            // cookie()->queue('jwt_token',$token,60,null,null,true,true);
            return response()->json([
                'success' =>true,
                'data'=> $accesstoken,
             ],200)->withCookie(cookie()->forever('jwt_token' , $accesstoken , 1440));   

            // login laboratory and Sonograpy
        } elseif ($request->center_number) {
           
            $validate = Validator::make($request->all(), [
                'center_number' => ['required'],
                'password' => ['required'],
            ]);
            if ($validate->fails()) {
                return response()->json([
                    'message' => $validate->errors()->first(),
                ] , 400);
            }

            $credentials = $request->only('center_number', 'password');
            if (!JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            $user = Auth::user();
            if (!$user->is_approved) {
                return response()->json(['error' => 'حساب کاربری تایید نشده است'], 401);
            }
            $accesstoken = JWTAuth::attempt($credentials);
            
            return response()->json([
                'success' =>true,
                'data'=> $accesstoken,
             ],200)->withCookie(cookie()->forever('jwt_token' , $accesstoken , 1440));   
        } else {
            return response()->json(['error' => 'فیلد نام کاربری نمی تواند خالی باشد'], 400);
        }
    }
}
