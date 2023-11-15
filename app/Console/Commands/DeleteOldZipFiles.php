<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\File;

class DeleteOldZipFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:old-zip-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old zip files from public directory';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        // // تعیین مسیر دایرکتوری
        // $directoryPath = public_path('storage/experiments/');

        // // تعیین دوره زمانی مورد نظر (در اینجا مثال: حذف فایل‌های قدیمی‌تر از 2 روز)
        // $cutoffDate = now()->subDays(2);

        // // حذف فایل‌های قدیمی‌تر از تاریخ مقرر
        // foreach (File::files($directoryPath) as $file) {
        //     if (File::lastModified($file) < $cutoffDate->timestamp) {
        //         File::delete($file);
        //         $this->info('File deleted: ' . $file);
        //     }
        // }

        // $this->info('Old zip files have been deleted.');
        // return 0;
    }
}
