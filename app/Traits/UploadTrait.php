<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Image;

trait UploadTrait
{
    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : str_random(25);

        $file = $uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->getClientOriginalExtension(), $disk);

        return $file;
    }


    public function uploadResize(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $destinationPath = 'public'.$folder;
        if (!file_exists($destinationPath)) {
            Storage::disk('local')->makeDirectory($destinationPath);
        }
        $path = storage_path().'/app/public'. $folder;
        $img = Image::make($uploadedFile->getRealPath());
        $img->resize(800, 600, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path. $filename.'.'.$uploadedFile->getClientOriginalExtension());
        return $img;
    }


    public function deleteOne($folder = null, $disk = 'public', $filename = null)
    {
        Storage::disk($disk)->delete($folder.$filename);
    }
}