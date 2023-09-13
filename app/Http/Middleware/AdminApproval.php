<?php

namespace App\Http\Middleware;

use Kavenegar;
use Closure;
use Exceptions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminApproval
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // اعتبار سنجی و چک کردن ثبت نام پزشک
        if ($request->national_code) {
            $validate = Validator::make($request->all(), [
                'national_code' => ['required', 'numeric'],
                'password' => ['required'],
            ]);
            if ($validate->fails()) {
                return response()->json([
                    'message' => $validate->errors()->first(),
                ]);
            }
            $user = User::where('national_code', $request->national_code)->first();
            if ($user) {
                if (!$user->is_approved) {
                    return response()->json([
                        'massege' => 'حساب کاربری تایید نشده است'
                    ]);
                } else {
                    return $next($request);
                }
            } else {
                return response()->json([
                    'massege' => 'حساب کاربری موجود نیست'
                ]);
            }

            // اعتبار سنجی و چک کردن ثبت سونوگرافی و ازمایشگاه
        } elseif ($request->center_number) {
            if ($request->national_code) {
                $validate = Validator::make($request->all(), [
                    'center_number' => ['required'],
                    'password' => ['required'],
                ]);
                if ($validate->fails()) {
                    return response()->json([
                        'message' => $validate->errors()->first(),
                    ]);
                }
                $user = User::where('center_number', $request->center_number)->first();
                if ($user) {
                    if (!$user->is_approved) {
                        return response()->json([
                            'massege' => 'حساب کاربری تایید نشده است'
                        ]);
                    } else {
                        return $next($request);
                    }
                } else {
                    return response()->json([
                        'massege' => ' حساب کاربری موجود نیست'
                    ]);
                }
            }
        }
    }
}
