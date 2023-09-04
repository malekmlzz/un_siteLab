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

class LaboratoriesDashbordeController extends Controller
{
    public function store(ExperimentsRequest $request)
    {

        $validatData = $request->validated();
        $patient = new Patient();
        $user = Auth::user();
        $files = array($request->experiment_file);

        try {
            foreach ($files as $key => $value) {
                $basepath = 'experiments/' . $validatData['national_code'] . '/';
                $sorcefilepath = $basepath . 'experiment' . $request->experiment_file->getClientOriginalName();
                ImageUploader::Upload($request->experiment_file, $sorcefilepath, 'local_storage');
    
            }
            $patient->national_code = $validatData['national_code'];
            $patient->mobile = $validatData['phon_number'];
            $patient->experiment_file = $basepath;
            $patient->lab_name = $user->full_name;
            $patients = $patient->save();

            if ($patients) {
                $this->sendExperimetForPatient($patient->id);

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
            $link = $this->downloadSorce($patient_id);
            $sender = "1000630006300";        //This is the Sender number
            $message = 'لینک دانلود نتیجه ازمایش :' . $link;        //The body of SMS

            //Receptors numbers
            $result = Kavenegar::Send($sender, $patient->mobile, $message);
        } catch (ApiException $e) {
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            echo $e->errorMessage();
        } catch (HttpException $e) {
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            echo $e->errorMessage();
        }
    }
}
