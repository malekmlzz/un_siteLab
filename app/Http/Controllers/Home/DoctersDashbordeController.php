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
        $jalali_start_date = Verta::instance()->toCarbon($start_data)->format('Y-m-d');
        $jalali_end_date = Verta::instance()->toCarbon($end_data)->format('Y-m-d');

        $patients = Patient::where('national_code', $request->national_code)
            ->whereBetween('created_at', [$jalali_start_date, $jalali_end_date])
            ->get();

        $patientexperimet = [];

        foreach ($patients as $patient) {

            $patientexperimet[] = [
                'id' => $patient->id,
                'experiment_name' => $patient->experiment_name,
                'national_code' => $patient->national_code,
                'mobile' => $patient->mobile,
                'experiment_file' => $patient->experiment_file,
                'lab_name' => $patient->lab_name,
                'created_at' => $patient->created_at,
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
