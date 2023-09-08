<?php

namespace App\Http\Controllers\Auth\Restpassword;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Kavenegar;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;
use Kavenegar\KavenegarApi;

class RestPasswordController extends Controller
{
    public function sendPasswordRestCode(Request $request)
    {
        if ($request->national_code) {
            $user = User::where('national_code', $request->national_code)->first();
        } elseif ($request->center_number) {
            $user = User::where('center_number', $request->center_number)->first();
        } else {
            return response()->json([
                'massege' => 'لطفا کد ملی یا کد ازمایشگاه وارد کنیید'
            ]);
        }

        if ($user) {
            try{
                $receptor = $user->mobile;
                $token = mt_rand(100000, 999999);
                $token2 = "456";
                $token3 = "789";
                $template="verify";
                //Send null for tokens not defined in the template
                //Pass token10 and token20 as parameter 6th and 7th
                $result = Kavenegar::VerifyLookup($receptor, $token, $token2, $token3, $template, $type = null);
                if($result){
                    
                    Cache::put('password_rest_code:' . $user->id, $token, now()->addMinute(2));
                    return response()->json([
                        'data' => $user,
                        'massege' => 'کد یکبار مصرف با موفقیت ارسال شد'
                    ]);

                }
            }
            catch(\Kavenegar\Exceptions\ApiException $e){
                // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
                echo $e->errorMessage();
            }
            catch(\Kavenegar\Exceptions\HttpException $e){
                // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
                echo $e->errorMessage();
            }
        } else {
            return response()->json([
                'massege' => 'حساب کاربری موجود نیست'
            ]);
        }
    }

    public function verifyPasswordRestCode(Request $request, $id)
    {
        $user = User::find($id);
        $code = $request->code;

        $cachedCode = Cache::get('password_rest_code:' . $user->id);
        if ($cachedCode === $code) {

            $user->password = Hash::make($request->password);
            $user->save();
            if ($user->password) {
                return response()->json([
                    'message' => 'رمز با موفقیت بازیابی شد'
                ]);
            }
        } else {
            return response()->json([
                'message' => 'کد وارد شده معتبر نمی باشد'
            ]);
        }
    }
}
