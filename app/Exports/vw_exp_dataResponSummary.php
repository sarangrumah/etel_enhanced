<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class vw_exp_dataResponSummary implements FromCollection, WithHeadings
{
    public function collection()
    {
        return  DB::table('vw_survei_result_summary')->select('*')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Periode Bulan Survei',
            'Periode Tahun Survei',
            'Periode Survei',
            'Total Responden Dihitung',
            'Total Responden Flag',
            'Tingkat Kepuasan',
            'Nilai IKM Kinerja Skala 4',
            'Nilai IKM Kinerja Skala 100',
            'Nilai IKM Harapan Skala 4',
            'Nilai IKM Harapan Skala 100',
            'Nilai IIPP Skala 4',
            'Nilai IIPP Skala 10',
            // Add more headings if you have more columns
        ];
    }
}