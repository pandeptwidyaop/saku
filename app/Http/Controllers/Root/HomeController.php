<?php

namespace App\Http\Controllers\Root;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Help;
use Alert;
use Auth;
use App\User;
use App\Profile;
use App\Periode;
use App\Member;
use App\Administrator as Admin;

class HomeController extends Controller
{
  public function index()
  {
    $profile = Profile::all();
    $periode = Periode::all();
    return view('root.home', compact('profile','periode'));
  }
}
