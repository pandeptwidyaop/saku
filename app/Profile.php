<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
  use Uuid;

  public $incrementing = false;

  protected $fillable = [
    'nim', 'name', 'email', 'handphone', 'address', 'birthday', 'sex'
  ];

  public function Member()
  {
    return $this->hasMany('App\Member');
  }
}
