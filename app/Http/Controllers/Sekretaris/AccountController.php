<?php

namespace App\Http\Controllers\Sekretaris;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Help;
use Alert;
use App\Profile;
use App\Libraries\Upload;
use App\User;

class AccountController extends Controller
{
    public function index()
    {
      $data = Auth::user()->profile();
      return view('sekretaris.profile.index',compact('data'));
    }

    public function changePicture(Request $request)
    {
      if ($request->hasFile('picture')) {
        $pict = $request->file('picture');
        $user = User::find(Auth::id());
        if ($user->picture != 'users/user.png') {
          Help::del($user->picture);
        }
        $user->picture = Upload::img($pict,'users',null,500,500);
        $user->save();
        Alert::new('success','Berhasil mengubah gambar akun.');
      }
      return back();
    }

    public function changePassword(Request $request)
    {
      $user = User::find(Auth::id());
      $user->password = bcrypt($request->password);
      $user->save();
      Alert::new('success','Berhasil mengubah password.');
      return back();
    }
}
