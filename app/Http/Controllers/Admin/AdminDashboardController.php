<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function adminDashborad()
    {
        $countDocter = User::where('role' , 'docter')->count();
        $countLaboratory = User::where('role' , 'laboratory')->count();
        $countSonograph = User::where('role' , 'sonography')->count();
        $countAdmin = User::where('role' , 'admin')->count();

        $Patient = Patient::all()->count();
        
       return response()->json([
            'countDocter' => $countDocter,
            'countLaboratory' => $countLaboratory,
            'countSonograph' => $countSonograph,
            'countAdmin' => $countAdmin,
            'Patient' => $Patient,
        ]  ,200);
    }
}
