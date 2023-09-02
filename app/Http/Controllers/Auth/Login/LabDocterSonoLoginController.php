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

            try {
                $token = JWTAuth::attempt($credentilas);
                return response()->json([
                    'token' => $token,
                ], 400);
            } catch (JWTException $e) {
                return response()->json($e, 400);
            }

            // login laboratory and Sonograpy
        } elseif ($request->lab_code) {
            $credentilas = $request->only('lab_code', 'password');


            if (Auth::attempt($credentilas)) {
                $user = Auth::user();
                $token = JWTAuth::fromUser($user);
                return response()->json([
                    'token' => $token,
                ], 400);
            }
          response()->json(['error' => 'Unauthorized'] , 401);

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
