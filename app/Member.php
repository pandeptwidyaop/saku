<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use Uuid;

    public $incrementing = false;

    protected $fillable = [
      'periode_id', 'profile_id'
    ];

    public function Profile()
    {
      return $this->belongsTo('App\Profile');
    }

    public function Periode()
    {
      return $this->belongsTo('App\Periode');
    }

    public function Administrator()
    {
      return $this->hasOne('App\Administrator');
    }

    public function Absentmember()
    {
      return $this->hasMany('App\Absentmember');
    }

    public function Memberpayment()
    {
      return $this->hasMany('App\Memberpayment');
    }
}
