<?php

namespace App\Http\Controllers\Home;

use Kavenegar;
use App\Models\Patient;
use App\Utilities\ImageUploader;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExperimentsRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Morilog\Jalali\Jalalian;
use PharIo\Manifest\Url;

class LaboratoriesDashbordeController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $experimets = Patient::where('lab_name', $user->full_name)->paginate(10);
        $patientexperimet = [];

        foreach ($experimets as $experimet) {
            $jalaliDatepatient = Jalalian::fromDateTime($experimet->created_at);
            // اطلاعات تبدیل شده را به آرایه $jalaliDates اضافه کنید
            $patientexperimet[] = [
                'id' => $experimet->id,
                'experiment_name' => $experimet->experiment_name,
                'national_code' => $experimet->national_code,
                'mobile' => $experimet->mobile,
                'experiment_file' => $experimet->experiment_file,
                'lab_name' => $experimet->lab_name,
                'created_at' => $jalaliDatepatient->format('Y/m/d'),
                'downloadLink' =>url('app/public/' . $experimet->experiment_file),
            ];
        }
        if ($patientexperimet) {
            return response()->json([
                'data' => $patientexperimet,
            ]);
        } else {
            return response()->json([
                'message' => 'ازمایشی ثبت نشده است',
            ], 404);
        }
    }
    public function store(ExperimentsRequest $request)
    {
        $validatData = $request->validated();
        $patient = new Patient();
        $user = Auth::user();
        $files[] = $request->file('experiment_file');

        try {
            $basepath = 'experiments/' . $validatData['national_code'] . '/';
            foreach ($files as  $file) {
                $originalFileName = $file->getClientOriginalName();
                $cleanedFileName = str_replace(' ', '', $originalFileName);
                $sorcefilepath = $basepath . 'experiment' . $cleanedFileName;
                ImageUploader::Upload($file, $sorcefilepath, 'public');
            }
            // اضافه کردن لینک دانلود به آبجکت Patient
            $patient->experiment_name = $validatData['experiment_name'];
            $patient->national_code = $validatData['national_code'];
            $patient->mobile = $validatData['phon_number'];
            $patient->experiment_file = $sorcefilepath;
            $patient->lab_name = $user->full_name;
            $patients = $patient->save();
            $jalaliDatepatient = Jalalian::fromDateTime($patient->created_at);
            $patient->created_at = $jalaliDatepatient->format('Y/m/d');
            //$downloadLink = Storage::url($patient->experiment_file);
            if ($patients) {
                $this->sendExperimetForPatient($patient);
                return response()->json([
                    'data' => $patient,
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'در بارگذاری فایل مشکلی پیش آمده است'
            ], 400);
        }
    }


    public function downloadSorce($id)
    {
        $patient = Patient::findOrFail($id);
        return response()->download(storage_path('app/public/' . $patient->experiment_file));
    }

    public function sendExperimetForPatient($patient)
    {
        try {
            $receptor = $patient->mobile;

            $token = url('app/public/' . $patient->experiment_file);
            $token2 = "";
            $token3 = "";
            $template = "sendExperiment";
            //Send null for tokens not defined in the template
            //Pass token10 and token20 as parameter 6th and 7th
            $result = Kavenegar::VerifyLookup($receptor, $token, $token2, $token3, $template, $type = null);

        } catch (\Kavenegar\Exceptions\ApiException $e) {
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            echo $e->errorMessage();
        } catch (\Kavenegar\Exceptions\HttpException $e) {
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            echo $e->errorMessage();
        }

    }
}
