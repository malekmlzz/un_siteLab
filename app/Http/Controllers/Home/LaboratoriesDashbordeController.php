<?php

namespace App\Http\Controllers\Home;

use Kavenegar;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Utilities\ImageUploader;
use App\Http\Controllers\Controller;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;
use App\Http\Requests\ExperimentsRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaboratoriesDashbordeController extends Controller
{
    public function store(ExperimentsRequest $request)
    {

        $validatData = $request->validated();
        $patient = new Patient();
        $user = Auth::user();
        $files[] = $request->file('experiment_file');
        try {
            foreach ($files as  $file) {
                $basepath = 'experiments/' . $validatData['national_code'] . '/';
                $sorcefilepath = $basepath . 'experiment' . $file->getClientOriginalName();
                ImageUploader::Upload($file, $sorcefilepath, 'local_storage');
            }

            $patient->experiment_name = $validatData['experiment_name'];
            $patient->national_code = $validatData['national_code'];
            $patient->mobile = $validatData['phon_number'];
            $patient->experiment_file = $sorcefilepath;
            $patient->lab_name = $user->full_name;
            $patients = $patient->save();

            if ($patients) {
                // $this->sendExperimetForPatient($patient->id);

                return response()->json([
                    'data' => $patient,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'در بارگذاری فایل مشکلی پیش امده است '
            ], 400);
        }
    }

    public function downloadSorce($id)
    {

        $patient = Patient::findOrFail($id);
        return response()->download(storage_path('app/local_storage/' . $patient->experiment_file));
    }


    public function sendExperimetForPatient($patient_id)
    {
        $patient = Patient::find($patient_id);
        try {
            $url = Storage::url('app/local_storage/' . $patient->experiment_file);
            $receptor = $patient->mobile;
            $token = $url;
            $token2 = "44";
            $token3 = "789";
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
