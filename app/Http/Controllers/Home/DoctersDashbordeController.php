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
        
        $star_data = $request->start_data;
        $end_data = $request->end_data;
        // تبدیل تاریخ شمسی به تاریخ میلادی
        $startDate1 = Jalalian::fromFormat('Y/m/d', $star_data)->toCarbon();
        $endDate2 = Jalalian::fromFormat('Y/m/d', $end_data)->toCarbon();
        // حالا $gregorianDate حاوی تاریخ میلادی است
        $patients = Patient::where('national_code', $request->national_code)->whereBetween('created_at', [$startDate1, $endDate2])->paginate(10);
        $patientexperimet = [];

        foreach ($patients as $patient) {
            $jalaliDatepatient = Jalalian::fromDateTime($patient->created_at);
            $downloadLink = $this->downloadSorce($patient->id);
            // اطلاعات تبدیل شده را به آرایه $jalaliDates اضافه کنید
            $patientexperimet[] = [
                'id' => $patient->id,
                'experiment_name' => $patient->experiment_name,
                'national_code' => $patient->national_code,
                'mobile' => $patient->mobile,
                'experiment_file' => $patient->experiment_file,
                'lab_name' => $patient->lab_name,
                'created_at' => $jalaliDatepatient->format('Y/m/d'),
                'downloadLink' => $downloadLink,
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
