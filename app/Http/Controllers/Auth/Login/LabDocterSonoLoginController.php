<?php

namespace App\Http\Controllers\Auth\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

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
                ], 422);
            }

            $credentials = $request->only('national_code', 'password');

            if (!Auth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            $user = Auth::user();
            if (!$user->is_approved) {
                return response()->json(['error' => 'حساب کاربری تایید نشده است'], 401);
            }
            $tokenResult = $user->createToken('access_token');

            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
            ], 200)->withCookie(Cookie::make('access_token', $tokenResult->accessToken, 60, null, null, false, true));

            // login laboratory and Sonograpy
        } elseif ($request->center_number) {

            $validate = Validator::make($request->all(), [
                'center_number' => ['required'],
                'password' => ['required'],
            ]);
            if ($validate->fails()) {
                return response()->json([
                    'message' => $validate->errors()->first(),
                ], 400);
            }

            $credentials = $request->only('center_number', 'password');
            if (!Auth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            $user = Auth::user();
            if (!$user->is_approved) {
                return response()->json(['error' => 'حساب کاربری تایید نشده است'], 401);
            }
            $tokenResult = $user->createToken('access_token');

            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
            ], 200)->withCookie(Cookie::make('access_token', $tokenResult->accessToken, 60, null, null, false, true));
        } else {
            return response()->json(['error' => 'فیلد نام کاربری نمی تواند خالی باشد'], 400);
        }
    }
}
