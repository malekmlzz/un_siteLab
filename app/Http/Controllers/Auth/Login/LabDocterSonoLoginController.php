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
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            $token = JWTAuth::attempt($credentilas);
            return response()->json([
                'token' => $token,
                'message' => 'ورود با موفقیت انجام شد'
            ], 200);

            // login laboratory and Sonograpy
        } elseif ($request->center_number) {
            $credentilas = $request->only('center_number', 'password');


            if (!JWTAuth::attempt($credentilas)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
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
