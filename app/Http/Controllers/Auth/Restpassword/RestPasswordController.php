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


class RestPasswordController extends Controller
{
    public function sendPasswordRestCode(Request $request)
    {
        if ($request->national_code) {
            $user = User::where('national_code', $request->national_code)->first();
        } elseif ($request->lab_code) {
            $user = User::where('lab_code', $request->lab_code)->first();
        } else {
            return response()->json([
                'massege' => 'لطفا کد ملی یا کد ازمایشگاه وارد کنیید'
            ]);
        }
        if ($user) {
            $code = mt_rand(100000, 999999);
            try {
                $sender = "1000630006300";        //This is the Sender number
                $message = 'کد بازیابی رمز عبور شما در سامانه یکپارچه تشخیصی:' . $code;        //The body of SMS

                $receptor = $request->mobile;

                //Receptors numbers
                $result = Kavenegar::Send($sender, $receptor, $message);
            } catch (ApiException $e) {
                // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
                echo $e->errorMessage();
            } catch (HttpException $e) {
                // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
                echo $e->errorMessage();
            }
            Cache::put('password_rest_code:' . $user->id, $code, now()->addMinute(2));
            return response()->json([
                'data' => $user,
                'massege' => 'کد یکبار مصرف با موفقیت ارسال شد'
            ]);
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
