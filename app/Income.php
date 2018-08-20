<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Income extends Model
{
  use Uuid;
  use LogsActivity;

  protected $fillable = ['title','administrator_id','total','description'];
  protected static $logAttributes = ['title','administrator_id','total','description'];

  public $incrementing = false;

  public function Administrator()
  {
    return $this->belongsTo('App\Administrator');
  }
}
