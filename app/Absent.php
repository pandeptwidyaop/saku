<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Absent extends Model
{
    use Uuid;
    use LogsActivity;

    protected $fillable = [
      'administrator_id','title','date'
    ];

    protected static $logAttributes = [  'administrator_id','title','date'];


    public $incrementing = false;

    public function Administrator()
    {
      return $this->belongsTo('App\Administrator');
    }

    public function Absentmember()
    {
      return $this->hasMany('App\Absentmember');
    }

}
