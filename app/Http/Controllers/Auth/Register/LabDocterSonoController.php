<?php

namespace App\Http\Controllers\Auth\Register;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LabDocterSonoController extends Controller
{
    
    public function register(Request $request)
    {
        if ($request->role == 'docter') {
            $user = new User([
                'full_name' => $request->full_name,
                'national_code' => $request->national_code,
                'docter_code' => $request->docter_code,
                'phone_number' => $request->phone_number,
                'password' => $request->password,
                'role' => 'docter',
            ]);
            $user->save();
            // return Json Response for user
            return response()->json([
                'status' => 'ثبت نام شما با موفقیت انجام شد وقتی حساب شما تایید شد به شما اطلاع میدهیم',
            ], 200);

            //register laboratory
        } elseif ($request->role == 'laboratory') {
            $user = new User([
                'full_name' => $request->full_name,
                'center_number' => $request->center_number,
                'phone_number' => $request->phone_number,
                'password' => $request->password,
                'role' => 'laboratory',
            ]);

            $user->save();

            // return Json Response for user
            return response()->json([
                'status' => 'ثبت نام شما با موفقیت انجام شد وقتی حساب شما تایید شد به شما اطلاع میدهیم',
            ], 200);
        } elseif ($request->role == 'sonography') {
            $user = new User([
                'full_name' => $request->full_name,
                'center_number' => $request->center_number,
                'phone_number' => $request->phone_number,
                'password' => $request->password,
                'role' => 'sonography',
            ]);

            $user->save();

            // return Json Response for user
            return response()->json([
                'status' => 'ثبت نام شما با موفقیت انجام شد وقتی حساب شما تایید شد به شما اطلاع میدهیم',
            ], 200);
        }
    }
}
