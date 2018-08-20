<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Memberpayment extends Model
{
  use Uuid;
  use LogsActivity;

  protected $fillable = ['member_id','payment_id','status'];
  protected static $logAttributes = ['member_id','payment_id','status'];

  public $incrementing = false;

  public function Member()
  {
    return $this->belongsTo('App\Member');
  }

  public function Payment()
  {
    return $this->belongsTo('App\Payment');
  }
}
