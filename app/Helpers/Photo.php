<?php
namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


class Photo
{
    
    public static function uploadImage($file, $destinationPath)
    {
        $imageName = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($destinationPath), $imageName);

        return $imageName;
    }
    //if need image resize and custom image this code use
    // public static function uploadImage($file, $destinationPath){
    // $imageName = time() . '.' . $file->getClientOriginalExtension();
    // $image = Image::make($file)->fit(1000, 1000)->encode();

    // // Create the directory if it doesn't exist
    // if (!file_exists(public_path($destinationPath))) {
    //     mkdir(public_path($destinationPath), 0755, true);
    // }

    // // Store the image in the specified directory within the public folder
    // $imagePath = public_path($destinationPath . $imageName);
    // file_put_contents($imagePath, $image);

    // return $imageName;
    // }

    public static function deleteImage($imagePath)
    {
        if (File::exists(public_path($imagePath))) {
            File::delete(public_path($imagePath));
        }
    }
}

