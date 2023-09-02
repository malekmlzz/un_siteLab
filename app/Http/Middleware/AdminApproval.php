<?php

namespace App\Http\Middleware;

use Kavenegar;
use Closure;
use Exceptions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $user = User::where('national_code', $request->national_code)->first();
            if ($user->national_code) {
                if (!$user->is_approved) {
                    return response()->json([
                        'massege' => 'شما هنوز توسط ادمین تایید نشداید'
                    ]);
                } else {
                    return $next($request);
                }
            } else {
                return response()->json([
                    'massege' => 'شما هنوز ثبت نام نکرده اید'
                ]);
            }

            // اعتبار سنجی و چک کردن ثبت سونوگرافی و ازمایشگاه
        } elseif ($request->lab_code) {
            $user = User::where('lab_code', $request->lab_code)->first();
            if ($user->lab_code) {
                if (!$user->is_approved) {
                    return response()->json([
                        'massege' => 'شما هنوز توسط ادمین تایید نشداید'
                    ]);
                } else {
                    return $next($request);
                }
            } else {
                return response()->json([
                    'massege' => 'کد ازمایشگاه معتبر نیست'
                ]);
            }
        }
    }
}
