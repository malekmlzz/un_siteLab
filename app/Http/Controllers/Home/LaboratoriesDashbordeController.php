<?php

namespace App\Http\Controllers\Home;

use Kavenegar;
use ZipArchive;
use App\Models\Patient;
use FilesystemIterator;
use PharIo\Manifest\Url;
use Morilog\Jalali\Jalalian;
use App\Utilities\ImageUploader;
use Illuminate\Http\Client\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ExperimentsRequest;
use Illuminate\Support\Carbon;
use RecursiveIteratorIterator;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;

class LaboratoriesDashbordeController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $experimets = Patient::where('lab_name', $user->full_name)->paginate(10);
        $patientexperimet = [];
        foreach ($experimets as $experimet) {
            $jalaliDatepatient = Jalalian::fromDateTime($experimet->created_at);
            $downloadLink = $this->downloadSorce($experimet->id);
            // اطلاعات تبدیل شده را به آرایه $jalaliDates اضافه کنید
            $patientexperimet[] = [
                'id' => $experimet->id,
                'experiment_name' => $experimet->experiment_name,
                'national_code' => $experimet->national_code,
                'mobile' => $experimet->mobile,
                'experiment_file' => $experimet->experiment_file,
                'lab_name' => $experimet->lab_name,
                'created_at' => $jalaliDatepatient->format('Y/m/d'),
                'downloadLink' => $downloadLink,
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

    public function sendExperimetForPatient($patient)
    {
        try {
            $receptor = $patient->mobile;

            $token = $this->downloadSorce($patient->id);
            dd($token);
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


    public function store(ExperimentsRequest $request)
    {
        $validatData = $request->validated();
        $currentDate = Carbon::today()->toDateString();

        $basepath = 'experiments/' . $currentDate . $validatData['national_code'] . '/';
        if (!file_exists($basepath)) {
            mkdir($basepath, 0755, true);
        }
        $files = $request->file('experiment_file');
        $uploadedFiles = [];
        foreach ($files as $index => $file) {
            $originalFileName = $file->getClientOriginalName();
            $cleanedFileName = str_replace(' ', '', $originalFileName);
            $sourceFilePath = $basepath . 'experiment' . $cleanedFileName;
            ImageUploader::Upload($file, $sourceFilePath, 'public');
            $uploadedFiles[] = $sourceFilePath; // ذخیره مسیرهای فایل‌ها در آرایه
        }
        $patient = new Patient();
        $patient->experiment_name = $validatData['experiment_name'];
        $patient->national_code = $validatData['national_code'];
        $patient->mobile = $validatData['phon_number'];
        $patient->experiment_file = $basepath;
        $patient->lab_name = Auth::user()->full_name;
        $patients = $patient->save();

        $jalaliDatepatient = Jalalian::fromDateTime($patient->created_at);
        $patient->created_at = $jalaliDatepatient->format('Y/m/d');

        if ($patients) {
            $this->sendExperimetForPatient($patient);
            return response()->json([
                'data' => $patient,
            ], 200);
        }
        return response()->json([
            'error' => 'در بارگذاری فایل مشکلی پیش آمده است'
        ], 400);
    }
}
