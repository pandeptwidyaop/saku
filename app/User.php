<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
    use Notifiable;
    use Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $incrementing = false;

    protected $fillable = [
         'username', 'password', 'role' ,'picture','access'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function Administrator()
    {
      return $this->hasOne('App\Administrator');
    }

    public function profile()
    {
      if (Auth::user()->role == 'admin' || count($this->Administrator) > 0) {
        return $this->Administrator->Member->Profile;
      }else {
        return null;
      }
    }

    public function periode()
    {
      if (Auth::user()->role == 'admin' || count($this->Administrator) > 0) {
        return $this->Administrator->Member->Periode->periode;
      }else {
        return null;
      }
    }

    public function position()
    {
      if (Auth::user()->role == 'admin' || count($this->Administrator) > 0) {
        return $this->Administrator->position;
      }else {
        return null;
      }
    }

    public function config()
    {
      if (Auth::user()->role == 'admin' || count($this->Administrator) > 0) {
        return json_decode($this->Administrator->Member->Periode->config);
      }else {
        return null;
      }
    }

    public function member()
    {
      if (Auth::user()->role == 'admin' || count($this->Administrator) > 0) {
        return $this->Administrator->Member;
      }else {
        return null;
      }
    }
}
