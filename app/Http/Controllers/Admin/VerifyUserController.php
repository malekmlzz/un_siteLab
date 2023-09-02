<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kavenegar;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;

class VerifyUserController extends Controller
{
    public function verifyUser($user_id)
    {
        $user = User::find($user_id);
        if ($user->is_approved == 1) {
            $UpdateUser0 = $user->update([
                'is_approved' => 0,
            ]);
        } else {
            $UpdateUser1 = $user->update([
                'is_approved' => 1,
            ]);
        }
        if ($UpdateUser1) {
            try {
                $sender = "1000630006300";        //This is the Sender number
                $message = 'حساب کاربری شما در سامانه یکپارچه تشخیصی تایید شد . اکنون می توانید وارد شوید';       //The body of SMS

                //Receptors numbers
                $result = Kavenegar::Send($sender, $user->mobile, $message);
            } catch (ApiException $e) {
                // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
                echo $e->errorMessage();
            } catch (HttpException $e) {
                // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
                echo $e->errorMessage();
            }
        } else {
            return response()->json([
                'پیام' => '!!حساب کاربری تایید نشد',
            ]);
        }
    }
}
