<?php

namespace App\Http\Controllers\Sekretaris;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Absent;
use App\Absentmember;
use App\Member;
use DB;
use Alert;
use Help;
use Auth;
use Excel;

class AbsentController extends Controller
{
    private $data;
    private $absent;

    public function index()
    {
      $absent = Absent::where('administrator_id','=',Auth::user()->administrator->id)->get();
      $absent = Absent::select('absents.*')
        ->join('administrators','absents.administrator_id','=','administrators.id')
        ->join('members','administrators.member_id','=','members.id')
        ->where('members.periode_id','=',Auth::user()->member()->periode_id)
        ->get();
      return view('sekretaris.absent.index', compact('absent'));
    }

    public function create(Request $request){
      $data = [
        'title' => $request->title,
        'date' => date('Y-m-d',strtotime($request->date)),
        'administrator_id' => Auth::user()->administrator->id
      ];
      $this->data = $data;
      DB::transaction(function(){
        $member = Member::where('periode_id','=',Auth::user()->member()->periode_id)->get();
        $absent = Absent::create($this->data);
        $this->absent = $absent;
        foreach ($member as $m) {
          $absentmember = Absentmember::create([
            'member_id' => $m->id,
            'absent_id' => $absent->id
          ]);
        }
      });
      return redirect(Help::url('absen/'.$this->absent->id.'/view'));
    }

    public function show($id)
    {
      $absent = Absent::find($id);
      $member = $this->getMemberNotRegistered($id);
      return view('sekretaris.absent.show', compact('absent','member'));
    }

    public function update(Request $request)
    {
      $absent = $request->input('absent');
      $this->absent = $absent;
      DB::transaction(function(){
        foreach ($this->absent as $key => $value) {
          Absentmember::findOrFail($key)->update(['absent' => $value]);
        }
      });
      Alert::new('success','Berhasil menyimpan absen.');
      return back();
    }

    public function destroy($id)
    {
      Absent::destroy($id);
      Alert::new('success','Berhasil menghapus absen.');
      return back();
    }

    public function download($id)
    {
      $absent = Absent::findOrFail($id);
      $data  = [];
      foreach ($absent->Absentmember as $am) {
        $ket = '';
        switch ($am->absent) {
          case 'present':
            $ket = 'Hadir';
            break;
          case 'permit':
            $ket = 'Izin';
            break;
          case 'sick':
            $ket = 'Sakit';
            break;
          case 'alpha':
            $ket = 'Tanpa Keterangan';
            break;
        }
        $data[$am->id] = [
          'Nama' => $am->Member->Profile->name,
          'Absen' => $ket
        ];
      }
      $this->data = $data;
      $name = 'absen-anggota_'.strtr($absent->title,[' '=>'-',','=>'-']).'_'.$absent->date.'_'.$absent->id;
      $file = Excel::create($name,function($excel){
        $excel->sheet('Daftar Absen',function($sheet){
          $sheet->fromArray($this->data);
        });
      })->store('xlsx');
      return response()->download(storage_path('exports/'.$name.'.xlsx'))->deleteFileAfterSend(true);
    }

    public function addmember(Request $request, $id)
    {
      $this->validate($request, ['member' => 'required']);
      foreach ($request->member as $key => $value) {
        Absentmember::create(['absent_id' => $id,'member_id' => $value]);
      }
      Alert::new('success','Berhasil menambakan anggota kedalam absen.');
      return back();
    }

    public function getMemberNotRegistered($absent_id){
      $absentmember = Absentmember::where('absent_id','=',$absent_id)->get();
      $data = [];
      foreach ($absentmember as $ab) {
        $data[] = $ab->member_id;
      }
      $member = Member::whereNotIn('id',$data)->get();
      return $member;
    }
}
