<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Viewizin;
use Exception;

class UtilPerizinan
{


    function getizin($jenisperizinan)
    {
        try {
            if ($jenisperizinan == 'JASA') {
                $izin = Viewizin::where(['nib' => Auth::user()->nib[0]->nib, 'id_master_izin' => '1'])
                    ->whereIn('status_checklist', ['00', '901', '902', '903', '10', '20', '43', '44'])
                    ->where('jenis_perizinan', '!=', 'K03')
                    ->get();
            } else if ($jenisperizinan == 'JARINGAN') {
                $izin = Viewizin::where(['nib' => Auth::user()->nib[0]->nib, 'id_master_izin' => '2'])
                    ->whereIn('status_checklist', ['00', '901', '902', '903', '10', '20', '43', '44'])
                    ->where('jenis_perizinan', '!=', 'K03')
                    ->get();
            } else if ($jenisperizinan == 'TELSUS') {
                $izin = Viewizin::where(['nib' => Auth::user()->nib[0]->nib, 'id_master_izin' => '3'])->whereIn('status_checklist', ['00', '01', '901', '902', '903', '10', '20', '21', '43', '44'])->get();
            } else if ($jenisperizinan == 'TELSUS_INSTANSI') {
                $izin = Viewizin::where(['nib' => Auth::user()->nib[0]->nib, 'id_master_izin' => '5'])->whereIn('status_checklist', ['00', '01', '901', '902', '903', '10', '20', '21', '43', '44', '90'])->get();
            } else if ($jenisperizinan == 'ALL') {
                $izin = Viewizin::where(['nib' => Auth::user()->nib[0]->nib])->distinct('id_izin')->orderBy('updated_at','desc')->get();
                // $izin = DB::table('vw_list_izin as a')->select('*')->get();
                // dd($izin);

            } else if ($jenisperizinan == 'DONE') {
                $izin = Viewizin::where(['nib' => Auth::user()->nib[0]->nib])->whereIn('status_checklist', ['50'])->distinct('id_izin')->get();
            } else if ($jenisperizinan == 'PROSES') {
                $izin = Viewizin::where(['nib' => Auth::user()->nib[0]->nib])->whereNotIn('status_checklist', ['50', '90'])->distinct('id_izin')->get();
            } else if ($jenisperizinan == 'REJECTED') {
                $izin = Viewizin::where(['nib' => Auth::user()->nib[0]->nib])->whereIn('status_checklist', ['90'])->distinct('id_izin')->get();
            } else if ($jenisperizinan == 'PENOMORAN_PENETAPAN') {
                $izin = Viewizin::where(['nib' =>
                Auth::user()->nib[0]->nib])->whereIn('status_checklist', ['50','95'])->where('jenis_perizinan', ['K03'])->get();
            } else if ($jenisperizinan == 'ALL_NOMOR') {
                $izin = Viewizin::where(['nib' =>
                Auth::user()->nib[0]->nib])->where('jenis_perizinan', ['K03'])->distinct('id_izin')->get();
            } else if ($jenisperizinan == 'DONE_NOMOR') {
                $izin = Viewizin::where(['nib' =>
                Auth::user()->nib[0]->nib])->where('jenis_perizinan', ['K03'])->whereIn('status_checklist', ['50'])->distinct('id_izin')->get();
            } else if ($jenisperizinan == 'PROSES_NOMOR') {
                $izin = Viewizin::where(['nib' =>
                Auth::user()->nib[0]->nib])->where('jenis_perizinan', ['K03'])->whereNotIn('status_checklist', [
                    '50',
                    '90'
                ])->distinct('id_izin')->get();
            } else if ($jenisperizinan == 'REJECTED_NOMOR') {
                $izin = Viewizin::where(['nib' =>
                Auth::user()->nib[0]->nib])->where('jenis_perizinan', ['K03'])->whereIn(
                    'status_checklist',
                    ['90']
                )->distinct('id_izin')->get();
            } else if ($jenisperizinan == 'CABUT_NOMOR') {
                $izin = Viewizin::from('vw_list_izin as v')->where(['nib' =>
                Auth::user()->nib[0]->nib])->select('v.*')
                    ->join('tb_trx_sk_penomoran as b', 'b.id_izin', '=', 'v.id_izin')
                    ->where('v.jenis_perizinan', ['K03'])
                    ->where(function ($query) {
                                                  $query->where('b.jenis_permohonan', 'LIKE', 'Pencabutan%')
                                                      ->orWhere('b.jenis_permohonan', 'LIKE', 'Pengembalian%');
                                              })
                    ->whereIn('v.status_checklist',['50','95'])->distinct('v.id_izin')->get();
            } else if ($jenisperizinan == 'TETAP_NOMOR') {
                $izin = Viewizin::from('vw_list_izin as v')->where(['nib' =>
                Auth::user()->nib[0]->nib])->select('v.*')
                    ->join('tb_trx_sk_penomoran as b', 'b.id_izin', '=', 'v.id_izin')
                    ->where('v.jenis_perizinan', ['K03'])
                    ->where(function ($query) {
                                                  $query->where('b.jenis_permohonan', 'LIKE', 'Penetapan%');
                                              })
                    ->whereIn('v.status_checklist',['50','95'])->distinct('v.id_izin')->get();
            }
        } catch (\Throwable $th) {
            $izin = [];
        }
        return $izin;
    }

