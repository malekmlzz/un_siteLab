<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordCnotroller extends Controller
{
    public function changePassword(Request $request)
    {   
        $user = Auth::user();
        $request->validate([
            'old_password' => 'required',
           'new_password' => 'required|min:8|confirmed',
        ]);
        dd($request->new_password);
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'massege' => 'رمز عبور قدیمی اشتباه است ',
            ], 400);
        } else { 
       $updatepassword = $user->update([
            'password' => Hash::make($request->new_password),
         ]);
         return response()->json([
            'massege' => 'رمز با موفقیت تغییر یافت ',
        ], 400);
        }
    }
}
