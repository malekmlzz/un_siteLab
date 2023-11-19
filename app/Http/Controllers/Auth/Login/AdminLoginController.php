<?php

namespace App\Http\Controllers\Auth\Login;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

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


        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
       
        $tokenResult = $user->createToken('access_token');

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ], 200)->withCookie(Cookie::make('access_token', $tokenResult->accessToken, 60, null, null, false, true));
    }


    public function profile()
    {
        $user = Auth::user();

        return response()->json([
            'user' => $user,
        ], 200);
    }
}
