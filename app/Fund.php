<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    use Uuid;

    protected $fillable = ['periode_id','fund'];

    public $incrementing = false;

    public function Periode()
    {
      return $this->belongsTo('App\Periode');
    }
}
