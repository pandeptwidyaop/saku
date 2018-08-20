<?php

namespace App\Http\Controllers\Bendahara;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Payment;
use App\Member;
use App\Memberpayment;
use Alert;
use Help;
use Auth;
use Excel;

class MemberPaymentController extends Controller
{
    public function index()
    {
      $member = Member::where('periode_id','=',Auth::user()->member()->periode_id)->get();
      return view('bendahara.memberpayment.index',compact('member'));
    }

    public function show($id)
    {
      $member = Member::findOrFail($id);
      $payment = Memberpayment::select('memberpayments.*')
        ->join('members', 'members.id','=','memberpayments.member_id')
        ->where('members.periode_id','=',Auth::user()->member()->periode_id)
        ->where('memberpayments.member_id','=',$id)
        ->get();
      return view('bendahara.memberpayment.show', compact('payment','member'));
    }

    public function pay($member_id,$payment_id)
    {
      $memberpayment = Memberpayment::findOrFail($payment_id);
      $memberpayment->update(['status' => 'paid']);
      Alert::new('success','Berhasil melakukan pembayaran.');
      return back();
    }
}
