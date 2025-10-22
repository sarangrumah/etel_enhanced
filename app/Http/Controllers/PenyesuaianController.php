<?php

namespace App\Http\Controllers;

use App\Helpers\UtilPerizinan;
use App\Models\Admin\Izinoss;
use App\Models\Proyek;
use App\Models\TrxUlo;
use App\Models\Izin_oss;
use App\Models\MstIzin;
use App\Models\MstIzinSyarat;
use App\Models\Admin\Izin;
use App\Models\Admin\Nib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\DateHelper;
use App\Models\TrxPemenuhanSyarat;
use App\Helpers\CommonHelper;
use App\Helpers\EmailHelper;
use Carbon\Carbon;
use Session;
use Config;
use App\Models\OffDay;

class PenyesuaianController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function komitmen($id){
        // dd(Auth::user()->name);
        $date_reformat = new DateHelper();
        // $workingDays = $date_reformat->getWorkingDays(date('Y-m-d'), date('Y')."-12-31", $this->offDay());
        // if ($workingDays < 20) {
        //     return redirect('/')->with('message', 'Perubahan komitmen di tahun berikutnya hanya bisa dilakukan maksimal 20 hari kerja sebelum tahun berjalan berakhir');
        // }
        $common = new CommonHelper;
        $id_departemen_user = Session::get('id_departemen');
        $limit_db = Config::get('app.admin.limit');
        // $status_checklist = 901;
        $izin = Izin::select('*')->where('id_izin', '=', $id)
            // ->where('status_checklist', '=', $status_checklist)
            // ->orWhere(function($query) {
            //     $query->where('status_checklist', 901);
            // })
            ->first();
        $ulo = DB::table('tb_trx_ulo_sk')->where('id_izin', '=', $id)->first();

        // if ($izin == null || $ulo == null) {
        //     return abort(404);
        // }
        $izin = $izin->toArray();
        $nib = $izin['nib'];
        $kd_izin = $izin['kd_izin'];

        $detailNib = Nib::select('*')->where('nib', '=', $nib)->first();
        if (empty($detailNib)) {
            $detailNib = array();
        } else {
            $detailNib->toArray();
        }

        $map_izin = array();
        $filled_persyaratan = array();

        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=', $kd_izin)->first();
        $id_mst_izinlayanan = $mst_kode_izin->id;

        $map_izin = $common->get_map_izin($id_mst_izinlayanan);
        // dd($map_izin);


        $filled_persyaratan = DB::table('tb_trx_persyaratan')->select('*')->where('id_trx_izin', '=', $id)->get();
        $filled_persyaratan = $filled_persyaratan->toArray();

        // dd($map_izin);

        foreach ($map_izin as $key => $value) {
            // echo $value->persyaratan;
            // echo "<br>=============<br>";
            $map_izin[$key] = $value;
            foreach ($filled_persyaratan as $key2 => $value2) {
                if ($value->id == $value2->id_map_listpersyaratan) {
                    // echo $value->persyaratan;
                    // echo "<br>=============<br>";
                    // echo $value2->filled_document;
                    // echo "<br>******************<br>";
                    $map_izin[$key]->id_map_listpersyaratan = $value2->id_map_listpersyaratan;
                    $map_izin[$key]->form_isian = $value2->filled_document;
                    $map_izin[$key]->nama_asli = $value2->nama_file_asli;
                    $map_izin[$key]->need_correction = $value2->need_correction;
                    $map_izin[$key]->correction_note = $value2->correction_note;
                    // if ($value->component_name == 'roll_out_plan_jartup_fo_ter') {
                    //     // dd(json_decode($value2->filled_document, true));

                    //     foreach (json_decode($value2->filled_document, true) as $key => $value) {
                    //         dd(date('Y-m-d', strtotime('+'. $value['periode'] - 1 .' year', strtotime($ulo->created_at))));
                    //     }
                    // }
                }
            }
        }
        // dd($map_izin);
        $html = array();
        // $html = view('users.edit', compact('user'))->render();

        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        $cities = DB::table('tb_mst_kabupaten')->select('id', 'name')->get();
        $triger = Session::get('id_mst_jobposition');
        
