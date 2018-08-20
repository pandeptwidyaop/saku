<?php

/**
 *
 */
namespace App\Libraries;

use Auth;
use Route;
use Request;
use Storage;
use Image;

class Helper
{

  public static function url($url = '/')
  {
    if (!Auth::check()) {
      return url('login');
    }
    $rt = '';
    $url = $url[0] == '/' ? $url : '/'.$url;
    $auth = Auth::user()->role;
    if ($auth == 'root') {
      $rt = $auth;
    }elseif ($auth == 'admin') {
      $rt = Auth::user()->Position();
    }
    return url($rt.$url);
  }

  public static function img($url)
  {
    $url = $url[0] == '/' ? $url : '/'.$url;
    return url('img'.$url);
  }

  public static function js($val=null)
  {
    return 'javascript:void(0);';
  }

  public static function set_active($uri, $output = 'active')
  {
   if (strrpos(Request::url(),$uri) !== false) {
    return $output;
   }
 }


  public static function del($filename,$disk='public')
  {
    Storage::disk($disk)->delete($filename);
  }
}
