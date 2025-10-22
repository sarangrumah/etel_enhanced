<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class vw_exp_alokasipenomoran implements FromCollection, WithHeadings
{
    public function collection()
    {
        return  DB::table('vw_rpt_alokasi_penomoran')->select('*')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Jenis Penomoran',
            'Kode Akses',
            'Status Penomoran',
            'Nomor Penetapan',
            'Tanggal Penetapan',
            'Nama Perusahaan Saat Ini',
            'NIB',
            'Jenis Perusahaan/Instansi',
            // Add more headings if you have more columns
        ];
    }
}