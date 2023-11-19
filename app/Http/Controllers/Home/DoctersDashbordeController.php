<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Facades\Storage;

class DoctersDashbordeController extends Controller
{
    public function serach(Request $request)
    {

        $start_data = $request->start_data;
        $end_data = $request->end_data;

        $patients = Patient::where('national_code', $request->national_code)
            ->whereBetween('created_at', [$start_data, $end_data])
            ->get();

        $patientexperimet = [];

        foreach ($patients as $patient) {
            // اطلاعات تبدیل شده را به آرایه $jalaliDates اضافه کنید
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
