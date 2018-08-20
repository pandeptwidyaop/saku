<?php

namespace App\Libraries;

use Session;

/**
 * Alert Session
 */
class Alert
{
  public static function new($type,$msg)
  {
    return Session::flash('alert',['type' => $type, 'msg' => $msg]);
  }

  public static function have()
  {
    return Session::has('alert');
  }

  public static function type()
  {
    return Session::get('alert')['type'];
  }

  public static function msg()
  {
    return Session::get('alert')['msg'];
  }

}
