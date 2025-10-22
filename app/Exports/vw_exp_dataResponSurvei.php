<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class vw_exp_dataResponSurvei implements FromCollection, WithHeadings
{
    public function collection()
    {
        return  DB::table('vw_exp_dataResponSurvei')->select('*')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Periode Survei',
            'No Permohonan',
            'Jenis Permohonan',
            'Nama Pemohon',
            'Evaluator',
            'Tingkat Kepuasan',
            'Nilai IKM Kinerja (Skala 4)',
            'Nilai IKM Kinerja (Skala 100)',
            'Nilai IKM Harapan (Skala 4)',
            'Nilai IKM Harapan (Skala 100)',
            'Nilai IIPP (Skala 4)',
            'Nilai IIPP (Skala 10)',
            'Nama Responden',
            'No. Telp',
            'Email',
            // Add more headings if you have more columns
        ];
    }
}