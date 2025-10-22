<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
// use Barryvdh\DomPDF\Facade\Pdf;
// use iio\libmergepdf\Merger;
use DB;
// use Illuminate\Http\Request;
// use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
// use setasign\Fpdi\Fpdi;
use TCPDF;
use setasign\Fpdi\Tcpdf\Fpdi;
use Mpdf\Mpdf;
use Dompdf\Dompdf;
use Dompdf\Options;

class pdfGeneratedController extends Controller
{
    protected $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }
    
    public function generatePDF($id, Request $request)
    {
        // dd($id);
        // $pdfMerger = new PDFMerger();
        // $daftarPerangkat = DB::table('vw_daftarperangkat')->where('id_trx_izin','=',$id)->first();
        // $jsonData = $daftarPerangkat->filled_document;
        // $data = json_decode($jsonData, true);
        // // // dd($data);

        // // // Add PDFs from JSON data
        // // $jsonData = $request->input('data');
        // // $data = json_decode($jsonData, true);

        // foreach ($data as $item) {
        //     $filePath = storage_path('app/' . $item['foto_perangkat']);
        //     $pdfMerger->addPDF($filePath, 'all');
        // }

        // // Merge PDFs
        // $outputPath = storage_path('app/public/merged_document.pdf');
        // $pdfMerger->merge('file', $outputPath);

        // // Optionally, you can download the merged PDF
        // return response()->download($outputPath, 'merged_document.pdf');

        $pdfMerger = PDFMerger::init();

        // $pdfMerger->addPDF('/var/www/kominfo_vnew/storage/app/public/sk_ulo/daftarperangkat-PTB-2024071600009.pdf', [2]);
        // $pdfMerger->addPDF('/var/www/kominfo_vnew/storage/app/public/sk_ulo/daftarperangkat-PTB-2024071600009.pdf', [2]);
        // $pdfMerger->merge();
        // $outputPath = storage_path('app/public/merged_document.pdf');
        // $pdfMerger->save($outputPath);
        // Add PDFs from JSON data
        $daftarPerangkat = DB::table('vw_daftarperangkat')->where('id_trx_izin','=',$id)->first();
        $jsonData = $daftarPerangkat->filled_document;
        $data = json_decode($jsonData, true);
        // // dd($data);

        // // Add PDFs from JSON data
        // $jsonData = $request->input('data');
        // $data = json_decode($jsonData, true);
        // $jsonData = $request->input('data');
        // $data = json_decode($jsonData, true);

        foreach ($data as $item) {
            $filePath = storage_path('app/' . $item['foto_perangkat']);
            $pdfMerger->addPDF($filePath, 'all');
        }
        $outputFileName = 'merged_document.pdf';
        $outputPath = storage_path('app/public/' . $outputFileName);
        $pdfMerger->merge('file', $outputPath);
        // Merge PDFs
        // $outputPath = storage_path('app/public/merged_document.pdf');
        // $pdfMerger->merge('file', $outputPath);

        // Optionally, you can download the merged PDF
        return response()->download($outputPath, $outputFileName);
    }


    public function exportPdf()
    {
        $data = '[{"sertifikat_perangkat":null,"lokasi_perangkat":"ACEH","jenis_perangkat":"ROUTER","merk_perangkat":"ROUTER","sn_perangkat":"ROUTER","tipe_perangkat":"ROUTER","buatan_perangkat":"ROUTER","foto_perangkat":"storage/file_syarat/KOMINFO-foto17211483250.pdf","foto_sn_perangkat":"storage/file_syarat/KOMINFO-foto-sn17211483250.pdf"}]';

        $data = json_decode($data, true);

        $pdf = new Dompdf();
        $pdf->set_option('isHtml5ParserEnabled', true);
        $pdf->set_option('isRemoteEnabled', true);
        $pdf->loadHtml('<h1>PDF Content</h1>');

        // Load the PDF file from the JSON data
        foreach ($data as $item) {
        // dd(storage_path(str_replace('storage/','app/public/',$item['foto_perangkat'])));
            // $pdf->loadHtml('<img src="' . storage_path(str_replace('storage/','app/public/',$item['foto_perangkat'])) . '" />');
           $pdf->loadHtml('<img src="' . '/global_assets/images/landing/logo_alt.svg' . '" />');
        }

        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        $pdf->stream('exported_pdf.pdf');
    }

    public function exportPdf_tcpdf()
    {

        // foreach ($data as $item) {
        //     $pdf->Image(storage_path(str_replace('storage/','',$item['foto_perangkat'])), 10, 10, 100, '', 'PDF', '', 'T', false, 300, '', false, false, 0, false, false, false);
        //     $pdf->AddPage();
        //     $pdf->Image(storage_path(str_replace('storage/','',$item['foto_perangkat'])), 10, 10, 100, '', 'PDF', '', 'T', false, 300, '', false, false, 0, false, false, false);
        //     $pdf->AddPage();
        // }
    //     foreach ($data as $item) {
    //         // dd(url($item['foto_perangkat']));
    //     $pdf->AddPage();
    //     $pdf->setSourceFile(url($item['foto_perangkat']));
    //     $tplIdx = $pdf->importPage(1);
    //     $pdf->useTemplate($tplIdx, 10, 10, 180);

    //     $pdf->AddPage();
    //     $pdf->setSourceFile(url($item['foto_perangkat']));
    //     $tplIdx = $pdf->importPage(1);
    //     $pdf->useTemplate($tplIdx, 10, 10, 180);
    // }
    $mpdf = new Mpdf();
    $basePath = '/var/www/kominfo_vnew/public/';

    // dd( "Base Path: " . $mpdf->getBasePath());
    $mpdf->SetBasePath($basePath);

    // dd( "Base Path: " . $mpdf->getBasePath());
    $data = '[{"sertifikat_perangkat":null,"lokasi_perangkat":"ACEH","jenis_perangkat":"ROUTER","merk_perangkat":"ROUTER","sn_perangkat":"ROUTER","tipe_perangkat":"ROUTER","buatan_perangkat":"ROUTER","foto_perangkat":"http://dev-etelekomunikasi.kominfo.go.id/storage/file_syarat/KOMINFO-foto17211483250.pdf","foto_sn_perangkat":"http://dev-etelekomunikasi.kominfo.go.id/file_syarat/pdffile2.pdf"}]';

    $data = json_decode($data, true);

    foreach ($data as $item) {
        // dd($pdfContent);
        $pdfContent = file_get_contents(url($item['foto_perangkat']));
        dd($pdfContent);
        $mpdf->WriteHTML($pdfContent);

        // $pdfContent2 = file_get_contents(url($item['foto_sn_perangkat']));
        // $mpdf->AddPage();
        // $mpdf->WriteHTML($pdfContent2);
    }

    $mpdf->Output('merged_pdf.pdf', 'D');}
}
