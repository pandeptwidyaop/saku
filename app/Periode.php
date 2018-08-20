<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use Uuid;

    public $incrementing = false;

    protected $fillable = [
      'periode','config'
    ];

    public function Member()
    {
      return $this->hasMany('App\Member');
    }

    public function Fund()
    {
      return $this->hasOne('App\Fund');
    }

    public function config(){
      return json_decode($this->config);
    }
}
