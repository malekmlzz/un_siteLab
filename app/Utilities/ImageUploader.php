<?php

namespace App\Utilities ;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageUploader{


    public static function Upload($image , $path , $disctype)
    {
        Storage::disk($disctype)->put($path , File::get($image));
 
    }
}