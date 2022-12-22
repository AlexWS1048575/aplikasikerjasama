<?php

namespace App\Exports;

use App\Models\Corporation;
use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;

class CorporationExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return Corporation::all();
        return Corporation::select('name', 'title', 'document_no', 'phonenumber', 'summary', 'pic', 'assignment_date', 
        'duration', 'durationtype_id')->get();
    }

    // public function headings(): array
    // {
    //     return ["Nama", "Email", "Nomor Dokumen", "Tanggal Aktif", "Rincian", "Durasi", "PIC", "Nomor HP(WA)"];
    // }
}
