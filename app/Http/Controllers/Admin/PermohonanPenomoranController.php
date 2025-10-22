<?php

namespace App\Http\Controllers;

use PDO;
use Config;
use App\Models\Nib;
use App\Models\Izin_oss;
use App\Models\DetailNIB;
use App\Models\Admin\Izin;
use App\Helpers\DateHelper;
use App\Helpers\EmailHelper;
use App\Models\LogKodeAkses;
use App\Models\MstKodeAkses;
use App\Models\TrxKodeAkses;
use Illuminate\Http\Request;
use App\Helpers\CommonHelper;
use App\Models\Admin\Izinlog;
use App\Models\Admin\Izinoss;
use App\Models\Admin\Penomoran;
use Illuminate\Support\Optional;
use App\Models\Admin\Penomoranlog;
use App\Models\Admin\BlokNomor_List;
use Illuminate\Support\Facades\DB;
use App\Models\PermohonanPenomoran;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class PermohonanPenomoranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date_reformat = new DateHelper();
        $limit_db = Config::get('app.admin.limit');

        $nib = Auth::user()->nib[0]->nib;
        $oss_id = (Auth::user()->oss_id); //harusnya oss id , karena bisa jadi di oss belum ada nib nya

        // $detailNIB = DetailNIB::where(['nib' => $nib])->get();

        // $lspermohonan = PermohonanPenomoran::where(['nib' => $nib])
        //     ->where(['jenis_permohonan' => 'UMKU'])->limit(500)
        //     ->get();

        // $data = [
        //     'detailNIB' => $detailNIB,
        //     'lspermohonan' => $lspermohonan,
        // ];
        // $permohonanizin = DB::table('vw_kbli_penomoran')->select('id_proyek', 'vw_kbli_penomoran.name', 'full_kbli', 'kbli_name', 'vw_list_izin.jenis_izin', 'provinsi_name', 'kabupaten_name')->join('vw_list_izin', 'kd_izin', '=', 'kode_izin')->groupByRaw('vw_kbli_penomoran.name, id_proyek, jenis_izin, kbli_name, full_kbli, provinsi_name, kabupaten_name')->limit(500)->get();
        $penomoran = DB::table('vw_list_permohonan_nomor')->where('nib', '=', $nib)->get();
        // $permohonanizin = NULL;
        // $penomoran = DB::table('tb_oss_trx_izin')->select('*')->where('oss_id', '=', $oss_id)->where('jenis_izin', '=', 'K03')->get();
        // dd($penomoran);
        $kblitelsus = DB::table('tb_mst_kbli')
            ->select('*')->where('id_mst_izin', 3)->get();
        $kblinomor = DB::table('tb_mst_kbli')
            ->select('*')->whereIn('name', ['61100', '61200', '61300', '61912'])->get();
        $user = Auth::user();
        $user_oss_id = $user->oss_id;
        $status_evaluasi = DB::table('tb_oss_user')->select('*')->where('no_id_user_proses', $user->id)->first();
        $status_evaluasi = isset($status_evaluasi->status_evaluasi) ? $status_evaluasi->status_evaluasi : 0;

        // dd($penomoran);
        // return view('layouts.frontend.penomoran.penomoran-baru', compact('permohonanizin'));
        return view('layouts.frontend.penomoran.main_penomoran', compact('date_reformat', 'penomoran', 'kblitelsus', 'kblinomor', 'user', 'status_evaluasi'));
    }

    public function detail(Request $req)
    {
        $date_reformat = new DateHelper();

        $id_izin = $req->id_izin;
        $id_proyek = $req->id_proyek;
        $umku = DB::table('tb_oss_trx_izin')->where('id_izin', '=', $id_izin)->first();
        // dd($umku);
        // $permohonanizin = DB::table('vw_list_permohonan_nomor')->limit(500)->get();
        $permohonanizin = DB::table('tb_trx_kode_akses')->select('tb_mst_kode_akses.*', 'tb_mst_jenis_kode_akses.full_name', 'tb_trx_kode_akses.status_permohonan', 'tb_oss_mst_kodestatusizin.name_status_bo as status_bo', 'tb_trx_kode_akses.*', 'tb_trx_kode_akses.id as idtrxkodeakses')
            ->join('tb_mst_kode_akses', 'tb_mst_kode_akses.id', '=', 'tb_trx_kode_akses.id_mst_kode_akses')
            ->join('tb_mst_jenis_kode_akses', 'tb_mst_jenis_kode_akses.id', '=', 'tb_mst_kode_akses.id_mst_jeniskodeakses')
            ->leftJoin('tb_oss_mst_kodestatusizin', 'tb_oss_mst_kodestatusizin.oss_kode', '=', 'tb_trx_kode_akses.status_permohonan')
            ->where('tb_trx_kode_akses.id_izin', '=', $id_izin)
            ->get();
        $VwList = DB::table('vw_list_izin')->select('*')->where('id_izin', '=', $id_izin)->first();

        $permohonanizin = DB::table('vw_exist_kodeakses')->select('*')->where(['nib' =>  $VwList->nib, 'kode_izin' => $VwList->kd_izin])->get();
        // dd($permohonanizin);

        return view('layouts.frontend.penomoran.pra_penomoran', compact('date_reformat', 'id_izin', 'id_proyek', 'permohonanizin', 'umku'));
    }

    public function pra_detail(Request $req)
    {

        $id_izin = $req->id_proyek;
        $permohonanizin = DB::table('vw_list_permohonan_nomor')->limit(500)->get();

        return view('layouts.frontend.penomoran.pra_penomoran', compact('id_izin', 'permohonanizin'));
    }

    public function baru(Request $req)
    {
        // if(isset($req->vId_proyek)){
        //     return redirect('/penomoran-baru');
        // }
        # code...
        // dd($req->all());
        // $id_proyek = $req->vId_proyek;
        $id_izin = $req->vId_izin;
        $VwList = DB::table('vw_list_izin')->select('*')->where('id_izin', '=', $id_izin)->first();
        $id_proyek = $VwList->id_proyek;
        $long = DB::table('tb_mst_jenis_kode_akses')->select('*')->where('short_name', '=', $req->jenisnomor)->first();
        $cek = DB::table('vw_exist_kodeakses')
            ->select('*')
            // ->where()
            ->where(['nib' =>  $VwList->nib, 'kode_izin' => $VwList->kd_izin, 'short_name' => $req->jenisnomor, 'status_permohonan' => 50, 'status_izin' => 50])->get();
        $short_name = $long->short_name;
        $long_name = $long->full_name;
        if ($cek->count() > 0) {
            $penambahan = true;
            $urlsubmit = url('penomoran/savepenomoranpenambahan');
            $idtrxizin = Izin_oss::select('id')->where('id_izin', '=', $id_izin)->first()->id;
            $izin = DB::table('vw_list_izin')->select('*')->where('id_proyek', '=', $id_proyek)->first();
            $jenis_penomoran = DB::table('vw_list_penomoran')->select('layanan_name')->where('kbli_name', '=', $izin->kbli)->groupBy('layanan_name')->get();
            $izin = DB::table('vw_list_izin')->where('id_izin', '=', $id_izin)->first();
            return view('layouts.frontend.penomoran.penomoran-baru', compact('id_proyek', 'izin', 'id_izin', 'jenis_penomoran', 'idtrxizin', 'urlsubmit', 'penambahan', 'VwList', 'short_name', 'long_name'));
        } else {

            $cek = DB::table('vw_exist_kodeakses')
                ->select('*')
                ->where(['nib' =>  $VwList->nib, 'kode_izin' => $VwList->kd_izin, 'short_name' => $req->jenisnomor])
                ->whereNotIn('status_permohonan', ['50', '90'])->get();
            // dd($cek->all());
            if ($cek->count() > 0) {
                return redirect('/penomoran-baru')->with('error', 'Mohon maaf, pengajuan permohonan penomoran Anda tidak dapat diajukan. Terdapat pengajuan yang sama dan sedang dalam proses.');
            } else {
                $cek_approved = DB::table('vw_exist_kodeakses')
                    ->select('*')
                    ->where(['nib' =>  $VwList->nib, 'kode_izin' => $VwList->kd_izin, 'short_name' => $req->jenisnomor])
                    ->whereIn('status_permohonan', ['50'])->get();
                if ($cek_approved->count() > 0) {
                    return redirect('/penomoran-baru')->with('error', 'Mohon maaf, pengajuan permohonan penomoran Anda tidak dapat diajukan. Permohonan Penomoran Anda sudah ada yang disetujui. Penambahan Penomoran hanya bisa dilakukan jika Anda sudah memiliki perizinan berusaha yang sesuai dengan jenis penomoran yang diajukan.');
                } else {
                    $urlsubmit = url('penomoran/savepenomoranbaru');
                    $penambahan = false;
                    $idtrxizin = Izin_oss::select('id')->where('id_izin', '=', $id_izin)->first()->id;
                    $izin = DB::table('vw_list_izin')->select('*')->where('id_proyek', '=', $id_proyek)->first();
                    $jenis_penomoran = DB::table('vw_list_penomoran')->select('layanan_name')->where('kbli_name', '=', $izin->kbli)->groupBy('layanan_name')->get();
                    $izin = DB::table('vw_list_izin')->where('id_izin', '=', $id_izin)->first();

                    return view('layouts.frontend.penomoran.penomoran-baru', compact('id_proyek', 'izin', 'id_izin', 'jenis_penomoran', 'idtrxizin', 'urlsubmit', 'penambahan', 'VwList', 'short_name', 'long_name'));
                }
            }
        }
    }

    public function baru_rev()
    {

        $kblinomor_pt = DB::table('tb_mst_izinlayanan')
            ->select('*')->whereIn('non_oss', ['5', '6'])->where('is_active', '1')->get();
        $kodeWilayah = DB::table('tb_mst_kode_wilayah')->select('*')->where('is_active', '1')->get();
        $penambahan = false;
        $pengembalian = false;
        return view('layouts.frontend.penomoran.penomoran-baru-rev', compact('kblinomor_pt',
        'kodeWilayah','penambahan','pengembalian'));
    }

    public function barunpt_rev()
    {

        $kblinomor_pt = DB::table('tb_mst_izinlayanan')
            ->select('*')->whereIn('non_oss', ['5', '6'])->where('is_active', '1')->get();
        return view('layouts.frontend.penomoran.penomoran-baru-npt', compact('kblinomor_pt'));
    }

    public function add_rev()
    {

        $kblinomor_pt = DB::table('tb_mst_izinlayanan')
            ->select('*')->whereIn('non_oss', ['5', '6'])->where('is_active', '1')->get();
        $kodeWilayah = DB::table('tb_mst_kode_wilayah')->select('*')->where('is_active', '1')->get();
        $penambahan = true;
        $pengembalian = false;
        return view('layouts.frontend.penomoran.penomoran-baru-rev', compact(
            'kblinomor_pt',
            'penambahan',
            'pengembalian',
            'kodeWilayah'
        ));
    }
    public function remove_rev()
    {

        $kblinomor_pt = DB::table('tb_mst_izinlayanan')
            ->select('*')->whereIn('non_oss', ['5', '6'])->where('is_active', '1')->get();
        $kodeWilayah = DB::table('tb_mst_kode_wilayah')->select('*')->where('is_active', '1')->get();
        $penambahan = false;
        $pengembalian = true;
        // dd($pengembalian);
        return view('layouts.frontend.penomoran.penomoran-remove-rev', compact(
            'kblinomor_pt',
            'penambahan',
            'pengembalian',
            'kodeWilayah'
        ));
    }
    public function barunpt($id_izin)
    {
        // if(isset($req->vId_proyek)){
        // return redirect('/penomoran-baru');
        // }
        # code...
        // dd($req->all());
        // $id_proyek = $req->vId_proyek;
        // $id_izin = $req->vId_izin;
        $VwList = DB::table('vw_list_izin')->select('*')->where('id_izin', '=', $id_izin)->first();
        // $id_proyek = $VwList->id_proyek;
        $long = DB::table('tb_mst_jenis_kode_akses')->select('*')->where(
            'kode_izin',
            '=',
            $VwList->kd_izin
        )->first();
        $cek = DB::table('vw_exist_kodeakses')
            ->select('*')
            // ->where()
            ->where(['nib' => $VwList->nib, 'kode_izin'
            => $VwList->kd_izin, 'status_permohonan' => 50, 'status_izin' => 50])->get();
        // dd($cek);
        $short_name = $long->short_name;
        $long_name = $long->full_name;
        // dd($cek->count());
        if ($cek->count() > 0) {
            $penambahan = true;
            $urlsubmit = url('penomoran/savepenomoranpenambahan');
            $idtrxizin = Izin_oss::select('id')->where('id_izin', '=', $id_izin)->first()->id;
            $izin = DB::table('vw_list_izin')->where('id_izin', '=', $id_izin)->first();
            // $izin = DB::table('vw_list_izin')->select('*')->where('id_proyek', '=', $id_proyek)->first();
            $jenis_penomoran = DB::table('vw_list_penomoran')->select('layanan_name')->where(
                'kbli_name',
                '=',
                $izin->kbli
            )->groupBy('layanan_name')->get();
            // $izin = DB::table('vw_list_izin')->where('id_izin', '=', $id_izin)->first();
            return view('layouts.frontend.penomoran.penomoran-baru', compact(
                // 'id_proyek',
                'izin',
                'id_izin',
                'jenis_penomoran',
                'idtrxizin',
                'urlsubmit',
                'penambahan',
                'VwList',
                'short_name',
                'long_name'
            ));
        } else {
            // $maxIdNPT = DB::table('tb_trx_kode_akses')->where('id_permohonan', 'LIKE', 'NPT%')->get()->count();

            // if($maxIdNPT > 0){
            // $maxId = 'NPT-' . date('Ymd') . sprintf("%05s", $maxIdNPT + 1);
            // }else{
            // $maxId = 'NPT-' . date('Ymd') . sprintf("%05s", 1);
            // }
            // $id_proyek = $maxId;
            $cek = DB::table('vw_exist_kodeakses')
                ->select('*')
                ->where(['nib' => $VwList->nib, 'kode_izin' => $VwList->kd_izin])
                ->whereNotIn('status_permohonan', ['50', '90'])->get();
            // dd($cek->count());
            if ($cek->count() > 0) {
                return redirect('/penomoran-baru')->with('error', 'Mohon maaf, pengajuan permohonan penomoran Anda tidak dapat
    diajukan. Terdapat pengajuan yang sama dan sedang dalam proses.');
            } else {
                $cek_approved = DB::table('vw_exist_kodeakses')
                    ->select('*')
                    ->where(['nib' => $VwList->nib, 'kode_izin' => $VwList->kd_izin])
                    ->whereIn('status_permohonan', ['50', '51'])->get();
                if ($cek_approved->count() > 0) {
                    return redirect('/penomoran-baru')->with('error', 'Mohon maaf, pengajuan permohonan penomoran Anda tidak dapat
    diajukan. Permohonan Penomoran Anda sudah ada yang disetujui. Penambahan Penomoran hanya bisa dilakukan jika Anda
    sudah memiliki perizinan berusaha yang sesuai dengan jenis penomoran yang diajukan.');
                } else {
                    $urlsubmit = url('penomoran/savepenomoranbaru');
                    $penambahan = false;
                    $idtrxizin = Izin_oss::select('id')->where('id_izin', '=', $id_izin)->first()->id;
                    // $izin = DB::table('vw_list_izin')->select('*')->where('kd_izin', '=', $VwList->kd_izin)->first();
                    $jenis_penomoran = DB::table('vw_list_penomoran')->select('*')->where(
                        'kode_izin',
                        '=',
                        $VwList->kd_izin
                    )->first();
                    // dd($jenis_penomoran);
                    $short_name = $jenis_penomoran->short_name;
                    $long_name = $jenis_penomoran->full_name;
                    $izin = DB::table('vw_list_izin')->where('id_izin', '=', $id_izin)->first();

                    return view('layouts.frontend.penomoran.penomoran-baru', compact(
                        // 'id_proyek',
                        'izin',
                        'id_izin',
                        'jenis_penomoran',
                        'idtrxizin',
                        'urlsubmit',
                        'penambahan',
                        'VwList',
                        'short_name',
                        'long_name'
                    ));
                }
            }
        }
    }

    public function baru_npt($id_izin)
    {
        // if(isset($req->vId_proyek)){
        // return redirect('/penomoran-baru');
        // }
        # code...
        // dd($req->all());
        // $id_proyek = $req->vId_proyek;
        // $id_izin = $req->vId_izin;
        $VwList = DB::table('vw_list_izin')->select('*')->where('id_izin', '=', $id_izin)->first();
        // $id_proyek = $VwList->id_proyek;
        $long = DB::table('tb_mst_jenis_kode_akses')->select('*')->where(
            'kode_izin',
            '=',
            $VwList->kd_izin
        )->first();
        $cek = DB::table('vw_exist_kodeakses')
            ->select('*')
            // ->where()
            ->where(['nib' => $VwList->nib, 'kode_izin'
            => $VwList->kd_izin, 'status_permohonan' => 50, 'status_izin' => 50])->get();
        // dd($cek);
        $short_name = $long->short_name;
        $long_name = $long->full_name;
        // dd($cek->count());
        if ($cek->count() > 0) {
            $penambahan = true;
            $urlsubmit = url('penomoran/savepenomoranpenambahan');
            $idtrxizin = Izin_oss::select('id')->where('id_izin', '=', $id_izin)->first()->id;
            $izin = DB::table('vw_list_izin')->where('id_izin', '=', $id_izin)->first();
            // $izin = DB::table('vw_list_izin')->select('*')->where('id_proyek', '=', $id_proyek)->first();
            $jenis_penomoran = DB::table('vw_list_penomoran')->select('layanan_name')->where(
                'kbli_name',
                '=',
                $izin->kbli
            )->groupBy('layanan_name')->get();
            // $izin = DB::table('vw_list_izin')->where('id_izin', '=', $id_izin)->first();
            return view('layouts.frontend.penomoran.penomoran-baru', compact(
                // 'id_proyek',
                'izin',
                'id_izin',
                'jenis_penomoran',
                'idtrxizin',
                'urlsubmit',
                'penambahan',
                'VwList',
                'short_name',
                'long_name'
            ));
        } else {
            // $maxIdNPT = DB::table('tb_trx_kode_akses')->where('id_permohonan', 'LIKE', 'NPT%')->get()->count();

            // if($maxIdNPT > 0){
            // $maxId = 'NPT-' . date('Ymd') . sprintf("%05s", $maxIdNPT + 1);
            // }else{
            // $maxId = 'NPT-' . date('Ymd') . sprintf("%05s", 1);
            // }
            // $id_proyek = $maxId;
            $cek = DB::table('vw_exist_kodeakses')
                ->select('*')
                ->where(['nib' => $VwList->nib, 'kode_izin' => $VwList->kd_izin])
                ->whereNotIn('status_permohonan', ['50', '90'])->get();
            // dd($cek->count());
            if ($cek->count() > 0) {
                return redirect('/penomoran-baru')->with('error', 'Mohon maaf, pengajuan permohonan penomoran Anda tidak dapat
    diajukan. Terdapat pengajuan yang sama dan sedang dalam proses.');
            } else {
                $cek_approved = DB::table('vw_exist_kodeakses')
                    ->select('*')
                    ->where(['nib' => $VwList->nib, 'kode_izin' => $VwList->kd_izin])
                    ->whereIn('status_permohonan', ['50', '51'])->get();
                if ($cek_approved->count() > 0) {
                    return redirect('/penomoran-baru')->with('error', 'Mohon maaf, pengajuan permohonan penomoran Anda tidak dapat
    diajukan. Permohonan Penomoran Anda sudah ada yang disetujui. Penambahan Penomoran hanya bisa dilakukan jika Anda
    sudah memiliki perizinan berusaha yang sesuai dengan jenis penomoran yang diajukan.');
                } else {
                    $urlsubmit = url('penomoran/savepenomoranbaru');
                    $penambahan = false;
                    $idtrxizin = Izin_oss::select('id')->where('id_izin', '=', $id_izin)->first()->id;
                    // $izin = DB::table('vw_list_izin')->select('*')->where('kd_izin', '=', $VwList->kd_izin)->first();
                    $jenis_penomoran = DB::table('vw_list_penomoran')->select('*')->where(
                        'kode_izin',
                        '=',
                        $VwList->kd_izin
                    )->first();
                    // dd($jenis_penomoran);
                    $short_name = $jenis_penomoran->short_name;
                    $long_name = $jenis_penomoran->full_name;
                    $izin = DB::table('vw_list_izin')->where('id_izin', '=', $id_izin)->first();

                    return view('layouts.frontend.penomoran.penomoran-baru-npt', compact(
                        // 'id_proyek',
                        'izin',
                        'id_izin',
                        'jenis_penomoran',
                        'idtrxizin',
                        'urlsubmit',
                        'penambahan',
                        'VwList',
                        'short_name',
                        'long_name'
                    ));
                }
            }
        }
    }

    public function penambahan(Request $req)
    {
        # code...
        $id_proyek = $req->id_proyek;
        $id_izin = $req->id_izin;
        $penambahan = true;

        $urlsubmit = url('penomoran/savepenomoranpenambahan');
        // dd($id_izin);
        $idtrxizin = Izin_oss::select('id')->where('id_izin', '=', $id_izin)->first()->id;
        // $id_izin=$idtrxizin;
        $izin = DB::table('vw_list_izin')->select('*')->where('id_proyek', '=', $id_proyek)->first();
        $id_proyek = $izin->id_proyek;
        $jenis_penomoran = DB::table('vw_list_penomoran')->select('layanan_name')->where('kbli_name', '=', $izin->kbli)->groupBy('layanan_name')->get();
        $izin = DB::table('vw_list_izin')->where('id_izin', '=', $id_izin)->first();

        $short_name = $jenis_penomoran->short_name;
        $long_name = $jenis_penomoran->full_name;
        // dd($izin);
        return view('layouts.frontend.penomoran.penomoran-baru-npt', compact('id_proyek', 'izin', 'id_izin', 'jenis_penomoran', 'idtrxizin', 'urlsubmit', 'penambahan', 'short_name', 'long_name'));
    }

    public function getjenispenomoran(Request $req)
    {
        $jenisnomor = DB::table('vw_list_penomoran')->select('full_name', 'short_name')
            ->where('layanan_name', '=', $req->data)
            ->groupBy(['full_name', 'short_name'])->get();
        return json_encode($jenisnomor);
        // $paramdata = json_decode($req->data);
        // return $req->data;
    }

    function getKodeWeilayah(Request $req)
    {
        if ($req->data !== "Blok Nomor") {
            $data = "INI BUKAN BLOK NOMOR";
            return json_encode($data);
        } else {
            $data = DB::table('tb_mst_kode_wilayah')->orderBy('nama_wilayah', 'asc')->get();
            return json_encode($data);
        }
    }


    public function getnomor(Request $req)
    {
        $jenisnomor = DB::table('vw_list_penomoran')
            ->where(['vw_list_penomoran.short_name' =>  $req->data])
            ->where('layanan_name', '=', $req->datajenislayanan)->get();
        return json_encode($jenisnomor);
    }

    public function evaluasiPenomoran($id, Request $request)
    {
        // $id_user_session = Session::get('id_user');
        // $id_departemen_user = Session::get('id_departemen');
        $common = new CommonHelper();
        $date = new DateHelper();
        // if ($id_departemen_user != 5) {
        // return abort(404);
        // }
        // dd($id, $request);

        $limit_db = Config::get('app.admin.limit');
        $status_penomoran = 901;

        $penomoran = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses', 't.*', 'v.*')
            ->join('vw_list_izin as v', 't.id_izin', '=', 'v.id_izin')
            ->leftjoin('tb_trx_disposisi_evaluator_penomoran as d', 'd.id_izin', '=', 'v.id_izin')
            // ->where('d.id_disposisi_user', '=', Session::get('id_user'))
            ->where('t.id_izin', '=', $id)
            ->with('KodeIzin')->with('KodeAkses');
        // dd($penomoran);
        // $penomoran = $penomoran->where('t.status_permohonan', '=', $status_penomoran);

        $penomoran = $penomoran->first();
        if (empty($penomoran)) {
            return abort(404);
        }
        // dd($penomoran);
        $penomoran_bloknomor = BlokNomor_List::where('id_izin', '=', $id)->get()->toArray();
        // dd($penomoran_bloknomor);
        $penomoran = $penomoran->toArray();

        $nib = $penomoran['nib'];
        $kd_izin = $penomoran['kd_izin'];
        $date_reformat = new DateHelper();

        $detailNib = Nib::select('*')->where('nib', '=', $nib)->first();
        if (empty($detailNib)) {
            $detailNib = array();
        } else {
            $detailNib->toArray();
        }

        $id_mst_kode_akses = isset($penomoran['id_mst_kode_akses']) ? $penomoran['id_mst_kode_akses'] : '';
        $penomoran = $common->getDetailKodeAkses($penomoran, $id_mst_kode_akses);

        $map = $common->getMapKodeAkses($id_mst_kode_akses);

        $detailNib = $common->get_detail_nib($nib);

        $penomoranlog = Penomoranlog::where('id_izin', '=', $id)
            // ->where('id_kode_akses','=',$id_kodeakses)
            ->with('KodeIzin')->get()->toArray();
        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        $jenis_izin = 'Penomoran';
        // dd($penomoran);
        return view('layouts.frontend.penomoran.evaluasi-penomoran', [
            'date_reformat' => $date_reformat, 'penomoran' =>
            $penomoran, 'penomoranlog' => $penomoranlog, 'jenis_izin' => $jenis_izin, 'id' => $id, 'detailnib' => $detailNib,
            'penanggungjawab' => $penanggungjawab, 'penomoran_bloknomor' => $penomoran_bloknomor
        ]);
    }

    public function savepenomoranbaru(Request $req)
    {
        // dd($req->all());



        // if($req->jeniskodeakses == "Blok Nomor"){
        //     $cekkosong = "-- Pilih Kode Wilayah --";
        //     $listbloknomor = array($req->kode_wilayah);
        //     dd(collect($listbloknomor)->count());
        // }else{
        //     // dd($req->all());
        // }
        $id_jenislayanan = $req->id_jenislayanan;
        $id_jeniskodeakses = $req->id_jeniskodeakses;
        $kodeakses = $req->id_kodeakses;
        $penambahan_flag = false;
        $jenis_permohonan = "Penetapan Nomor Baru";

        // dd($req->all());
        if ($file1 = $req->file('LaporanPenggunaanPenomoran')) {
            $filename1 = "LaporanPenggunaanPenomoran-" . time() . '.' . $file1->extension();
            $path1 = $file1->storeAs('public/penambahan/penomoran', $filename1);
            $name1 = $file1->getClientOriginalName();
            $path1 = str_replace('public/', 'storage/', $path1);
            $penambahan_flag = true;
            $jenis_permohonan = "Penetapan Nomor Tambahan";
        }
        if ($file4 = $req->file('DokumenIzin')) {
            $filename4 = "DokumenIzin-" . time() . '.' . $file4->extension();
            $path4 = $file4->storeAs('public/penambahan/penomoran', $filename4);
            $name4 = $file4->getClientOriginalName();
            $path4 = str_replace('public/', 'storage/', $path4);
        }
        if ($file2 = $req->file('ProdukBriefBaru')) {
            $filename2 = "ProdukBriefBaru-" . time() . '.' . $file2->extension();
            $path2 = $file2->storeAs('public/penambahan/penomoran', $filename2);
            $name2 = $file2->getClientOriginalName();
            $path2 = str_replace('public/', 'storage/', $path2);
        }
        if ($file3 = $req->file('SuratDukungan')) {
            $filename3 = "SuratDukungan-" . time() . '.' . $file3->extension();
            $path3 = $file3->storeAs('public/penambahan/penomoran', $filename3);
            $name3 = $file3->getClientOriginalName();
            $path3 = str_replace('public/', 'storage/', $path3);
        }
        $path2 = isset($path2) ? $path2 : '';
        $path3 = isset($path3) ? $path3 : '';
        // dd($id_jenislayanan, $id_jeniskodeakses, $kodeakses);
        $oss_id = Auth::user()->oss_id;
        $oss_nib = DB::table('tb_oss_nib')->select('*')->where('oss_id', $oss_id)->first();

        $maxId = DB::table('tb_oss_trx_izin')->where('id_izin', 'LIKE', substr($oss_id, 0, 3) . '%')->get()->count();

        if ($maxId > 0) {
            $maxId = substr($oss_id, 0, 3) . '-' . date('Ymd') . sprintf("%05s", $maxId + 1);
        } else {
            $maxId = substr($oss_id, 0, 3) . '-' . date('Ymd') . sprintf("%05s", 1);
        }

        $jenis_izin = 'K03';
        $msg_success = 'Permohonan sudah berhasil disimpan dan akan dilakukan verifikasi.';
        $msg_failed = 'Mohon maaf permohonan penomoran tidak dapat diajukan, karena terdapat permohonan yang masih
        belum selesai dengan jenis permohonan kode akses yang sama';

        $cek_openstatusizin_nomor = DB::table('tb_oss_trx_izin')->select('*')
            ->where('oss_id', $oss_id)
            ->where('kd_izin', $id_jenislayanan)
            ->where('id_proyek', $id_jeniskodeakses)
            ->whereNotIn('status_checklist', ['50', '90', '51'])
            ->get();

        if ($cek_openstatusizin_nomor->count() > 0 && !$penambahan_flag) {
            return redirect('/')->with('message', $msg_failed);
        } else {
            $insert = new Izinoss([
                'oss_id' => $oss_id,
                'id_proyek' => $id_jeniskodeakses,
                'nib' => $oss_nib->nib,
                'id_izin' => $maxId,
                'jenis_izin' => $jenis_izin,
                'kd_daerah' => $oss_nib->perseroan_daerah_id,
                'kd_izin' => $id_jenislayanan,
                'status_checklist' => '20',
                'submitted_at' => date('Y-m-d H:i:s')
            ]);

            $insert->save();

            if (!isset($req->availno)) {
                // $list_BlokNomor = count($req->bloknomor);
                foreach ($req->bloknomor as $p) {
                    // dd($p['kode_wilayah']);
                    $insertBlokNomor = [
                        'id_izin' => $maxId,
                        'id_mst_jenis_kode_akses' => '17',
                        'jenis_penomoran' => 'Blok Nomor',
                        'kode_wilayah' => $p['kode_wilayah'],
                        'prefix_awal' => $p['prefix'],
                        'id_mst_kodestatusizin' => '913',
                        'status' => 'EVALUASI',
                        'nomor_penetapan' => '',
                        'tanggal_penetapan' => null,
                        'nama_pelakuusaha' => null,
                        'nib' => $oss_id,
                        'is_active' => '1',
                        'updated_date' => date('Y-m-d H:i:s'),
                        'created_date' => date('Y-m-d H:i:s'),
                        'updated_by' => Auth::user()->id,
                        'created_by' => Auth::user()->id
                    ];
                    $bloknomor_query = DB::table('tb_trx_kode_akses_alokasi_bloknomor')->insert($insertBlokNomor);
                }
                // dd($insertBlokNomor);
            } else {
                // dd($req->availno);
            }



            // $id_mst_Kodeakses = DB::table('vw_penomoran_list')->select('id')
            // ->where('layanan_name', '=', $req->JenisLayanan)
            // ->where('short_name', '=', $req->jenisnomor)
            // ->where('kode_akses', '=', $req->availno)->first()->id;
            if ($penambahan_flag) {
                $insert_trxkodeakses = new TrxKodeAkses([
                    'is_active' => 1,
                    'id_permohonan' => $maxId,
                    'id_izin' => $maxId,
                    'id_mst_kode_akses' => $kodeakses,
                    'status_permohonan' => '20',
                    'jenis_permohonan' => $jenis_permohonan,
                    'dok_pengguna_penomoran' => $path1,
                    'dok_kode_akses_konten' => $path2,
                    'dok_call_center' => $path3,
                    'dok_izin_penyelenggaraan' => $path4,
                    'updated_date' => date('Y-m-d H:i:s'),
                    'created_date' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id,
                    'created_by' => Auth::user()->id
                ]);
            } else {
                $insert_trxkodeakses = new TrxKodeAkses([
                    'is_active' => 1,
                    'id_permohonan' => $maxId,
                    'id_izin' => $maxId,
                    'id_mst_kode_akses' => $kodeakses,
                    'status_permohonan' => '20',
                    'jenis_permohonan' => $jenis_permohonan,
                    'updated_date' => date('Y-m-d H:i:s'),
                    'created_date' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id,
                    'created_by' => Auth::user()->id
                ]);
            }

            $insert_trxkodeakses->save();

            if ($insert_trxkodeakses->save()) {
                $penomoran_alokasi =
                    DB::table('tb_trx_kode_akses_alokasi')->select('*')->where(
                        'id',
                        '=',
                        $kodeakses
                    )->update([
                        'status' => 'Evaluasi'
                    ]);
                $this->setLog($req->id_oss_trxizin, $kodeakses, $maxId, $jenis_permohonan);

                $jenis_izin = Izin::where('id_izin', $maxId)->first();
                $izins = $jenis_izin->toArray();
                $nib = $jenis_izin['nib'];
                $nibs = Nib::where('nib', $nib)->first();
                $nibs = $nibs->toArray();
                $common = new CommonHelper();
                $email = new EmailHelper();

                //penanggungjawab dan kirim email
                $penanggungjawab = array();
                $email_data = array();
                $email_data_koordinator = array();
                $penanggungjawab = $common->get_pj_nib($nib);
                $catatan_hasil_evaluasi = '';
                // $datenow = Carbon::now();
                // $date = new DateHelper();
                // $date = $date->dateday_lang_reformat_long($datenow);

                $jenis_penomoran = DB::table('tb_mst_jenis_kode_akses')->where(
                    'short_name',
                    $id_jeniskodeakses
                )->first();
                // dd($izins);

                $departemen = [
                    // "availno" => $req->availno,
                    // "kode_wilayah" => $req->kode_wilayah,
                    // "prefix" => $req->prefix,
                    "jenis_penomoran" => $jenis_penomoran->full_name,
                    "jenis_permohonan" => 'Permohonan Baru',
                ];

                $koreksi_all = '';

                $email_jenis = 'pemenuhan-syarat';
                $nama2 = '';
                $kirim_email = $email->kirim_email($penanggungjawab, $email_jenis, $izins, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all);
                //end penganggungjawab

                //get jenis Penomoran

                //

                //kirim email koordinator
                $koordinator = DB::table('tb_mst_user_bo')->select('id', 'nama', 'email', 'id_mst_jobposition')
                    ->where('tb_mst_user_bo.id_mst_jobposition', '=', 13)
                    ->where('tb_mst_user_bo.is_accounttesting', '!=', 1)
                    ->first();
                $jabatan = DB::table('tb_mst_jobposition')->where('id', $koordinator->id_mst_jobposition)->first();

                $user['email'] = isset($koordinator->email) ? $koordinator->email : '';
                $user['nama'] = $koordinator->nama;
                $nama2 = $koordinator->nama;
                $email_jenis = 'koordinator-syarat';
                $catatan_hasil_evaluasi = '';

                //end mengirim email ke koordinator

                $kirim_email2 = $email->kirim_email2($user, $email_jenis, $izins, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, $jabatan);

                // return json_encode($dbs);
                // return json_encode(array('status' => 'ok;', 'text' => ''))->with('success', 'Data Your files has been successfully added');;
                // session()->flash('success', 'Gagal Menghubungi OSS Hub' );
                // return redirect('/penomoran/'.$req->id_proyek.'/'.$req->id_izin)->with('success', 'Data Your files has been successfully added');
                // return redirect('/penomoran-baru')->with('success', 'Data telah berhasil disimpan');
            } else {
                // return back()->with('error', 'failed');
                return back()->with('error', 'Gagal Menyimpan Data');

                // return json_encode(array('status' => 'error;', 'text' => 'Gagal Menyimpan Data'));
            }

            return redirect('/')->with('message', $msg_success);
        }

        // $id_mst_Kodeakses = '';
        //     if ($req->jenisnomor == "Blok Nomor") {
        //         $id_mst_Kodeakses = '';
        //         $permohonan = MstKodeAkses::where('prefix', '=', $req->prefix)
        //             ->where('kode_wilayah', '=', $req->kode_wilayah)
        //             ->first();
        //         // dd($permohonan);
        //         if ($permohonan != null) {
        //             if ($permohonan->is_active == '0') {
        //                 return back()->with('error', 'Data tidak berhasil diproses');
        //             } else {
        //                 $dbs = MstKodeAkses::find($permohonan->id);
        //                 $dbs->id_mst_jeniskodeakses = '17';
        //                 $dbs->is_active = '1';
        //                 $dbs->save();
        //                 $id_mst_Kodeakses = $permohonan->id;
        //             }
        //         } else {
        //             $mstkodeakses = new MstKodeAkses();
        //             $mstkodeakses->kode_wilayah = $req->kode_wilayah;
        //             $mstkodeakses->is_active = '0';
        //             $mstkodeakses->prefix = $req->prefix;
        //             $mstkodeakses->save();
        //             $id_mst_Kodeakses = $mstkodeakses->id;
        //         }
        //     } else {
        //         $id_mst_Kodeakses = DB::table('vw_list_penomoran')->select('id')
        //             ->where('layanan_name', '=', $req->JenisLayanan)
        //             ->where('short_name', '=', $req->jenisnomor)
        //             ->where('kode_akses', '=', $req->availno)->first()->id;
        //         // dd($id_mst_Kodeakses);
        //     }

        // $dbs = new TrxKodeAkses();
        // $req->merge([
        //     'is_active' => 1,
        //     'id_permohonan' => $req->id_izin,
        //     'id_mst_kode_akses' => $id_mst_Kodeakses,
        //     'status_permohonan' => '20',
        //     'jenis_permohonan' => 'Permohonan Baru',
        //     'updated_date' => date('Y-m-d H:i:s'),
        //     'created_date' => date('Y-m-d H:i:s'),
        //     'updated_by' => Auth::user()->id,
        //     'created_by' => Auth::user()->id
        // ]);
        // foreach ($req->only(["id_oss_trxizin", "is_active", 'id_permohonan',"id_mst_kode_akses", "id_izin",
        // 'status_permohonan', 'jenis_permohonan', 'updated_date', 'created_date', 'updated_by', 'created_by']) as
        // $key => $row) {

        //     $dbs->$key = $row;
        // }
        // $izin = Izin_oss::where('id_izin', $req->id_izin)
        // ->update(['status_checklist' => '20','submitted_at' => date('Y-m-d H:i:s')]);
        // $izin_oss = Izin_oss::where('id_izin', $req->id_izin)->first();
        // $izinToLog = $izin_oss->toArray();

        // unset($izinToLog['created_at']);
        // unset($izinToLog['updated_at']);
        // unset($izinToLog['id']);
        // unset($izinToLog['status_checklist']);

        // $id_izin_init = substr($req->id_izin,0,2);
        // if ($id_izin_init == 'IP'){$izinToLog['status_checklist'] = '01';}
        // else{$izinToLog['status_checklist'] = '00';}
        // $izinToLog['created_by'] = Auth::user()->email;
        // $izinToLog['created_name'] = Auth::user()->name;
        // // dd($izinToLog);
        // $insertIzinLog = Izinlog::create($izinToLog);
        // if ($dbs->save()) {
        //     $this->setLog($req->id_oss_trxizin, $id_mst_Kodeakses, $req->id_izin, 'Permohonan Baru');

        //     $jenis_izin = Izin::where('id_izin', $req->id_izin)->first();
        //     $izins = $jenis_izin->toArray();
        //     $nib = $jenis_izin['nib'];
        //     $nibs = Nib::where('nib', $nib)->first();
        //     $nibs = $nibs->toArray();
        //     $common = new CommonHelper();
        //     $email = new EmailHelper();

        //     //penanggungjawab dan kirim email
        //     $penanggungjawab = array();
        //     $email_data = array();
        //     $email_data_koordinator = array();
        //     $penanggungjawab = $common->get_pj_nib($nib);
        //     $catatan_hasil_evaluasi = '';
        //     // $datenow = Carbon::now();
        //     // $date = new DateHelper();
        //     // $date = $date->dateday_lang_reformat_long($datenow);

        //     $jenis_penomoran = DB::table('tb_mst_jenis_kode_akses')->where('short_name', $req->jenisnomor)->first();
        //     // dd($jenis_penomoran);

        //     $departemen = [
        //         "availno" => $req->availno,
        //         "kode_wilayah" => $req->kode_wilayah,
        //         "prefix" => $req->prefix,
        //         "jenis_penomoran" => $jenis_penomoran->full_name,
        //         "jenis_permohonan" => 'Permohonan Baru',
        //     ];

        //     $koreksi_all = '';

        //     $email_jenis = 'pemenuhan-syarat';
        //     $nama2 = '';
        //     $kirim_email = $email->kirim_email($penanggungjawab, $email_jenis, $izins, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all);
        //     //end penganggungjawab

        //     //get jenis Penomoran

        //     //

        //     //kirim email koordinator
        //     $koordinator = DB::table('tb_mst_user_bo')->select('id', 'nama', 'email', 'id_mst_jobposition')
        //         ->where('tb_mst_user_bo.id_mst_jobposition', '=', 13)
        //         ->where('tb_mst_user_bo.is_accounttesting', '!=', 1)
        //         ->first();
        //     $jabatan = DB::table('tb_mst_jobposition')->where('id', $koordinator->id_mst_jobposition)->first();

        //     $user['email'] = isset($koordinator->email) ? $koordinator->email : '';
        //     $user['nama'] = $koordinator->nama;
        //     $nama2 = $koordinator->nama;
        //     $email_jenis = 'koordinator-syarat';
        //     $catatan_hasil_evaluasi = '';

        //     //end mengirim email ke koordinator

        //     $kirim_email2 = $email->kirim_email2($user, $email_jenis, $izins, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, $jabatan);

        //     // return json_encode($dbs);
        //     // return json_encode(array('status' => 'ok;', 'text' => ''))->with('success', 'Data Your files has been successfully added');;
        //     // session()->flash('success', 'Gagal Menghubungi OSS Hub' );
        //     // return redirect('/penomoran/'.$req->id_proyek.'/'.$req->id_izin)->with('success', 'Data Your files has been successfully added');
        //     return redirect('/penomoran-baru')->with('success', 'Data telah berhasil disimpan');
        // } else {
        //     // return back()->with('error', 'failed');
        //     return back()->with('error', 'Gagal Menyimpan Data');

        //     // return json_encode(array('status' => 'error;', 'text' => 'Gagal Menyimpan Data'));
        // }

    }



    public function savepenomoranpenambahan(Request $req)
    {
        if ($req) {
            // dd($req->file('SuratDukungan'));
            $id_mst_Kodeakses = '';
            if ($req->jenisnomor == "Blok Nomor") {
                $id_mst_Kodeakses = '';
                $permohonan = MstKodeAkses::where('prefix', '=', $req->prefix)
                    ->where('kode_wilayah', '=', $req->kode_wilayah)
                    ->first();
                // dd($permohonan);
                if ($permohonan != null) {
                    if ($permohonan->is_active == '0') {
                        return back()->with('error', 'Data Your files has been successfully added');
                    } else {



                        $dbs = MstKodeAkses::find($permohonan->id);
                        $dbs->id_mst_jeniskodeakses = '17';
                        $dbs->is_active = '1';
                        $dbs->save();
                        $id_mst_Kodeakses = $permohonan->id;
                    }
                } else {
                    $mstkodeakses = new MstKodeAkses();
                    $mstkodeakses->kode_wilayah = $req->kode_wilayah;
                    $mstkodeakses->is_active = '0';
                    $mstkodeakses->prefix = $req->prefix;
                    $mstkodeakses->save();
                    $id_mst_Kodeakses = $mstkodeakses->id;
                }
            } else {
                $id_mst_Kodeakses = DB::table('vw_list_penomoran')->select('id')
                    ->where('layanan_name', '=', $req->JenisLayanan)
                    ->where('short_name', '=', $req->jenisnomor)
                    ->where('kode_akses', '=', $req->availno)
                    ->first()->id;
                // dd($id_mst_Kodeakses);
            }
            $dbs = new TrxKodeAkses();

            if ($file1 = $req->file('LaporanPenggunaanPenomoran')) {
                $filename1 = "LaporanPenggunaanPenomoran-" . time() . '.' . $file1->extension();
                $path1 = $file1->storeAs('public/penambahan/penomoran', $filename1);
                $name1 = $file1->getClientOriginalName();
                $path1 = str_replace('public/', 'storage/', $path1);
            }
            if ($file4 = $req->file('DokumenIzin')) {
                $filename4 = "DokumenIzin-" . time() . '.' . $file4->extension();
                $path4 = $file4->storeAs('public/penambahan/penomoran', $filename4);
                $name4 = $file4->getClientOriginalName();
                $path4 = str_replace('public/', 'storage/', $path4);
            }
            if ($file2 = $req->file('ProdukBriefBaru')) {
                $filename2 = "ProdukBriefBaru-" . time() . '.' . $file2->extension();
                $path2 = $file2->storeAs('public/penambahan/penomoran', $filename2);
                $name2 = $file2->getClientOriginalName();
                $path2 = str_replace('public/', 'storage/', $path2);
            }
            if ($file3 = $req->file('SuratDukungan')) {
                $filename3 = "SuratDukungan-" . time() . '.' . $file3->extension();
                $path3 = $file3->storeAs('public/penambahan/penomoran', $filename3);
                $name3 = $file3->getClientOriginalName();
                $path3 = str_replace('public/', 'storage/', $path3);
            }

            $path2 = isset($path2) ? $path2 : '';
            $path3 = isset($path3) ? $path3 : '';
            $maxIdNPT = DB::table('tb_trx_kode_akses')->where('id_permohonan', 'LIKE', 'NPT%')->get()->count();

            if ($maxIdNPT > 0) {
                $maxId = 'NPT-' . date('Ymd') . sprintf("%05s", $maxIdNPT + 1);
            } else {
                $maxId = 'NPT-' . date('Ymd') . sprintf("%05s", 1);
            }
            $id_proyek = $maxId;
            $req->merge([
                'id_permohonan' => $id_proyek,
                'is_active' => 1,
                'id_mst_kode_akses' => $id_mst_Kodeakses,
                'status_permohonan' => '20',
                'dok_pengguna_penomoran' => $path1,
                'dok_kode_akses_konten' => $path2,
                'dok_call_center' => $path3,
                'dok_izin_penyelenggaraan' => $path4,
                'jenis_permohonan' => 'Permohonan Penambahan',
                'updated_date' => date('Y-m-d H:i:s'),
                'created_date' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->id,
                'created_by' => Auth::user()->id
            ]);
            foreach ($req->only(["id_oss_trxizin", "is_active", "id_mst_kode_akses", "id_izin", 'status_permohonan', 'dok_pengguna_penomoran', 'dok_izin_penyelenggaraan', 'dok_kode_akses_konten', 'dok_call_center', 'jenis_permohonan', 'updated_date', 'created_date', 'updated_by', 'created_by']) as $key => $row) {
                $dbs->$key = $row;
            }
            $this->setLogPenambahan($req->id_oss_trxizin, $id_mst_Kodeakses, $req->id_izin, 'Permohonan Penambahan');

            if ($dbs->save()) {

                $jenis_izin = Izin::where('id_izin', $req->id_izin)->first();
                $izins = $jenis_izin->toArray();
                $nib = $jenis_izin['nib'];
                $nibs = Nib::where('nib', $nib)->first();
                $nibs = $nibs->toArray();
                $common = new CommonHelper();
                $email = new EmailHelper();
                //penanggungjawab dan kirim email
                $penanggungjawab = array();
                $email_data = array();
                $email_data_koordinator = array();
                $penanggungjawab = $common->get_pj_nib($nib);
                $catatan_hasil_evaluasi = '';
                // $datenow = Carbon::now();
                // $date = new DateHelper();
                // $date = $date->dateday_lang_reformat_long($datenow);
                $jenis_penomoran = DB::table('tb_mst_jenis_kode_akses')->where('short_name', $req->jenisnomor)->first();

                $departemen = [
                    "availno" => $req->availno,
                    "kode_wilayah" => $req->kode_wilayah,
                    "prefix" => $req->prefix,
                    "jenis_penomoran" => $jenis_penomoran->full_name,
                    "jenis_permohonan" => 'Permohonan Penambahan',
                ];

                $koreksi_all = '';

                $email_jenis = 'pemenuhan-syarat';
                $nama2 = '';
                $kirim_email = $email->kirim_email($penanggungjawab, $email_jenis, $izins, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all);
                //end penganggungjawab


                //kirim email koordinator
                $koordinator = $common->get_koordinator_first(5);
                $jabatan = DB::table('tb_mst_jobposition')->where('id', $koordinator->id_mst_jobposition)->first();

                $user['email'] = isset($koordinator->email) ? $koordinator->email : '';
                $user['nama'] = $koordinator->nama;
                $nama2 = $koordinator->nama;
                $email_jenis = 'koordinator-syarat';
                $catatan_hasil_evaluasi = '';

                //end mengirim email ke koordinator

                $kirim_email2 = $email->kirim_email2($user, $email_jenis, $izins, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, $jabatan);

                // return json_encode($dbs);
                // return json_encode(array('status' => 'ok;', 'text' => ''))->with('success', 'Data Your files has been successfully added');;
                // session()->flash('success', 'Gagal Menghubungi OSS Hub' );
                // return redirect('/penomoran/'.$req->id_proyek.'/'.$req->id_izin)->with('success', 'Data Your files has been successfully added');
                return redirect('/penomoran-baru')->with('success', 'Data Your files has been successfully added');
            } else {
                // return back()->with('error', 'failed');
                return back()->with('error', 'Gagal Menyimpan Data');

                // return json_encode(array('status' => 'error;', 'text' => 'Gagal Menyimpan Data'));
            }
        } else {
            return json_encode(array('status' => 'error;', 'text' => 'Gagal Menyimpan Data'));
        }
    }


    public function savepenyesuaian(Request $req)
    {

        $common = new CommonHelper();
        $id_trx = $req->id_trx;
        $kodeakses = TrxKodeAkses::find($id_trx);
        $kodeaksesarray = $kodeakses->toArray();
        $mst_kodeakses = $common->getDetailKodeAkses($kodeaksesarray, $kodeaksesarray['id_mst_kode_akses']);
        // dd($mst_kodeakses);
        $kodeakses->status_permohonan = 20;
        $kodeakses->jenis_permohonan = 'Permohonan Penyesuaian';
        $path1 = null;
        $path2 = null;
        $path3 = null;
        if ($file1 = $req->file('sk')) {
            $filename1 = "sk-" . time() . '.' . $file1->extension();
            $path1 = $file1->storeAs('public/penyesuaian/penomoran', $filename1);
            $name1 = $file1->getClientOriginalName();
            $path1 = str_replace('public/', 'storage/', $path1);
        }
        if ($file2 = $req->file('izin_akhir')) {
            $filename2 = "izin_akhir-" . time() . '.' . $file2->extension();
            $path2 = $file2->storeAs('public/penyesuaian/penomoran', $filename2);
            $name2 = $file2->getClientOriginalName();
            $path2 = str_replace('public/', 'storage/', $path2);
        }
        if ($file3 = $req->file('pendukung')) {
            $filename3 = "pendukung-" . time() . '.' . $file3->extension();
            $path3 = $file3->storeAs('public/penyesuaian/penomoran', $filename3);
            $name3 = $file3->getClientOriginalName();
            $path3 = str_replace('public/', 'storage/', $path3);
        }
        $kodeakses->pe_dok_sk = $path1;
        $kodeakses->pe_dok_perizinan_terakhir = $path2;
        $kodeakses->pe_dok_pendukung = $path3;
        if ($kodeakses->save()) {
            $this->setLogPenyesuaian($req->id_trx, $kodeakses->id_mst_Kodeakses, $req->id_izin, 'Permohonan Penyesuaian');

            $jenis_izin = Izin::where('id_izin', $req->id_izin)->first();
            $izins = $jenis_izin->toArray();
            $nib = $jenis_izin['nib'];
            $nibs = Nib::where('nib', $nib)->first();
            $nibs = $nibs->toArray();

            $email = new EmailHelper();
            //penanggungjawab dan kirim email
            $penanggungjawab = array();
            $email_data = array();
            $email_data_koordinator = array();
            $penanggungjawab = $common->get_pj_nib($nib);
            $catatan_hasil_evaluasi = '';
            // $datenow = Carbon::now();
            // $date = new DateHelper();
            // $date = $date->dateday_lang_reformat_long($datenow);

            $jenis_penomoran = DB::table('tb_mst_jenis_kode_akses')->where('short_name', $req->jenisnomor)->first();

            $departemen = [
                "full_kode_akses" => $mst_kodeakses['kode_akses']['kode_akses'],
                "jenis_penomoran" => $mst_kodeakses['kode_akses']['jeniskodeakses']['full_name'],
                "jenis_permohonan" => $mst_kodeakses['jenis_permohonan'],
            ];

            $koreksi_all = '';

            $email_jenis = 'pemenuhan-syarat';
            $nama2 = '';
            $kirim_email = $email->kirim_email($penanggungjawab, $email_jenis, $izins, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all);
            //end penganggungjawab


            //kirim email koordinator
            $koordinator = $common->get_koordinator_first(5);
            $jabatan = DB::table('tb_mst_jobposition')->where('id', $koordinator->id_mst_jobposition)->first();

            $user['email'] = isset($koordinator->email) ? $koordinator->email : '';
            $user['nama'] = $koordinator->nama;
            $nama2 = $koordinator->nama;
            $email_jenis = 'koordinator-syarat';
            $catatan_hasil_evaluasi = '';

            //end mengirim email ke koordinator

            $kirim_email2 = $email->kirim_email2($user, $email_jenis, $izins, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, $jabatan);

            // return json_encode($dbs);
            // return json_encode(array('status' => 'ok;', 'text' => ''))->with('success', 'Data Your files has been successfully added');;
            // session()->flash('success', 'Gagal Menghubungi OSS Hub' );
            // return redirect('/penomoran/'.$req->id_proyek.'/'.$req->id_izin)->with('success', 'Permohonan Penyesuaian Berhasil Disubmit.');
            return redirect('/penomoran-baru')->with('success', 'Data Your files has been successfully added');
        } else {
            // return back()->with('error', 'failed');
            return back()->with('error', 'Gagal Menyimpan Data');
            // return json_encode(array('status' => 'error;', 'text' => 'Gagal Menyimpan Data'));
        }
    }

    public function savepengembalian(Request $req)
    {
        dd($req->all());

        $id_jenislayanan = $req->id_jenislayanan;
        $id_jeniskodeakses = $req->id_jeniskodeakses;
        $kodeakses = $req->id_kodeakses;
        $penambahan_flag = false;
        $jenis_permohonan = "Pengembalian Penomoran";

        // dd($req->all());
        if ($file1 = $req->file('SKPenetapanPenomoran')) {
        $filename1 = "SKPenetapanPenomoran-remove" . time() . '.' . $file1->extension();
        $path1 = $file1->storeAs('public/pengembalian/penomoran', $filename1);
        $name1 = $file1->getClientOriginalName();
        $path1 = str_replace('public/', 'storage/', $path1);
        // $penambahan_flag = true;
        }
        
        // dd($id_jenislayanan, $id_jeniskodeakses, $kodeakses);
        $oss_id = Auth::user()->oss_id;
        $oss_nib = DB::table('tb_oss_nib')->select('*')->where('oss_id', $oss_id)->first();

        $maxId = DB::table('tb_oss_trx_izin')->where('id_izin', 'LIKE', substr($oss_id, 0, 3) . '%')->get()->count();

        if ($maxId > 0) {
        $maxId = substr($oss_id, 0, 3) . '-' . date('Ymd') . sprintf("%05s", $maxId + 1);
        } else {
        $maxId = substr($oss_id, 0, 3) . '-' . date('Ymd') . sprintf("%05s", 1);
        }

        $jenis_izin = 'K03';
        $msg_success = 'Permohonan sudah berhasil disimpan dan akan dilakukan verifikasi.';
        $msg_failed = 'Mohon maaf permohonan penomoran tidak dapat diajukan, karena terdapat permohonan yang masih
        belum selesai dengan jenis permohonan kode akses yang sama';
        // dd($oss_id, $id_jenislayanan,$id_jeniskodeakses);
        $cek_openstatusizin_nomor = DB::table('tb_oss_trx_izin')->select('*')
        ->where('oss_id', $oss_id)
        ->where('kd_izin', $id_jenislayanan)
        ->where('id_proyek', $id_jeniskodeakses)
        ->whereNotIn('status_checklist', ['50', '90', '51'])
        ->get();

        if ($cek_openstatusizin_nomor->count() > 0) {
        return redirect('/')->with('message', $msg_failed);
        } else {
        $insert = new Izinoss([
        'oss_id' => $oss_id,
        'id_proyek' => $id_jeniskodeakses,
        'nib' => $oss_nib->nib,
        'id_izin' => $maxId,
        'jenis_izin' => $jenis_izin,
        'kd_daerah' => $oss_nib->perseroan_daerah_id,
        'kd_izin' => $id_jenislayanan,
        'status_checklist' => '20',
        ]);

        $insert->save();
        
        if (!isset($req->availno)) {
        // dd($req->bloknomor);
        foreach ($req->bloknomor as $p) {
        // dd($p['kode_wilayah']);
        $bloknomor_query = DB::table('tb_trx_kode_akses_alokasi_bloknomor')
        ->where('kode_wilayah','=',$p['kode_wilayah'])
        ->where('prefix_awal','=',$p['prefix'])->get();
        $bloknomor_query_count = $bloknomor_query->count();
        if($bloknomor_query_count>0){
            $bloknomor_query = DB::table('tb_trx_kode_akses_alokasi_bloknomor')
            ->where('kode_wilayah','=',$p['kode_wilayah'])
            ->where('prefix_awal','=',$p['prefix'])
            ->update([
            'status' => 'EVALUASI'
            ]);
        }
        else{}
        $insertBlokNomor = [
        'id_izin' => $maxId,
        'id_mst_jenis_kode_akses' => '17',
        'jenis_penomoran' => 'Blok Nomor',
        'kode_wilayah' => $p['kode_wilayah'],
        'prefix_awal' => $p['prefix'],
        'id_mst_kodestatusizin' => '913',
        'status' => 'EVALUASI',
        'nomor_penetapan' => '',
        'tanggal_penetapan' => null,
        'nama_pelakuusaha' => null,
        'nib' => $oss_id,
        'is_active' => '1',
        'updated_date' => date('Y-m-d H:i:s'),
        'created_date' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
        'created_by' => Auth::user()->id
        ];
        $bloknomor_query = DB::table('tb_trx_kode_akses_alokasi_bloknomor')->insert($insertBlokNomor);
        }
        // dd($insertBlokNomor);
        }

        $insert_trxkodeakses = new TrxKodeAkses([
        'is_active' => 1,
        'id_permohonan' => $maxId,
        'id_izin' => $maxId,
        'id_mst_kode_akses' => $kodeakses,
        'status_permohonan' => '20',
        'jenis_permohonan' => $jenis_permohonan,
        'pe_dok_sk' => $path1,
        'updated_date' => date('Y-m-d H:i:s'),
        'created_date' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
        'created_by' => Auth::user()->id
        ]);
        
        $insert_trxkodeakses->save();

        if ($insert_trxkodeakses->save()) {
        $penomoran_alokasi =
        DB::table('tb_trx_kode_akses_alokasi')->select('*')->where(
        'id',
        '=',
        $kodeakses
        )->update([
        'status' => 'Evaluasi'
        ]);
        $this->setLog($req->id_oss_trxizin, $kodeakses, $maxId, $jenis_permohonan);

        $jenis_izin = Izin::where('id_izin', $maxId)->first();
        $izins = $jenis_izin->toArray();
        $nib = $jenis_izin['nib'];
        $nibs = Nib::where('nib', $nib)->first();
        $nibs = $nibs->toArray();
        $common = new CommonHelper();
        $email = new EmailHelper();

        //penanggungjawab dan kirim email
        $penanggungjawab = array();
        $email_data = array();
        $email_data_koordinator = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        $catatan_hasil_evaluasi = '';
        // $datenow = Carbon::now();
        // $date = new DateHelper();
        // $date = $date->dateday_lang_reformat_long($datenow);

        $jenis_penomoran = DB::table('tb_mst_jenis_kode_akses')->where(
        'short_name',
        $id_jeniskodeakses
        )->first();
        // dd($jenis_penomoran);

        $departemen = [
        // "availno" => $req->availno,
        // "kode_wilayah" => $req->kode_wilayah,
        // "prefix" => $req->prefix,
        "jenis_penomoran" => $jenis_penomoran->full_name,
        "jenis_permohonan" => 'Pengembalian Penomoran',
        ];

        $koreksi_all = '';

        $email_jenis = 'pemenuhan-syarat';
        $nama2 = '';
        $kirim_email = $email->kirim_email($penanggungjawab, $email_jenis, $izins, $departemen, $catatan_hasil_evaluasi,
        $nama2, $nibs, $koreksi_all);
        //end penganggungjawab

        //get jenis Penomoran

        //

        //kirim email koordinator
        $koordinator = DB::table('tb_mst_user_bo')->select('id', 'nama', 'email', 'id_mst_jobposition')
        ->where('tb_mst_user_bo.id_mst_jobposition', '=', 13)
        ->where('tb_mst_user_bo.is_accounttesting', '!=', 1)
        ->first();
        $jabatan = DB::table('tb_mst_jobposition')->where('id', $koordinator->id_mst_jobposition)->first();

        $user['email'] = isset($koordinator->email) ? $koordinator->email : '';
        $user['nama'] = $koordinator->nama;
        $nama2 = $koordinator->nama;
        $email_jenis = 'koordinator-syarat';
        $catatan_hasil_evaluasi = '';

        //end mengirim email ke koordinator

        $kirim_email2 = $email->kirim_email2($user, $email_jenis, $izins, $departemen, $catatan_hasil_evaluasi, $nama2,
        $nibs, $koreksi_all, $jabatan);

        // return json_encode($dbs);
        // return json_encode(array('status' => 'ok;', 'text' => ''))->with('success', 'Data Your files has been  successfully added');;
        // session()->flash('success', 'Gagal Menghubungi OSS Hub' );
        // return redirect('/penomoran/'.$req->id_proyek.'/'.$req->id_izin)->with('success', 'Data Your files has been  successfully added');
        // return redirect('/penomoran-baru')->with('success', 'Data telah berhasil disimpan');
        } else {
        // return back()->with('error', 'failed');
        return back()->with('error', 'Gagal Menyimpan Data');

        // return json_encode(array('status' => 'error;', 'text' => 'Gagal Menyimpan Data'));
        }

        return redirect('/')->with('message', $msg_success);
        }
    }

    public function getidmstkodeakses()
    {
    }


    public function penyesuaian(Request $req)
    {
        $id_proyek = $req->id_proyek;
        $id_izin = $req->id_izin;
        $id_trx = $req->id_trx;
        // $data = DB::table('vw_list_izin')->select('*')->where('id_izin', '=', $id_izin)->first();
        $data = DB::table('tb_trx_kode_akses')->select('tb_mst_kode_akses.*', 'tb_mst_jenis_kode_akses.full_name', 'tb_trx_kode_akses.status_permohonan', 'tb_oss_mst_kodestatusizin.name_status_bo as status_bo', 'tb_trx_kode_akses.*', 'tb_trx_kode_akses.id as idtrxkodeakses')
            ->join('tb_mst_kode_akses', 'tb_mst_kode_akses.id', '=', 'tb_trx_kode_akses.id_mst_kode_akses')
            ->join('tb_mst_jenis_kode_akses', 'tb_mst_jenis_kode_akses.id', '=', 'tb_mst_kode_akses.id_mst_jeniskodeakses')
            ->leftJoin('tb_oss_mst_kodestatusizin', 'tb_oss_mst_kodestatusizin.oss_kode', '=', 'tb_trx_kode_akses.status_permohonan')
            ->where('tb_trx_kode_akses.id_izin', '=', $id_izin)
            ->first();
        // dd($data);
        return view('layouts/frontend/penomoran/penomoran-se', compact('data', 'id_proyek', 'id_izin', 'id_trx'));
    }

    public function pengembalian(Request $req)
    {
        $id_izin = $req->id_izin;
        $id_trx = $req->id_trx;
        $id_proyek = $req->id_proyek;
        $data = DB::table('tb_trx_kode_akses')->select('tb_mst_kode_akses.*', 'tb_mst_jenis_kode_akses.full_name', 'tb_trx_kode_akses.status_permohonan', 'tb_oss_mst_kodestatusizin.name_status_bo as status_bo', 'tb_trx_kode_akses.*', 'tb_trx_kode_akses.id as idtrxkodeakses')
            ->join('tb_mst_kode_akses', 'tb_mst_kode_akses.id', '=', 'tb_trx_kode_akses.id_mst_kode_akses')
            ->join('tb_mst_jenis_kode_akses', 'tb_mst_jenis_kode_akses.id', '=', 'tb_mst_kode_akses.id_mst_jeniskodeakses')
            ->leftJoin('tb_oss_mst_kodestatusizin', 'tb_oss_mst_kodestatusizin.oss_kode', '=', 'tb_trx_kode_akses.status_permohonan')
            ->where('tb_trx_kode_akses.id_izin', '=', $id_izin)
            ->first();
        return view('layouts.frontend.penomoran.penomoran-pe', compact('id_trx', 'id_izin', 'id_proyek', 'data'));
    }

    public function listpengajuan(Request $req)
    {
        # code...
    }

    public function setLog($id_oss_trxizin, $id_mst_Kodeakses, $id_izin, $jenis_permohonan)
    {
        $log = new LogKodeAkses();
        $log->id_oss_trxizin = $id_oss_trxizin;
        $log->id_mst_kode_akses = $id_mst_Kodeakses;
        $log->id_izin = $id_izin;
        $log->status_permohonan = '00';
        $log->jenis_permohonan = $jenis_permohonan;
        $log->is_active = 1;
        $log->updated_date = date('Y-m-d H:i:s');
        $log->created_date = date('Y-m-d H:i:s');
        $log->created_by = Auth::user()->id;
        $log->created_name = Auth::user()->name;

        return $log->save();
    }

    public function setLogPenambahan($id_oss_trxizin, $id_mst_Kodeakses, $id_izin, $jenis_permohonan)
    {
        $log = new LogKodeAkses();
        $log->id_oss_trxizin = $id_oss_trxizin;
        $log->id_mst_kode_akses = $id_mst_Kodeakses;
        $log->id_izin = $id_izin;
        $log->status_permohonan = '906';
        $log->jenis_permohonan = $jenis_permohonan;
        $log->is_active = 1;
        $log->updated_date = date('Y-m-d H:i:s');
        $log->created_date = date('Y-m-d H:i:s');
        $log->created_by = Auth::user()->id;
        $log->created_name = Auth::user()->name;

        return $log->save();
    }

    public function setLogPenyesuaian($id_oss_trxizin, $id_mst_Kodeakses, $id_izin, $jenis_permohonan)
    {
        $log = new LogKodeAkses();
        $log->id_oss_trxizin = $id_oss_trxizin;
        $log->id_mst_kode_akses = $id_mst_Kodeakses;
        $log->id_izin = $id_izin;
        $log->status_permohonan = '909';
        $log->jenis_permohonan = $jenis_permohonan;
        $log->is_active = 1;
        $log->updated_date = date('Y-m-d H:i:s');
        $log->created_date = date('Y-m-d H:i:s');
        $log->created_by = Auth::user()->id;
        $log->created_name = Auth::user()->name;

        return $log->save();
    }

    public function setLogPengembalian($id_oss_trxizin, $id_mst_Kodeakses, $id_izin, $jenis_permohonan)
    {
        $log = new LogKodeAkses();
        $log->id_oss_trxizin = $id_oss_trxizin;
        $log->id_mst_kode_akses = $id_mst_Kodeakses;
        $log->id_izin = $id_izin;
        $log->status_permohonan = '907';
        $log->jenis_permohonan = $jenis_permohonan;
        $log->is_active = 1;
        $log->updated_date = date('Y-m-d H:i:s');
        $log->created_date = date('Y-m-d H:i:s');
        $log->created_by = Auth::user()->id;
        $log->created_name = Auth::user()->name;

        return $log->save();
    }

    public function logPenomoran(Request $req)
    {
        $id_izin = $req->id_izin;
        // $id_kode_akses = $req->id_kode_akses;

        $penomoranlog = Penomoranlog::where('id_izin', '=', $id_izin)
            // ->where('id_kode_akses','=',$id_kode_akses)
            ->with('KodeIzin')->get()->toArray();


        $date_reformat = new DateHelper();

        // dd($history);   

        return view('layouts.frontend.historyperizinan.dashboard2', ['penomoranlog' => $penomoranlog, 'date_reformat' => $date_reformat]);
    }
}