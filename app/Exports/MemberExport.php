<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Member;
use Auth;

class MemberExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $member = Member::where('periode_id','=',Auth::user()->Member()->periode_id)->get();
        $data = [];
        $num  = 0;
        foreach ($member as $m) {
            $data[$num] = [
            'NIM' => $m->Profile->nim,
            'Nama' => $m->Profile->name,
            'Jenis Kelamin' => $m->Profile->sex == 'male' ? 'Laki - laki' : 'Perempuan',
            'Email' => $m->Profile->email,
            'Tanggal Lahir' => date('d-m-Y',strtotime($m->Profile->birthday)),
            'Nomor Handphone' => $m->Profile->handphone,
            'Alamat' => $m->Profile->address
            ];
            $num++;
        }
        return collect($data);
    }
}
