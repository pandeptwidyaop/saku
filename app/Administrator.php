<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    use Uuid;

    public $incrementing = false;

    protected $fillable = [
      'user_id', 'member_id', 'position'
    ];

    public function User()
    {
      return $this->belongsTo('App\User');
    }

    public function Member()
    {
      return $this->belongsTo('App\Member');
    }

    public function Absent()
    {
      return $this->hasMany('App\Absent');
    }

    public function Payment()
    {
      return $this->hasMany('App\Payment');
    }

    public function Income()
    {
      return $this->hasMany('App\Income');
    }

    public function Outcome()
    {
      return $this->hasMany('App\Outcome');
    }
}
