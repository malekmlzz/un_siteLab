<?php

namespace App\Http\Controllers\Auth\Login;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LabDocterSonoLoginController extends Controller
{
    public function login(Request $request)
    {
        // Login Docters
        if ($request->national_code) {
            $credentilas = $request->only('national_code', 'password');

            if (!JWTAuth::attempt($credentilas)) {
                return response()->json(['error' => 'حساب کاربری موجود نیست'], 401);
            }
<<<<<<< HEAD
=======
            $user = Auth::user();
            if (!$user->is_approved) {
                return response()->json([
                    'massege' => 'حساب کاربری تایید نشده است'
                ] , 401);
            }
>>>>>>> develop
            $token = JWTAuth::attempt($credentilas);
            return response()->json([
                'token' => $token,
                'message' => 'ورود با موفقیت انجام شد'
            ], 200);

            // login laboratory and Sonograpy
        } elseif ($request->center_number) {
<<<<<<< HEAD
=======
            $validate = Validator::make($request->all(), [
                'center_number' => ['required'],
                'password' => ['required'],
            ]);
            if ($validate->fails()) {
                return response()->json([
                    'message' => $validate->errors()->first(),
                ]);
            }
>>>>>>> develop
            $credentilas = $request->only('center_number', 'password');


            if (!JWTAuth::attempt($credentilas)) {
                return response()->json(['error' => 'حساب کاربری موجود نیست'], 401);
            }
<<<<<<< HEAD
=======
            $user = Auth::user();
            if (!$user->is_approved) {
                return response()->json([
                    'massege' => 'حساب کاربری تایید نشده است'
                ] , 401);
            }
>>>>>>> develop
            $token = JWTAuth::attempt($credentilas);
            return response()->json([
                'token' => $token,
                'message' => 'ورود با موفقیت انجام شد'
            ], 200);

            // try {
            //     $token = JWTAuth::attempt($credentilas);
            //     return response()->json([
            //         'token' => $token,
            //     ], 400);

            // } catch (JWTException $e) {
            //     return response()->json($e, 400);
            // }
        }
    }
}
