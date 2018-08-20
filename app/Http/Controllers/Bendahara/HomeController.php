<?php

namespace App\Http\Controllers\Bendahara;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Alert;

class HomeController extends Controller
{
    public function index()
    {
      Alert::new('info','Untuk saat ini halaman ini sengaja dikosongkan.');
      return view('bendahara.home');
    }
}
