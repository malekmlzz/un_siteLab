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
                'data' =>$patients,
            ] , 200);
         }else
         {
            return response()->json([
                'message' => 'بیمار یافت  نشد',
            ] , 404);
         }
    }
}
