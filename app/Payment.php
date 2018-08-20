<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Payment extends Model
{
  use Uuid;
  use LogsActivity;

  protected $fillable = ['title','administrator_id','nominal','date'];
  protected static $logAttributes = ['title','administrator_id','nominal','date'];

  public $incrementing = false;

  public function Administrator()
  {
    return $this->belongsTo('App\Administrator');
  }

  public function Memberpayment()
  {
    return $this->hasMany('App\Memberpayment');
  }
}
