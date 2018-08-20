<?php

namespace App\Http\Controllers\Sekretaris;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Member;
use App\Profile;
use App\Exports\MemberExport;
use Auth;
use Help;
use Alert;
use Excel;

class MemberController extends Controller
{
    protected $data;

    public function index()
    {
      $member = Member::where('periode_id','=',Auth::user()->member()->periode_id)->get();
      return view('sekretaris.member.index', compact('member'));
    }

    public function edit($member_id)
    {
      $profile = Member::find($member_id)->Profile;
      return view('sekretaris.member.edit', compact('profile'));
    }

    public function update(Request $request, $profile_id)
    {
      $profile = $request->all();
      $profile['birthday'] = date('Y-m-d',strtotime($request->birthday));
      $profile['name'] = strtoupper($request->name);
      Profile::find($profile_id)->update($profile);
      Alert::new('success','Berhasil memperbarui profile anggota.');
      return redirect(Help::url('anggota'));
    }

    public function destroy($member_id)
    {
      Member::destroy($member_id);
      Alert::new('success','Berhasil menghapus keanggotaan.');
      return back();
    }

    public function download()
    {
      return Excel::download(new MemberExport,'Anggota.xlsx');
    }
}