        return view('penyesuaian.index', ['date_reformat' => $date_reformat, 'id' => $id, 'cities' => $cities, 'izin' => $izin, 'detailnib' => $detailNib, 'penanggungjawab' => $penanggungjawab, 'map_izin' => $map_izin, 'filled_persyaratan' => $filled_persyaratan, 'triger' => $triger, 'ulo' => $ulo]);
    }

    public function komitmenPenyesuaian($id){
        // dd(Auth::user()->name);
        $date_reformat = new DateHelper();
        // $workingDays = $date_reformat->getWorkingDays(date('Y-m-d'), date('Y')."-12-31", $this->offDay());
        // if ($workingDays < 20) {
        //     return redirect('/')->with('message', 'Perubahan komitmen di tahun berikutnya hanya bisa dilakukan maksimal 20 hari kerja sebelum tahun berjalan berakhir');
        // }
        $common = new CommonHelper;
        $id_departemen_user = Session::get('id_departemen');
        $limit_db = Config::get('app.admin.limit');
        // $status_checklist = 901;
        $izin = Izin::select('*')->where('id_izin', '=', $id)
            // ->where('status_checklist', '=', $status_checklist)
            // ->orWhere(function($query) {
            //     $query->where('status_checklist', 901);
            // })
            ->first();
        $ulo = DB::table('tb_trx_ulo_sk')->where('id_izin', '=', $id)->first();

        // if ($izin == null || $ulo == null) {
        //     return abort(404);
        // }
        $izin = $izin->toArray();
        $nib = $izin['nib'];
        $kd_izin = $izin['kd_izin'];

        $detailNib = Nib::select('*')->where('nib', '=', $nib)->first();
        if (empty($detailNib)) {
            $detailNib = array();
        } else {
            $detailNib->toArray();
        }

        $map_izin = array();
        $filled_persyaratan = array();

        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=', $kd_izin)->first();
        $id_mst_izinlayanan = $mst_kode_izin->id;

        $map_izin = $common->get_map_izin($id_mst_izinlayanan);
        // dd($map_izin);


        $filled_persyaratan = DB::table('tb_trx_persyaratan')->select('*')->where('id_trx_izin', '=', $id)->get();
        $filled_persyaratan = $filled_persyaratan->toArray();

        // dd($map_izin);

        foreach ($map_izin as $key => $value) {
            // echo $value->persyaratan;
            // echo "<br>=============<br>";
            $map_izin[$key] = $value;
            foreach ($filled_persyaratan as $key2 => $value2) {
                if ($value->id == $value2->id_map_listpersyaratan) {
                    // echo $value->persyaratan;
                    // echo "<br>=============<br>";
                    // echo $value2->filled_document;
                    // echo "<br>******************<br>";
                    $map_izin[$key]->id_map_listpersyaratan = $value2->id_map_listpersyaratan;
                    $map_izin[$key]->form_isian = $value2->filled_document;
                    $map_izin[$key]->nama_asli = $value2->nama_file_asli;
                    $map_izin[$key]->need_correction = $value2->need_correction;
                    $map_izin[$key]->correction_note = $value2->correction_note;
                    // if ($value->component_name == 'roll_out_plan_jartup_fo_ter') {
                    //     // dd(json_decode($value2->filled_document, true));

                    //     foreach (json_decode($value2->filled_document, true) as $key => $value) {
                    //         dd(date('Y-m-d', strtotime('+'. $value['periode'] - 1 .' year', strtotime($ulo->created_at))));
                    //     }
                    // }
                }
            }
        }
        // dd($map_izin);
        $html = array();
        // $html = view('users.edit', compact('user'))->render();

        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        $cities = DB::table('tb_mst_kabupaten')->select('id', 'name')->get();
        $triger = Session::get('id_mst_jobposition');
        
        return view('penyesuaian.penyesuaian', ['date_reformat' => $date_reformat, 'id' => $id, 'cities' => $cities, 'izin' => $izin, 'detailnib' => $detailNib, 'penanggungjawab' => $penanggungjawab, 'map_izin' => $map_izin, 'filled_persyaratan' => $filled_persyaratan, 'triger' => $triger, 'ulo' => $ulo]);
    }

    public function suratSubmit(Request $req){
        if ($file1 = $req->file('surat_pernyataan')) {
            $filename1 = "surat_pernyataan-" . time() . '.' . $file1->extension();
            $path1 = $file1->storeAs('public/penyesuaian/komitmen', $filename1);
            $name1 = $file1->getClientOriginalName();
            $path1 = str_replace('public/', 'storage/', $path1);
            $requestData['surat_pernyataan'] = $path1;

            $requestData['id_izin'] = $req->id_izin;
            $requestData['tgl_pengajuan'] = date('Y-m-d H:i:s');
            $requestData['status_penyesuaian'] = 0;
            $requestData['created_date'] = date('Y-m-d H:i:s');
            $requestData['created_by'] = 0;
            
            $data = DB::table('tb_trx_penyesuaian_komitmen')->insert($requestData);
        }else{
            return back()->with('error', 'Gagal Menyimpan Data');
        }

        return redirect('/')->with('success', 'Data Your files has been successfully submited');
    }

    public function komitmenSubmit(Request $req){
        if ($file1 = $req->file('surat_pernyataan')) {
            $filename1 = "surat_pernyataan-" . time() . '.' . $file1->extension();
            $path1 = $file1->storeAs('public/penyesuaian/komitmen', $filename1);
            $name1 = $file1->getClientOriginalName();
            $path1 = str_replace('public/', 'storage/', $path1);
            $requestData['surat_pernyataan'] = $path1;

            $requestData['id_izin'] = $req->id_izin;
            $requestData['tgl_pengajuan'] = date('Y-m-d H:i:s');
            $requestData['status_penyesuaian'] = 0;
            $requestData['status_komitmen'] = 1;
            $requestData['created_date'] = date('Y-m-d H:i:s');
            $requestData['created_by'] = 0;

            $data = DB::table('tb_trx_penyesuaian_komitmen')->insert($requestData);
        }

        // update rencanausaha
        if (isset($req->rencanausaha)) {
            $insertPerencanaan = [
                'id_izin' => $req->id_izin,
                'id_map_listpersyaratan' => $req->id_maplist_rencanausaha,
                'filled_document' => json_encode($req->rencanausaha)
            ];

            $rencanausaha = DB::table('tb_trx_persyaratan_komitmen')->insert($insertPerencanaan);
        }

        // update rolloutplan
        if (isset($req->rolloutplan)) {
            $insertRollOutPlan = [
                'id_izin' => $req->id_izin,
                'id_map_listpersyaratan' => $req->id_maplist_roll_out_plan,
                'filled_document' => json_encode($req->rolloutplan)
            ];

            $rolloutplan = DB::table('tb_trx_persyaratan_komitmen')->insert($insertRollOutPlan);
        }

        // update komitmen layanan 5 tahun
        if (isset($req->komitmen_kinerja_layanan_lima_tahun)) {
            $insertKomitmenLayananLimaTahun = [
                'id_izin' => $req->id_izin,
                'id_map_listpersyaratan' => $req->id_komitmen_kinerja_layanan_lima_tahun,
                'filled_document' => json_encode($req->komitmen_kinerja_layanan_lima_tahun),
            ];
            $komitmenlayananlimatahun = DB::table('tb_trx_persyaratan_komitmen')->insert($insertKomitmenLayananLimaTahun);
        }

        $common = new CommonHelper;
        $email = new EmailHelper();
        $id_departemen_user = Session::get('id_departemen');
        $departemen = $common->getDepartemen($id_departemen_user);
        $jenis_izin = Izin::where('id_izin', $req->id_izin)->first();
        $izins = $jenis_izin->toArray();
        $nib = $jenis_izin['nib'];
        $nibs = Nib::where('nib', $nib)->first();
        $nibs = $nibs->toArray();
        $jenis_izin = $jenis_izin->nama_master_izin;

        //penanggungjawab dan kirim email
        $koreksi_all = 0;
        $penanggungjawab = array();
        $email_data = array();
        $email_data_koordinator = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        $catatan_hasil_evaluasi = '';
        $datenow = Carbon::now();
        $date = new DateHelper();
        $date = $date->dateday_lang_reformat_long($datenow);
        // dd($date);

        // dd($penanggungjawab);

        $email_jenis = 'pemenuhan-syarat';
        $nama2 = '';
        $kirim_email = $email->kirim_email($penanggungjawab, $email_jenis, $izins, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all);
        //end penganggungjawab

        //kirim email koordinator
        if ($jenis_izin == 'TELSUS') {
            $id_departemen_user = 3;
        } elseif ($jenis_izin == 'JASA') {
            $id_departemen_user = 1;
        } elseif ($jenis_izin == 'JARINGAN') {
            $id_departemen_user = 2;
        }
        // dd($jenis_izin);
        $koordinator = $common->get_koordinator_first($id_departemen_user);
        $jabatan = DB::table('tb_mst_jobposition')->where('id', $koordinator->id_mst_jobposition)->first();

        $user['email'] = isset($koordinator->email) ? $koordinator->email : '';
        $user['nama'] = $koordinator->nama;
        $nama2 = $koordinator->nama;
        $email_jenis = 'koordinator-syarat';
        $catatan_hasil_evaluasi = '';

        //end mengirim email ke koordinator
        $kirim_email2 = $email->kirim_email2($user, $email_jenis, $izins, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, $jabatan);

        return redirect('/')->with('success', 'Data Your files has been successfully submited');
    }

    public function komitmenPenyesuaianSubmit(Request $req){
        if ($file1 = $req->file('surat_pernyataan')) {
            $filename1 = "surat_pernyataan-" . time() . '.' . $file1->extension();
            $path1 = $file1->storeAs('public/penyesuaian/komitmen', $filename1);
            $name1 = $file1->getClientOriginalName();
            $path1 = str_replace('public/', 'storage/', $path1);
            $requestData['surat_pernyataan'] = $path1;

            $requestData['id_izin'] = $req->id_izin;
            $requestData['tgl_pengajuan'] = date('Y-m-d H:i:s');
            $requestData['status_penyesuaian'] = 0;
            $requestData['status_komitmen'] = 2;
            $requestData['created_date'] = date('Y-m-d H:i:s');
            $requestData['created_by'] = 0;

            $data = DB::table('tb_trx_penyesuaian_komitmen')->insert($requestData);
        }
        // update rencanausaha
        if (isset($req->rencanausaha)) {
            $insertPerencanaan = [
                'id_izin' => $req->id_izin,
                'id_map_listpersyaratan' => $req->id_maplist_rencanausaha,
                'filled_document' => json_encode($req->rencanausaha)
            ];

            $rencanausaha = DB::table('tb_trx_persyaratan_komitmen')->insert($insertPerencanaan);
        }

        // update rolloutplan
        if (isset($req->rolloutplan)) {
            $insertRollOutPlan = [
                'id_izin' => $req->id_izin,
                'id_map_listpersyaratan' => $req->id_maplist_roll_out_plan,
                'filled_document' => json_encode($req->rolloutplan)
            ];

            $rolloutplan = DB::table('tb_trx_persyaratan_komitmen')->insert($insertRollOutPlan);
        }

        // update komitmen layanan 5 tahun
        if (isset($req->komitmen_kinerja_layanan_lima_tahun)) {
            $insertKomitmenLayananLimaTahun = [
                'id_izin' => $req->id_izin,
                'id_map_listpersyaratan' => $req->id_komitmen_kinerja_layanan_lima_tahun,
                'filled_document' => json_encode($req->komitmen_kinerja_layanan_lima_tahun),
            ];
            $komitmenlayananlimatahun = DB::table('tb_trx_persyaratan_komitmen')->insert($insertKomitmenLayananLimaTahun);
        }

        $common = new CommonHelper;
        $email = new EmailHelper();
        $id_departemen_user = Session::get('id_departemen');
        $departemen = $common->getDepartemen($id_departemen_user);
        $jenis_izin = Izin::where('id_izin', $req->id_izin)->first();
        $izins = $jenis_izin->toArray();
        $nib = $jenis_izin['nib'];
        $nibs = Nib::where('nib', $nib)->first();
        $nibs = $nibs->toArray();
        $jenis_izin = $jenis_izin->nama_master_izin;

        //penanggungjawab dan kirim email
        $koreksi_all = 0;
        $penanggungjawab = array();
        $email_data = array();
        $email_data_koordinator = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        $catatan_hasil_evaluasi = '';
        $datenow = Carbon::now();
        $date = new DateHelper();
        $date = $date->dateday_lang_reformat_long($datenow);
        // dd($date);

        // dd($penanggungjawab);

        $email_jenis = 'pemenuhan-syarat';
        $nama2 = '';
        $kirim_email = $email->kirim_email($penanggungjawab, $email_jenis, $izins, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all);
        //end penganggungjawab

        //kirim email koordinator
        if ($jenis_izin == 'TELSUS') {
            $id_departemen_user = 3;
        } elseif ($jenis_izin == 'JASA') {
            $id_departemen_user = 1;
        } elseif ($jenis_izin == 'JARINGAN') {
            $id_departemen_user = 2;
        }
        // dd($jenis_izin);
        $koordinator = $common->get_koordinator_first($id_departemen_user);
        $jabatan = DB::table('tb_mst_jobposition')->where('id', $koordinator->id_mst_jobposition)->first();

        $user['email'] = isset($koordinator->email) ? $koordinator->email : '';
        $user['nama'] = $koordinator->nama;
        $nama2 = $koordinator->nama;
        $email_jenis = 'koordinator-syarat';
        $catatan_hasil_evaluasi = '';

        //end mengirim email ke koordinator
        $kirim_email2 = $email->kirim_email2($user, $email_jenis, $izins, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, $jabatan);

        return redirect('/')->with('success', 'Data Your files has been successfully submited');
    }

    public function formpersyaratan($id)
    {
        $date_reformat = new DateHelper();

        $common = new CommonHelper;
        $id_departemen_user = Session::get('id_departemen');
        $limit_db = Config::get('app.admin.limit');
        // $status_checklist = 901;
        $izin = Izin::select('*')->where('id_izin', '=', $id)
            // ->where('status_checklist', '=', $status_checklist)
            // ->orWhere(function($query) {
            //     $query->where('status_checklist', 901);
            // })
            ->first();
        // dd($izin);
        if ($izin == null) {
            return abort(404);
        }
        $izin = $izin->toArray();
        $nib = $izin['nib'];
        $kd_izin = $izin['kd_izin'];
        $ulo = DB::table('tb_trx_ulo_sk')->where('id_izin', '=', $id)->first();
        $detailNib = Nib::select('*')->where('nib', '=', $nib)->first();
        if (empty($detailNib)) {
            $detailNib = array();
        } else {
            $detailNib->toArray();
        }

        $map_izin = array();
        $filled_persyaratan = array();

        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=', $kd_izin)->first();
        $id_mst_izinlayanan = $mst_kode_izin->id;

        $map_izin = $common->get_map_izin($id_mst_izinlayanan);
        // dd($map_izin);


        $filled_persyaratan = DB::table('tb_trx_persyaratan_komitmen')->select('*')->where('id_izin', '=', $id)->get();
        $filled_persyaratan = $filled_persyaratan->toArray();

        // dd($map_izin);

        foreach ($map_izin as $key => $value) {
            // echo $value->persyaratan;
            // echo "<br>=============<br>";
            $map_izin[$key] = $value;
            foreach ($filled_persyaratan as $key2 => $value2) {
                if ($value->id == $value2->id_map_listpersyaratan) {
                    // echo $value->persyaratan;
                    // echo "<br>=============<br>";
                    // echo $value2->filled_document;
                    // echo "<br>******************<br>";
                    $map_izin[$key]->id_map_listpersyaratan = $value2->id_map_listpersyaratan;
                    $map_izin[$key]->form_isian = $value2->filled_document;
                    $map_izin[$key]->nama_asli = $value2->nama_file_asli;
                    $map_izin[$key]->need_correction = $value2->need_correction;
                    $map_izin[$key]->correction_note = $value2->correction_note;
                }
            }
        }

        $html = array();
        // $html = view('users.edit', compact('user'))->render();

        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        $cities = DB::table('tb_mst_kabupaten')->select('id', 'name')->get();
        $triger = Session::get('id_mst_jobposition');
        // dd($triger);
        // die;
        $penyesuaian = DB::table('tb_trx_penyesuaian_komitmen')->where('id_izin', $id)->where('is_active', NULL)->first();
        $component['roll_out_plan_jartup_fo_ter'] = "roll_out_plan_jartup_fo_ter";
        $component['komitmen_kinerja_layanan_lima_tahun'] = "komitmen_kinerja_layanan_lima_tahun";

        return view('koreksisyarat.penyesuaian', ['date_reformat' => $date_reformat, 'id' => $id, 'cities' => $cities, 'izin' => $izin, 'detailnib' => $detailNib, 'penanggungjawab' => $penanggungjawab, 'map_izin' => $map_izin, 'filled_persyaratan' => $filled_persyaratan, 'triger' => $triger, 'penyesuaian' => $penyesuaian, 'component' => $component, 'ulo' => $ulo]);
    }

    public function formpersyaratanSubmit(Request $req)
    {
        if ($file1 = $req->file('surat_pernyataan')) {
            $filename1 = "surat_pernyataan-" . time() . '.' . $file1->extension();
            $path1 = $file1->storeAs('public/penyesuaian/komitmen', $filename1);
            $name1 = $file1->getClientOriginalName();
            $path1 = str_replace('public/', 'storage/', $path1);
            $requestData['surat_pernyataan'] = $path1;
        }

        $requestData['need_correction'] = 0;
        $requestData['status_penyesuaian'] = 20;
        $requestData['updated_date'] = date('Y-m-d H:i:s');

        $data = DB::table('tb_trx_penyesuaian_komitmen')->where('id_izin', $req->id_izin)->update($requestData);

        // update rencanausaha
        if (isset($req->rencanausaha)) {
            $insertPerencanaan = [
                'id_izin' => $req->id_izin,
                'id_map_listpersyaratan' => $req->id_maplist_rencanausaha,
                'filled_document' => json_encode($req->rencanausaha)
            ];

            $rencanausaha = DB::table('tb_trx_persyaratan_komitmen')
                            ->where('id_map_listpersyaratan', '=', $req->id_maplist_rencanausaha)                    
                            ->where('id_izin', $req->id_izin)->update($insertPerencanaan);
        }

        // update rolloutplan
        if (isset($req->rolloutplan)) {
            $insertRollOutPlan = [
                'id_izin' => $req->id_izin,
                'id_map_listpersyaratan' => $req->id_maplist_roll_out_plan,
                'filled_document' => json_encode($req->rolloutplan)
            ];

            $rolloutplan = DB::table('tb_trx_persyaratan_komitmen')
                           ->where('id_map_listpersyaratan', '=', $req->id_maplist_roll_out_plan)
                           ->where('id_izin', $req->id_izin)->update($insertRollOutPlan);
        }

        // update komitmen layanan 5 tahun
        if (isset($req->komitmen_kinerja_layanan_lima_tahun)) {
            $insertKomitmenLayananLimaTahun = [
                'id_izin' => $req->id_izin,
                'id_map_listpersyaratan' => $req->id_komitmen_kinerja_layanan_lima_tahun,
                'filled_document' => json_encode($req->komitmen_kinerja_layanan_lima_tahun),
            ];
            $komitmenlayananlimatahun = DB::table('tb_trx_persyaratan_komitmen')
                                        ->where('id_map_listpersyaratan', '=', $req->id_komitmen_kinerja_layanan_lima_tahun)
                                        ->where('id_izin', $req->id_izin)->update($insertKomitmenLayananLimaTahun);
        }

        // // update rolloutplan
        // if (isset($req->rolloutplan)) {
        //     $insertRollOutPlan = [
        //         'rolloutplan' => json_encode($req->rolloutplan)
        //     ];

        //     $rolloutplan = DB::table('tb_trx_penyesuaian_komitmen')->where('id_izin', $req->id_izin)->update($insertRollOutPlan);
        // }

        // // update komitmen layanan 5 tahun
        // if (isset($req->komitmen_kinerja_layanan_lima_tahun)) {
        //     $insertKomitmenLayananLimaTahun = [
        //         'komitmen_kinerja_layanan_lima_tahun' => json_encode($req->komitmen_kinerja_layanan_lima_tahun),
        //     ];
        //     $komitmenlayananlimatahun = DB::table('tb_trx_penyesuaian_komitmen')->where('id_izin', $req->id_izin)->update($insertKomitmenLayananLimaTahun);
        // }

        return redirect('/')->with('success', 'Data Your files has been successfully submited');
    }

    public function offDay()
    {
        $date_reformat = new DateHelper();
        $offday = OffDay::all();
        $arr = [];
        foreach ($offday as $off) {
            array_push($arr, $off['off_day']);
        };
        return $arr;
    }
}
