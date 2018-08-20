<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MemberRegistration;
use Alert;
use App\Profile;
use App\Periode;
use App\Member;
use DB;

class MemberRegistrationController extends Controller
{

    private $data;
    private $periode_id;

    public function index(Request $request,$periode_id)
    {
      $periode = Periode::find($periode_id);
      if ($this->checkPeriode($periode_id)) {
        if ($this->isOpenRegistration($periode_id)) {
          return view('member.index', compact('periode'));
        }else {
          Alert::new('warning','Untuk saat ini halaman registrasi Anggota Periode '.$periode->periode.' sedang tidak aktif.');
          return redirect('/login');
        }
      }else {
        Alert::new('warning','Halaman tidak ditemukan atau alamat tidak valid.');
        return redirect('/login');
      }
    }

    public function store(MemberRegistration $request,$periode_id)
    {
      $this->periode_id = $periode_id;
      $this->data = $request->all();
      $this->data['birthday'] = date('Y-m-d',strtotime($request->birthday));
      $this->data['name'] = strtoupper($request->name);
      DB::transaction(function(){
        $profile = Profile::create($this->data);
        $member = Member::create([
          'periode_id' => $this->periode_id,
          'profile_id' => $profile->id
        ]);
        if ($member) {
          Alert::new('success',"Selamat $profile->name , anda telah terdaftar sebagai calon aggota aktif HIMAPRODI SI pada periode kepengurusan ".$member->Periode->periode.". Untuk info lebih lanjut akan diinformasikan melalui SMS.");
        }else {
          Alert::new('danger','Terjadi kesalahan.');
        }
      });

      return back();
    }

    public function oldmember($periode_id)
    {
      $periode = Periode::find($periode_id);
      if ($this->checkPeriode($periode_id)) {
        if ($this->isOpenRegistration($periode_id)) {
          return view('member.oldmember', compact('periode'));
        }else {
          Alert::new('warning','Untuk saat ini halaman registrasi Anggota Periode '.$periode->periode.' sedang tidak aktif.');
          return redirect('/login');
        }
      }else {
        Alert::new('warning','Halaman tidak ditemukan atau alamat tidak valid.');
        return redirect('/login');
      }
    }

    public function registerOldMember(Request $request, $periode_id)
    {
      $this->validate($request,[
        'nim' => 'required|exists:profiles,nim',
        'email' => 'required|exists:profiles,email',
        'birthday' => 'required',
        'agreement' => 'accepted'
      ]);
      $periode = Periode::findOrFail($periode_id);
      $data = $request->all();
      $data['birthday'] = date('Y-m-d',strtotime($request->birthday));
      $profile = Profile::where('nim','=',$data['nim'])
        ->where('email','=', $data['email'])
        ->where('birthday','=', $data['birthday'])
        ->first();
      if ($profile != null) {
        $member = Member::where('periode_id','=',$periode_id)
          ->where('profile_id','=',$profile->id)
          ->get();
        if (count($member) == 0) {
          Member::create(['periode_id' => $periode_id, 'profile_id' => $profile->id]);
          Alert::new('success',"Selamat $profile->name , anda sudah terdaftar kembali sebagai anggota aktif periode $periode->periode . Info lebih lanjut akan diinformasikan melalui SMS.");
        }else {
          Alert::new('warning',"$profile->name sudah terdaftar sebagai anggota aktif periode $periode->periode .");
        }
      }else {
        Alert::new('warning',"Maaf, tidak ditemukan untuk anggota dengan NIM ".$data['nim']);
      }
      return back();
    }


    //================= private

    private function checkPeriode($periode){
      $periode = Periode::find($periode);
      return $periode == null ? false : true;
    }

    private function isOpenRegistration($periode){
      $periode = Periode::find($periode);
      return $periode->config()->open_registration === 'true' ? true : false;
    }
}
