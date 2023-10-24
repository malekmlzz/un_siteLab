<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

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
        $patients = Patient::where('national_code', $request->national_code)->whereBetween('created_at', [$startDate1, $endDate2])->get();
        if ($patients) {
            return response()->json([
                'data' => $patients,
            ], 200);
        } else {
            return response()->json([
                'message' => 'بیمار یافت  نشد',
            ], 404);
        }
    }
}
