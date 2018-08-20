<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Payment;

class PaymentExport implements FromCollection
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $payment = Payment::findOrFail($this->id);
        $data = [];
        foreach ($payment->Memberpayment as $kas) {
            $data[$kas->id] = [
            'NIM' => $kas->Member->Profile->nim,
            'Nama' => $kas->Member->Profile->name,
            'Kas' => $kas->status == 'paid' ? 'LUNAS' : ''
            ];
        }
        return collect($data);
    }
}
