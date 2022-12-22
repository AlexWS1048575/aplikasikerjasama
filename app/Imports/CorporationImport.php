<?php

namespace App\Imports;

use App\Models\Corporation;
use Maatwebsite\Excel\Concerns\ToModel;
// use Maatwebsite\Excel\Concerns\WithHeadingRow; 
use Illuminate\Support\Facades\Auth;

class CorporationImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = Auth::user();
        return new Corporation([
            'name'     => $row[0],
            'title'    => $row[1],
            'document_no'    => $row[2],
            'phonenumber'    => $row[3], 
            'summary'    => $row[4],
            'pic'    => $row[5],
            'assignment_date'    => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6]), // format kolom ketujuh itu memang bugs dari bawaan PhpSpreadsheet sendiri, jadi set tanggal wajib ke dalam format m/d/Y
            'duration'    => $row[7],
            'durationtype_id' => $row[8], // jika 1 adalah bulan, 2 adalah tahun
            'type_id' => '4', // tipe kerjasama adalah lainnya
            'corporationtype_id' => '1', // jenis kerjasama adalah dalam negeri
            'created_by' => $user->id, // data import diambil dari user yang login
            'updated_by' => $user->id, // data import diambil dari user yang login
        ]);
    }
}
