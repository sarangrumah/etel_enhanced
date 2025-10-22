<?php

namespace App\Http\Controllers\Admin;

use App\Exports\vw_exp_alokasipenomoran;
// use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\vw_exp_dataResponSurvei;
use App\Exports\vw_exp_dataResponSummary;
use App\Exports\vw_survei_summary;
use App\Exports\vw_exp_penomoran_req;
use App\Exports\vw_exp_penomoran_tetap;
// use DB;
use PDO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use PDO;

class ExcelController
{
    public function data_respond_survei()
    {
        // $data = DB::table('vw_survei_respond__header')->select('id_respond')->get();
        return Excel::download(new vw_exp_dataResponSurvei, 'Data Respon Survei.xlsx');
    }
    public function data_respond_summary()
    {
        // $data = DB::table('vw_survei_respond__header')->select('id_respond')->get();
        return Excel::download(new vw_exp_dataResponSummary, 'Data Respon Summary.xlsx');
    }
    public function data_alokasi_penomoran()
    {
        // $data = DB::table('vw_survei_respond__header')->select('id_respond')->get();
        return Excel::download(new vw_exp_alokasipenomoran, 'Data Alokasi Penomoran.xlsx');
    }
    public function req_penomoran()
    {
        // $data = DB::table('vw_survei_respond__header')->select('id_respond')->get();
        return Excel::download(new vw_exp_penomoran_req, 'Data Req Penomoran.xlsx');
    }
    public function tetap_penomoran()
    {
        // $data = DB::table('vw_survei_respond__header')->select('id_respond')->get();
        return Excel::download(new vw_exp_penomoran_tetap, 'Data Penetapan Penomoran.xlsx');
    }

    public function all_summary($period_month, $period_year, $type, Request $req)
    {
        $pdo = DB::connection()->getPdo();
        
        // $period_month = intval($period_month);
        // $period_year = intval($period_year);
        // Execute a raw SQL query using PDO
        // $sql = 'CALL prd_summary(''' . $period_month;
        $statement = $pdo->prepare("CALL prd_summary(:period_year, :period_month, :type)");

    // Bind the parameter values to the placeholders
    $statement->bindParam(':period_year', $period_year, PDO::PARAM_INT);
    $statement->bindParam(':period_month', $period_month, PDO::PARAM_STR);
    $statement->bindParam(':type', $type, PDO::PARAM_STR);
        // dd($statement);
    // Execute the prepared statement
    $statement->execute();

        // Fetch all results using fetchAll method on the statement
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($results)) {
            $headers = array_keys($results[0]);
            array_unshift($results, $headers);
        }

        return Excel::download(new vw_survei_summary($results, $headers), 'Data Respon Detail.xlsx');
    }

    public function all_quest_active()
    {
        $pdo = DB::connection()->getPdo();
        
        // $period_month = intval($period_month);
        // $period_year = intval($period_year);
        // Execute a raw SQL query using PDO
        // $sql = 'CALL prd_summary(''' . $period_month;
        $statement = $pdo->prepare("SELECT * FROM vw_survei_active_quest");

        // Bind the parameter values to the placeholders
        // $statement->bindParam(':period_year', $period_year, PDO::PARAM_INT);
        // $statement->bindParam(':period_month', $period_month, PDO::PARAM_STR);
        // $statement->bindParam(':type', $type, PDO::PARAM_STR);
            // dd($statement);
        // Execute the prepared statement
        $statement->execute();

        // Fetch all results using fetchAll method on the statement
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($results)) {
            $headers = array_keys($results[0]);
            array_unshift($results, $headers);
        }

        return Excel::download(new vw_survei_summary($results, $headers), 'List Pertanyaan Aktif.xlsx');
    }

}