    public function getizin_nonib($jenisperizinan)
    {
        try {
            if ($jenisperizinan == 'PENOMORAN_PENETAPAN') {
                $izin = Viewizin::where('jenis_perizinan', ['K03'])->whereIn('status_checklist', [
                    '50',
                    '90'
                ])->get();
            } else if ($jenisperizinan == 'ALL_NOMOR') {
                $izin = Viewizin::where('jenis_perizinan', ['K03'])->distinct('id_izin')->get();
            } else if ($jenisperizinan == 'DONE_NOMOR') {
                $izin = Viewizin::where('jenis_perizinan', ['K03'])->whereIn(
                    'status_checklist',
                    ['50','95']
                )->distinct('id_izin')->get();
            } else if ($jenisperizinan == 'PROSES_NOMOR') {
                $izin = Viewizin::where('jenis_perizinan', ['K03'])->whereNotIn(
                    'status_checklist',
                    ['50', '90','95']
                )->distinct('id_izin')->get();
            } else if ($jenisperizinan == 'REJECTED_NOMOR') {
                $izin = Viewizin::where('jenis_perizinan', ['K03'])->whereIn(
                    'status_checklist',
                    ['90']
                )->distinct('id_izin')->get();
            } else if ($jenisperizinan == 'CABUT_NOMOR') {
                $izin = Viewizin::from('vw_list_izin as v')->select('v.*')
                    ->join('tb_trx_sk_penomoran as b', 'b.id_izin', '=', 'v.id_izin')
                    ->where('v.jenis_perizinan', ['K03'])
                    ->where(function ($query) {
                                                  $query->where('b.jenis_permohonan', 'LIKE', 'Pencabutan%')
                                                      ->orWhere('b.jenis_permohonan', 'LIKE', 'Pengembalian%');
                                              })
                    ->whereIn('v.status_checklist',['50','95'])->distinct('v.id_izin')->get();
            } else if ($jenisperizinan == 'TETAP_NOMOR') {
                $izin = Viewizin::from('vw_list_izin as v')->select('v.*')
                    ->join('tb_trx_sk_penomoran as b', 'b.id_izin', '=', 'v.id_izin')
                    ->where('v.jenis_perizinan', ['K03'])
                    ->where(function ($query) {
                                                  $query->where('b.jenis_permohonan', 'LIKE', 'Penetapan%');
                                              })
                    ->whereIn('v.status_checklist',['50','95'])->distinct('v.id_izin')->get();
            }
        } catch (\Throwable $th) {
            $izin = [];
        }
        return $izin;
    }

    function getizinBtidIzin($id_izin)
    {
        $izin = Viewizin::where(['id_izin' => $id_izin])->distinct('id_izin')->first();
        return $izin;
    }

    function getizinpemenuhansyarat($jenisperizinan = 'JASA')
    {
        $izin = Viewizin::where('nib', '=', Auth::user()->nib[0]->nib)->where('status_fo', '=', 'Permohonan Baru')->get();
        return $izin;
    }


    function getizinkoreksisyarat($jenisperizinan)
    {
        // dd($jenisperizinan);
        if ($jenisperizinan == 'JASA') {
            $izin = Viewizin::where(['nib' => Auth::user()->nib[0]->nib, 'id_master_izin' => '1', 'status_fo' => 'Perbaikan Persyaratan'])->orWhere('status_penyesuaian', '=', '90')->distinct('id_izin')->get();
        } else if ($jenisperizinan == 'JARINGAN') {
            $izin = Viewizin::where(['nib' => Auth::user()->nib[0]->nib, 'id_master_izin' => '2', 'status_fo' => 'Perbaikan Persyaratan'])->orWhere('status_penyesuaian', '=', '90')->distinct('id_izin')->get();
        } else if ($jenisperizinan == 'ALL') {
            $izin = Viewizin::where(['nib' => Auth::user()->nib[0]->nib, 'status_fo' => 'Perbaikan Persyaratan'])->distinct('id_izin')->get();
        } else if ($jenisperizinan == 'TELSUS') {
            $izin = Viewizin::where(['nib' => Auth::user()->nib[0]->nib, 'id_master_izin' => '3', 'status_fo' => 'Perbaikan Persyaratan'])->distinct('id_izin')->get();
        } else {
            $izin = [];
        }

        return $izin;
    }

