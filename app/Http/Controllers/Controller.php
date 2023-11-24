<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Patient;
use FilesystemIterator;
use ZipArchive;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function downloadSorce($id)
    {
        $patient = Patient::find($id);
        $nationalCode = $patient->national_code;
        $currentDate = $patient->created_at->toDateString();
        $zip = new ZipArchive;
        $zipFileName = random_int(1111, 9999) . 'sample.zip';

        $directoryPath = storage_path('app/public/experiments/' . $currentDate . $nationalCode . '/');
       
        if ($zip->open(public_path('experimentZip/'.$zipFileName), ZipArchive::CREATE) === TRUE) {
            
            $filesToZip = new FilesystemIterator($directoryPath);
            
            foreach ($filesToZip as $file) {
                // اطمینان حاصل کنید که $file یک فایل است (نه دایرکتوری)
                if ($file->isFile()) {
                    $zip->addFile($file->getPathname(), $file->getFilename());
                }
            }
            $zip->close();
            // ایجاد لینک دانلود با استفاده از asset
            $downloadLink = asset('experimentZip/'.$zipFileName);
            // بازگرداندن لینک دانلود
            return $downloadLink;
            //return response()->download(public_path($zipFileName))->deleteFileAfterSend(true);
        } else {
            return "Failed to create the zip file.";
        }
    }

    public function downloadexperiment($id)
    {
        $patient = Patient::find($id);
        $nationalCode = $patient->national_code;
        $currentDate = $patient->created_at->toDateString();
        $zip = new ZipArchive;
        $zipFileName = random_int(1111, 9999) . 'sample.zip';

        $directoryPath = storage_path('app/public/experiments/' . $currentDate . $nationalCode . '/');
        if ($zip->open(public_path('experimentZip/'.$zipFileName), ZipArchive::CREATE) === TRUE) {
           
            $filesToZip = new FilesystemIterator($directoryPath);
            
            foreach ($filesToZip as $file) {
                // اطمینان حاصل کنید که $file یک فایل است (نه دایرکتوری)
                if ($file->isFile()) {
                    $zip->addFile($file->getPathname(), $file->getFilename());
                }
            }
            $zip->close();
            // ایجاد لینک دانلود با استفاده از asset
            return response()->download(public_path('experimentZip/'.$zipFileName))->deleteFileAfterSend(true);

        } else {
            return "Failed to create the zip file.";
        }
    }
    
}
