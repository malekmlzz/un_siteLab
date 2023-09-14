<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Kavenegar;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;

class VerifyUserController extends Controller
{
    public function verifyUser($user_id)
    {
        $user = User::find($user_id);
        if ($user->is_approved == 1) {
            return response()->json([
                'massege' => 'کاربر فعال می باشد'
            ], 200);
        } else {
            if ($user->role == 'docter') {
                $token = $user->national_code;
            } else {
                $token = $user->center_number;
            }
            $UpdateUser1 = $user->update([
                'is_approved' => 1,
            ]);
            if ($UpdateUser1) {
                $receptor = $user->phone_number;
                $token2 = $user->password;
                $token3 = "789";
                $template = "activeUser";
                $Updatepass = $user->update([
                    'password' => Hash::make($user->password),
                ]);
                try {

                    //Send null for tokens not defined in the template
                    //Pass token10 and token20 as parameter 6th and 7th
                    $result = Kavenegar::VerifyLookup($receptor, $token, $token2, $token3, $template, $type = null);
                } catch (\Kavenegar\Exceptions\ApiException $e) {
                    // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
                    echo $e->errorMessage();
                } catch (\Kavenegar\Exceptions\HttpException $e) {
                    // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
                    echo $e->errorMessage();
                }
            }
        }
    }
}
