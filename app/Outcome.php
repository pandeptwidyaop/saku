<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Outcome extends Model
{
  use Uuid;
  use LogsActivity;

  protected $fillable = ['title','administrator_id','total','description','proof'];
  protected static $logAttributes = ['title','administrator_id','total','description','proof'];

  public $incrementing = false;

  public function Administrator()
  {
    return $this->belongsTo('App\Administrator');
  }
}
