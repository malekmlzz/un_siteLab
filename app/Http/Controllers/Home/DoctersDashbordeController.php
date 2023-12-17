<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Facades\Storage;
use Hekmatinasser\Verta\Facades\Verta;
class DoctersDashbordeController extends Controller
{
    public function serach(Request $request)
    {
        
        $start_data = $request->start_data;
        $end_data = $request->end_data;
         
        // تبدیل تاریخ شمسی به میلادی
        $jalali_start_date = Jalalian::fromFormat('Y/m/d', $start_data);
        $jalali_end_date = Jalalian::fromFormat('Y/m/d', $end_data);
        $gregorian_start_date = $jalali_start_date->toCarbon()->format('Y/m/d');
        $gregorian_end_date = $jalali_end_date->toCarbon()->format('Y/m/d');

        // تبدیل تاریخ شمسی به میلادی
        $jalali_start_date = Verta::instance()->toCarbon($start_data)->format('Y-m-d');
        $jalali_end_date = Verta::instance()->toCarbon($end_data)->format('Y-m-d');

        $patients = Patient::where('national_code', $request->national_code)
            ->whereBetween('created_at', [$gregorian_start_date, $gregorian_end_date])
            ->get();

        $patientexperimet = [];

        foreach ($patients as $patient) {
           
            $jalali_created = Jalalian::fromCarbon(\Carbon\Carbon::parse($patient->created_at));
            $jalali_created_String = $jalali_created->format('Y/m/d');

            $patientexperimet[] = [
                'id' => $patient->id,
                'experiment_name' => $patient->experiment_name,
                'national_code' => $patient->national_code,
                'mobile' => $patient->mobile,
                'experiment_file' => $patient->experiment_file,
                'lab_name' => $patient->lab_name,
                'created_at' => $jalali_created_String,
            ];
        }

        if ($patientexperimet) {
            return response()->json(['data' => $patientexperimet]);
        } else {
            return response()->json([
                'message' => 'بیمار یافت  نشد',
            ], 404);
        }
    }
}
