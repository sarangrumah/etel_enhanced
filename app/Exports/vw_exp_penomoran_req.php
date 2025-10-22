<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class vw_exp_penomoran_req implements FromCollection, WithHeadings
{
    public function collection()
    {
        return  DB::table('vw_rpt_req_penomoran')->select('*')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'No Permohonan',
            'Tanggal Permohonan',
            'Jenis Permohonan',
            'Nama Pengguna',
            'NIB',
            'Jenis Pengguna',
            'Jenis Penomoran',
            'Kode Akses',
            'No SK Penomoran',
            'Tgl SK Penomoran',
            'Jenis SK',
            'Waktu Proses',
            'Status Permohonan',
            'Evaluator',
            // Add more headings if you have more columns
        ];
    }
}