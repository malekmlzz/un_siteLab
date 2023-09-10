<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class LabDocterSonoRegistration
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
        if ($request->role == 'docter') {
            $validator = Validator::make($request->all(), [
                'full_name' => 'required|max:255|string',
                'national_code' => 'required|numeric|unique:users',
                'docter_code' => 'required|unique:users',
                'phone_number' => 'required|numeric',
                'role' => 'required',
                'password' => 'required|min:8|max:255|confirmed',
            ]);
            if ($validator->fails()) {
                return response()->json([

                    'message' => $validator->errors()->first(),

                ], 400);
            }
            return $next($request);
        } elseif ($request->role == 'laboratory') {
            $validator = Validator::make($request->all(), [
                'full_name' => 'required|string|max:255',
                'phone_number' => 'required|numeric',
                'center_number' => 'required|unique:users',
                'password' => 'required|min:8|max:255|confirmed',
                'role' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([

                    'message' => $validator->errors()->first(),

                ], 400);
            }
            return $next($request);
        } elseif ($request->role == 'sonography') {
            $validator = Validator::make($request->all(), [
                'full_name' => 'required',
                'phone_number' => 'required|numeric',
                'center_number' => 'required|unique:users',
                'password' => 'required|min:8|max:255|confirmed',
                'role' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([

                    'message' => $validator->errors()->first(),

                ], 400);
            }
            return $next($request);
        } else {

            return response()->json([
                'message' => 'نقش انتخاب شده موجود نمی باشد'
            ]);
        }
    }
}
