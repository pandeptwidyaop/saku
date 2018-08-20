<?php

namespace App\Libraries;

use Storage;
use Image;

/**
 * Class Upload Untuk upload Document, Image, dan lain lain
 */

class Upload
{

  public static function file($file, $folder, $name = null)
  {
    $name = ($name == null) ? $file->hashName() : ($name.'.'.$file->getClientOriginalExtension());
    // $name = $folder.'/'.$name;
    Storage::disk('public')->putFileAs($folder,$file,$name);
    return $folder.'/'.$name;
  }

  public static function img($file, $folder, $name = null, $width = 1400 , $height = 500)
  {
    $myname = ($name == null) ? $file->hashName() : ($name.'.'.$file->getClientOriginalExtension());
    $myfile = $folder.'/'.$myname;
    $img = Image::make($file)->fit($width,$height, function($const){
      $const->upSize();
    });
    Storage::disk('public')->put($myfile,$img->stream());
    return $myfile;
  }

}