    function getizinpenetapan($jenisperizinan)
    {
        // $izin = Viewizin::where('nib', '=', Auth::user()->nib[0]->nib)->where('status_fo', '=', 'Disetujui')->distinct('id_izin')->get();
        if ($jenisperizinan == 'JASA') {
            $izin = Viewizin::select('vw_list_izin.*','vw_ba_sk.dok_ba','vw_ba_sk.dok_skulo','vw_ba_sk.no_sklo','vw_ba_sk.tgl_sklo' )->leftjoin('vw_ba_sk','vw_ba_sk.id_izin','vw_list_izin.id_izin')->where(['vw_list_izin.nib' => Auth::user()->nib[0]->nib, 'vw_list_izin.id_master_izin' => '1', 'vw_list_izin.status_fo' => 'Disetujui', 'vw_list_izin.jenis_perizinan' => '02'])->distinct('vw_list_izin.id_izin')->get();
            // dd($izin);
        } else if ($jenisperizinan == 'JARINGAN') {
            $izin = Viewizin::select('vw_list_izin.*','vw_ba_sk.dok_ba','vw_ba_sk.dok_skulo','vw_ba_sk.no_sklo','vw_ba_sk.tgl_sklo' )->leftjoin('vw_ba_sk','vw_ba_sk.id_izin','vw_list_izin.id_izin')->where(['vw_list_izin.nib' => Auth::user()->nib[0]->nib, 'vw_list_izin.id_master_izin' => '2', 'vw_list_izin.status_fo' => 'Disetujui', 'vw_list_izin.jenis_perizinan' => '02'])->distinct('vw_list_izin.id_izin')->get();
        } else if ($jenisperizinan == 'ALL') {
            $izin = Viewizin::select('vw_list_izin.*','vw_ba_sk.dok_ba','vw_ba_sk.dok_skulo','vw_ba_sk.no_sklo','vw_ba_sk.tgl_sklo' )->leftjoin('vw_ba_sk','vw_ba_sk.id_izin','vw_list_izin.id_izin')->where(['vw_list_izin.nib' => Auth::user()->nib[0]->nib, 'vw_list_izin.status_fo' => 'Disetujui', 'vw_list_izin.jenis_perizinan' => '02'])->distinct('vw_list_izin.id_izin')->get();
        }  else if ($jenisperizinan == 'telsus') {
            $izin = Viewizin::select('vw_list_izin.*','vw_ba_sk.dok_ba','vw_ba_sk.dok_skulo','vw_ba_sk.no_sklo','vw_ba_sk.tgl_sklo' )->leftjoin('vw_ba_sk','vw_ba_sk.id_izin','vw_list_izin.id_izin')->where(['vw_list_izin.nib' => Auth::user()->nib[0]->nib, 'vw_list_izin.id_master_izin' => '3', 'vw_list_izin.status_fo' => 'Disetujui', 'vw_list_izin.jenis_perizinan' => 'K02'])->distinct('vw_list_izin.id_izin')->get();
        }  else if ($jenisperizinan == 'TELSUS_INSTANSI') {
            $izin = Viewizin::select('vw_list_izin.*','vw_ba_sk.dok_ba','vw_ba_sk.dok_skulo','vw_ba_sk.no_sklo','vw_ba_sk.tgl_sklo' )->leftjoin('vw_ba_sk','vw_ba_sk.id_izin','vw_list_izin.id_izin')->where(['vw_list_izin.nib' => Auth::user()->nib[0]->nib, 'vw_list_izin.id_master_izin' => '5', 'vw_list_izin.status_fo' => 'Disetujui', 'vw_list_izin.jenis_perizinan' => 'K02'])->distinct('vw_list_izin.id_izin')->get();
            // dd($izin);
        } else {
            $izin = [];
        }

        return $izin;
    }

    function getAllIzin()
    {
        $izin = DB::table('tb_mst_izin as a')->select('a.name as kategori', 'b.name as kbli', 'b.desc as kbli_desc', 'c.kode_izin', 'c.id_internal as kode_izin_internal', 'c.name as nama_izin', 'c.desc as deskripsi_izin', 'd.oss_id', 'd.id_proyek', 'd.id_izin', 'd.status_checklist', 'd.no_izin', 'd.nama_izin as nama_izin_oss')
            ->join('tb_mst_kbli as b', 'b.id_mst_izin', '=', 'a.id')
            ->join('tb_mst_izinlayanan as c', 'c.id_mst_kbli', '=', 'b.id')
            ->join('tb_oss_trx_izin as d', 'd.kd_izin', '=', 'c.kode_izin')
            ->get();
        return $izin;
    }

    function getUmku()
    {
    }
}