<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class DoctersDashbordeController extends Controller
{
    public function serach (Request $request)
    {
        // $patient = Patient::where('national_code' , $request->national_code)->get();

        
        $star_data =$request->start_data;
        $end_data = $request->end_data;
        $patients = Patient::where('national_code' , $request->national_code)->whereBetween('created_at' , [$star_data , $end_data])->get();
        // dd($patients);
         if($patients){
            return response()->json([
                'status' => 'success' ,
                'data' =>$patients,
            ]);
         }else
         {
            return response()->json([
                'status' => 'error' ,
                'message' => 'بیمار با این کد ملی پیدا نشد',
            ] , 404);
         }
    }
}
