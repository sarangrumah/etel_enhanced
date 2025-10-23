<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Izin;
use App\Models\Admin\Ulo;
use App\Models\Admin\Izinlog;
use Illuminate\Http\Request;
use App\Models\Admin\Ulolog;
use App\Models\Admin\JobPosition;
use Illuminate\Support\Facades\Session;

class LogHelper{

	public function createIzinLog($izin,$catatan){
        $izin = $izin->toArray();
        $jabatan = JobPosition::select('*')->where('id','=',Session::get('id_mst_jobposition'))->first();

        $izin['created_by'] = Session::get('id_user');
        $izin['created_name'] = Session::get('nama');
        $izin['jabatan'] = Session::get('nama');
        $izin['catatan_evaluasi'] = $catatan;
        $izin['jabatan'] = $jabatan['name'];

        unset($izin['created_at']);
        unset($izin['updated_at']);
        unset($izin['id']);

        $insertIzinLog = Izinlog::create($izin);

        return $insertIzinLog;
    }

    public function createUloLog($uloToLog,$catatan,$status_ulo = 0){
        if (!empty($uloToLog)) {
            $uloToLog = $uloToLog->toArray();
        } else {
            $uloToLog = array();
        }
        $jabatan = JobPosition::select('*')->where('id','=',Session::get('id_mst_jobposition'))->first();

        unset($uloToLog['created_date']);
        unset($uloToLog['updated_date']);
        unset($uloToLog['id']);
        unset($uloToLog['status_ulo']);

        $uloToLog['created_by'] = Session::get('id_user');
        $uloToLog['created_name'] = Session::get('nama');
        $uloToLog['status_ulo'] = $status_ulo;
        $uloToLog['catatan_evaluasi'] = $catatan;
        $uloToLog['jabatan'] = $jabatan['name'];



        $insertUloLog = Ulolog::create($uloToLog);
        return $insertUloLog;
    }

    public function createPenomoranLog($penomoran,$status_permohonan = 0){
        $id_kodeakses = $penomoran['id'];
        unset($penomoran['created_date']);
        unset($penomoran['updated_date']);
        unset($penomoran['id']);
        unset($penomoran['status_permohonan']);
        $jabatan = JobPosition::select('*')->where('id','=',Session::get('id_mst_jobposition'))->first();
        $penomoran['id_izin'] = $penomoran['id_izin'];
        $penomoran['created_by'] = Session::get('id_user');
        $penomoran['created_name'] = Session::get('nama');
        $penomoran['created_date'] = date('Y-m-d H:i:s');
        $penomoran['updated_date'] = date('Y-m-d H:i:s');
        $penomoran['status_permohonan'] = $status_permohonan;
        $penomoran['catatan_hasil_evaluasi'] = $penomoran['catatan_hasil_evaluasi'];
        $penomoran['jabatan'] = $jabatan['name'];
        $penomoran['id_kode_akses'] = $id_kodeakses;
        $insertUloLog = DB::table('tb_trx_kode_akses_log')->insert($penomoran);
        return $insertUloLog;
    }

    public function createLog(Request $request, $logAction, $logDetail, $dataBefore = null, $dataAfter = null, $additionalInfo = ''){
        if (isset(Auth::user()->email)) {
            $email = Auth::user()->email;
        } else {
            $email = Session::get('email');
        }

        $log['log_userid'] = $email;
        $log['log_detail'] = $logDetail;
        $log['log_datetime'] = date('Y-m-d H:i:s');
        $log['log_additionalinfo'] = $additionalInfo;
        $log['ip_address'] = $request->ip();
        $log['user_agent'] = $request->header('User-Agent');
        $log['url'] = $request->fullUrl();
        $log['data_before'] = json_encode($dataBefore);
        $log['data_after'] = json_encode($dataAfter);
        $log['log_action'] = $logAction;
        $log['created_date'] = date('Y-m-d H:i:s');
        $log['created_by'] = $email;
        $log['updated_date'] = date('Y-m-d H:i:s');
        $log['updated_by'] = $email;

        $inserLog = DB::table('log_trans')->insert($log);
        return $inserLog;
    }

}
