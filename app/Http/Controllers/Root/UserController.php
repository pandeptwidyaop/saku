<?php

namespace App\Http\Controllers\Root;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Help;
use Alert;
use App\User;
use App\Profile;
use App\Member;
use App\Periode;
use App\Administrator as Admin;
use DB;

class UserController extends Controller
{

  protected $data;

  public function index(Request $request)
  {
    $id = $request->periode == null ? '' : $request->periode;
    $user = User::all();
    $periode = Periode::all();
    $member = Member::where('periode_id','=',$id)->get();
    return view('root.user.index', compact('user','member','periode'))->withInput(['periode' => $id]);
  }

  public function destroy($id)
  {
    User::findOrFail($id)->delete();
    Alert::new('success','Berhasil menghapus pengguna.');
    return back();
  }

  public function change($id)
  {
    $user = User::find($id);
    $user->access = $user->access == 'denied' ? 'granted' : 'denied';
    $user->save();
    Alert::new('success','Berhasil mengubah akses perngguna.');
    return back();
  }

  public function reset(Request $request,$id)
  {
    if ($request->password != null) {
      $user = User::find($id);
      $user->password = bcrypt($request->password);
      $user->save();
      Alert::new('success','Berhasil mengubah password.');
    }else {
      Alert::new('danger','Pastikan password tidak kosong.');
    }
    return back();
  }

  public function create(Request $request)
  {
    $this->validate($request,[
      'user' => 'required',
      'member' => 'required',
      'administrator' => 'required'
    ]);

    $this->data = $request;

    $admin = Admin::create([
      'member_id' => $this->data->member,
      'user_id' => $this->data->user,
      'position' => $this->data->administrator,
    ]);

    $user = User::findOrFail($this->data->user);
    $user->update(['role' => 'admin','access' => 'granted']);

    Alert::new('success','Berhasil memberikan akses ke pengguna.');
    return back();
  }
}
