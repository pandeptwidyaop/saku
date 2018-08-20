<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Absentmember extends Model
{
    use Uuid;
    use LogsActivity;

    protected $fillable = [
      'member_id','absent_id','absent'
    ];
    protected static $logAttributes = ['member_id','absent_id','absent'];

    public $incrementing = false;

    public function Member()
    {
      return $this->belongsTo('App\Member');
    }

    public function Absent()
    {
      return $this->belongsTo('App\Absent');
    }
}
