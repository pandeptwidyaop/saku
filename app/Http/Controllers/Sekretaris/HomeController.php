<?php

namespace App\Http\Controllers\Sekretaris;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Alert;

class HomeController extends Controller
{
    public function index()
    {
      Alert::new('info','Untuk saat ini dashboard sengaja dikosongkan.');
      return view('sekretaris.home');
    }
}
