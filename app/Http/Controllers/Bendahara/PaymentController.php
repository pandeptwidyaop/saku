<?php

namespace App\Http\Controllers\Bendahara;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Payment;
use App\Member;
use App\Memberpayment;
use App\Fund;
use Help;
use Alert;
use Auth;
use DB;
use Excel;
use App\Exports\PaymentExport;

class PaymentController extends Controller
{
    protected $payment;

    public function index()
    {
      $payment = Payment::select('payments.*')
        ->join('administrators', 'payments.administrator_id','=','administrators.id')
        ->join('members','administrators.member_id','=','members.id')
        ->where('members.periode_id','=',Auth::user()->member()->periode_id)
        ->get();
      return view('bendahara.payment.index',compact('payment'));
    }

    public function create(Request $request)
    {
      $this->validate($request,[
        'title' => 'required',
        'date' => 'required',
        'nominal' => 'required'
      ]);

      $data = $request->all();
      $data['nominal'] = strtr($request->nominal,[','=>'']);
      $data['date'] = date('Y-m-d',strtotime($request->date));
      $data['administrator_id'] = Auth::user()->administrator->id;

      DB::transaction(function() use ($data) {
        $payment = Payment::create($data);
        $this->payment = $payment;
        $member = Member::where('periode_id','=',Auth::user()->member()->periode_id)->get();
        foreach ($member as $m) {
          Memberpayment::create([
            'payment_id' => $payment->id,
            'member_id' => $m->id
          ]);
        }
      });
      Alert::new('success','Berhasil membuat pembayaran.');
      return redirect(Help::url('pembayaran-kas/'.$this->payment->id.'/view'));
    }

    public function show($id)
    {
      $payment = Payment::findOrFail($id);
      $member = $this->getMemberNotRegistered($id);
      return view('bendahara.payment.show',compact('payment','member'));
    }

    public function update(Request $request, $id)
    {
      $this->validate($request,['kas' => 'required']);

      $data = $request->all();

      DB::transaction(function() use ($data,$id) {
        $fund  = Fund::where('periode_id','=',Auth::user()->member()->periode_id)->first();
        $current_fund = $fund->fund;
        $current_nominal = Payment::findOrFail($id)->nominal;

        foreach ($data['kas'] as $key => $value) {
          $pay = Memberpayment::findOrFail($key);
          $status = $pay->status;
          if ($status != $value) {
            if ($value == 'paid') {
              $current_fund += $current_nominal;
            }else {
              $current_fund -= $current_nominal;
            }
          }
          $pay->update(['status' => $value]);
        }

        $fund->update(['fund' => $current_fund]);
        Alert::new('success','Berhasil menyimpan data.');
      });
      return back();
    }

    public function download($id)
    {
      return Excel::download(new PaymentExport($id),'Pembayaran.xlsx');
    }

    public function destroy($id)
    {
      DB::transaction(function() use ($id) {
        $payment = Payment::findOrFail($id);
        $fund = Fund::where('periode_id','=',Auth::user()->member()->periode_id)->firstOrFail();
        $kas = $fund->fund;
        foreach ($payment->Memberpayment as $mp) {
          if ($mp->status == 'paid') {
            $kas -= $payment->nominal;
          }
        }
        $fund->update(['fund' => $kas]);
        $payment->delete();
        Alert::new('success','Berhasil menghapus data pembayaran. Data kas sudah disesuaikan');
      });
      return back();
    }

    public function addmember(Request $request,$id)
    {
      $this->validate($request,[
        'member' => 'required'
      ]);

      $member = $request->member;

      DB::transaction(function() use ($member,$id) {
        foreach ($member as $key => $value) {
          Memberpayment::create([
            'payment_id' => $id,
            'member_id' => $value
          ]);
        }
        Alert::new('success','Berhasil menambahkan anggota, silakan melakukan pembayaran.');
      });
      return back();
    }

    public function getMemberNotRegistered($payment_id)
    {
      $memberpayment  = Memberpayment::where('payment_id','=',$payment_id)->get();
      $data = [];
      foreach ($memberpayment as $key => $value) {
        $data[] = $value->member_id;
      }
      $member = Member::whereNotIn('id',$data)->get();
      return $member;
    }
}
