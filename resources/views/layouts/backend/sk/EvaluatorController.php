<?php

namespace App\Http\Controllers\Admin;

use DB;
use PDF;
use Str;
use Auth;
use Config;
use Session;
use Redirect;
use Carbon\Carbon;
use App\Helpers\Osshub;
use App\Models\Admin\Nib;
use App\Models\Admin\Ulo;
use App\Helpers\LogHelper;
use App\Models\Admin\Izin;
use App\Models\Admin\User;
use App\Helpers\DateHelper;
use App\Helpers\IzinHelper;
use App\Helpers\EmailHelper;
use App\Models\Admin\Ulolog;
use App\Models\LogKodeAkses;
use App\Models\Admin\TrxKodeAkses_Additional;
use App\Models\TrxKodeAkses;
use Illuminate\Http\Request;
use App\Helpers\CommonHelper;
use App\Models\Admin\Izinlog;
use App\Models\Admin\Izinoss;
use App\Models\Admin\uloView;
use App\Models\TrxIzinPrinsip;
use App\Models\Admin\Disposisi;
use App\Models\Admin\Penomoran;
use App\Models\Admin\UserSurvey;
use App\Models\Admin\JobPosition;
use App\Models\Admin\Penyesuaian;
use App\Models\Admin\Disposisiulo;
use App\Models\Admin\Penomoranlog;
use App\Http\Controllers\Controller;
use App\Models\Admin\BlokNomor_List;
use App\Models\Admin\Penanggungjawab;
use App\Models\Admin\vw_kodeakses_adds;
use App\Models\Admin\Catatanevaluator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;


class EvaluatorController extends Controller
{
    //
    public function index()
    {
        $date_reformat = new DateHelper();

        $id_departemen_user = Session::get('id_departemen');
        if ($id_departemen_user == 1) {
            return Redirect::route('admin.evaluator.jasa');
        } else if ($id_departemen_user == 2) {
            return Redirect::route('admin.evaluator.jaringan');
        } else if ($id_departemen_user == 4) {
            return Redirect::route('admin.evaluator.ulo');
        } else if ($id_departemen_user == 5) {
            return Redirect::route('admin.evaluator.penomoran');
        } else {
            return Redirect::route('admin.evaluator.telsus');
        }
    }

    public function jasa(Request $request)
    {
        $date_reformat = new DateHelper();

        $id_user_session = Session::get('id_user');
        $id_departemen_user = Session::get('id_departemen');
        if ($id_departemen_user != 1) {
            return abort(404);
        }
        $limit_db = Config::get('app.admin.limit');
        $status_checklist = 901;

        $izin = Izin::select('vw_list_izin.*')
            ->join('tb_trx_disposisi_evaluator as d', 'd.id_izin', '=', 'vw_list_izin.id_izin')
            ->leftJoin('tb_trx_disposisi_evaluator_komitmen as k', 'k.id_izin', '=', 'vw_list_izin.id_izin')
            // ->where('vw_list_izin.status_checklist','=',$status_checklist)
            // ->orWhere('vw_list_izin.status_checklist','=', 44)
            // ->orWhere(function($query) {
            //     $query->where('vw_list_izin.status_checklist', 901)
            //             ->orWhere('vw_list_izin.status_checklist', 44);
            // })
            ->whereIn('vw_list_izin.status_checklist', ['901', '44'])
            ->where('d.id_disposisi_user', '=', $id_user_session)
            ->orWhere(function ($query) use ($id_user_session) {
                $query->where('vw_list_izin.status_penyesuaian', 20)
                    ->Where('k.id_disposisi_user', '=', $id_user_session);
            })
            ->take($limit_db);
        // dd($izin->toSql());
        $izin = $izin->where('vw_list_izin.id_master_izin', '=', $id_departemen_user)->distinct('vw_list_izin.id_izin')->orderBy('updated_at', 'desc');
        if ($izin->count() > 0) { //handle paginate error division by zero
            $izin = $izin->paginate($limit_db);
        } else {
            $izin = $izin->get();
        }

        //getcountiizin 
        // $countdisposisi = IzinHelper::countIzin($status_checklist, $id_departemen_user);
        $countdisposisi = $izin->count();
        // dd($countdisposisi);

        $paginate = $izin;
        // dd($izin);
        $izin = $izin->toArray();
        $jenis_izin = 'Izin Penyelenggaraan Jasa Telekomunikasi';

        return view('layouts.backend.evaluator.dashboard', ['date_reformat' => $date_reformat, 'izin' => $izin, 'paginate' => $paginate, 'countdisposisi' => $countdisposisi, 'jenis_izin' => $jenis_izin]);
    }

    public function jaringan(Request $request)
    {
        $date_reformat = new DateHelper();

        $id_departemen_user = Session::get('id_departemen');
        if ($id_departemen_user != 2) {
            return abort(404);
        }
        $id_user_session = Session::get('id_user');
        $limit_db = Config::get('app.admin.limit');
        $status_checklist = 901;

        $izin = Izin::select('vw_list_izin.*')
            ->join('tb_trx_disposisi_evaluator as d', 'd.id_izin', '=', 'vw_list_izin.id_izin')
            ->leftJoin('tb_trx_disposisi_evaluator_komitmen as k', 'k.id_izin', '=', 'vw_list_izin.id_izin')
            // ->where('vw_list_izin.status_checklist','=',$status_checklist)
            ->whereIn('vw_list_izin.status_checklist', [901, 44])
            ->where('d.id_disposisi_user', '=', $id_user_session)
            ->take($limit_db);
        $izin = $izin->where('vw_list_izin.id_master_izin', '=', $id_departemen_user)->distinct('vw_list_izin.id_izin')->orderBy('updated_at', 'desc');

        if ($izin->count() > 0) { //handle paginate error division by zero
            $izin = $izin->paginate($limit_db);
        } else {
            $izin = $izin->get();
        }

        //getcountiizin 
        // $countdisposisi = IzinHelper::countIzin($status_checklist, $id_departemen_user);
        $countdisposisi = $izin->count();
        $paginate = $izin;
        $izin = $izin->toArray();
        $jenis_izin = 'Izin Penyelenggaraan Jaringan Telekomunikasi';
        return view('layouts.backend.evaluator.dashboard', ['date_reformat' => $date_reformat, 'izin' => $izin, 'paginate' => $paginate, 'countdisposisi' => $countdisposisi, 'jenis_izin' => $jenis_izin]);
    }

    public function telsus(Request $request)
    {
        $date_reformat = new DateHelper();

        $id_departemen_user = Session::get('id_departemen');

        if ($id_departemen_user != 3) {
            return abort(404);
        }

        $id_user_session = Session::get('id_user');
        // dd($id_user_session);
        $limit_db = Config::get('app.admin.limit');
        $status_checklist = 901;

        $izin = Izin::select('*')
            ->join('tb_trx_disposisi_evaluator as d', 'd.id_izin', '=', 'vw_list_izin.id_izin')
            ->where('d.id_disposisi_user', '=', $id_user_session)
            ->whereIn('vw_list_izin.status_checklist', [901, 801, 8011, 701, 601, 44])
            ->where('vw_list_izin.id_master_izin_parent', '=', $id_departemen_user)
            ->take($limit_db);
        // $izin = $izin->where('id_master_izin_parent','=',$id_departemen_user)->distinct('vw_list_izin.id_izin');

        if ($izin->count() > 0) { //handle paginate error division by zero
            $izin = $izin->paginate($limit_db);
        } else {
            $izin = $izin->get();
        }

        //getcountiizin 
        // $countdisposisi = IzinHelper::countIzin($status_checklist, $id_departemen_user);
        $countdisposisi = $izin->count();
        $paginate = $izin;
        $izin = $izin->toArray();
        $jenis_izin = 'Izin Penyelenggaraan Telekomunikasi Khusus';
        return view('layouts.backend.evaluator.dashboard', ['date_reformat' => $date_reformat, 'izin' => $izin, 'paginate' => $paginate, 'countdisposisi' => $countdisposisi, 'jenis_izin' => $jenis_izin]);
    }

    public function evaluasi($id, Request $request)
    {
        // dd(Auth::user()->name);

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
            ->leftjoin('vw_izinprinsip_pathsk as c', 'c.id_izin_prinsip', '=', 'vw_list_izin.id_proyek')
            ->first();
        // dd($izin);
        if ($izin == null) {
            return abort(404);
        }
        $izin = $izin->toArray();
        $nib = $izin['nib'];
        $kd_izin = $izin['kd_izin'];
        // dd($izin);
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

        // dd($filled_persyaratan);

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
                    $map_izin[$key]->form_isian = $value2->filled_document;
                    $map_izin[$key]->nama_asli = $value2->nama_file_asli;
                    $map_izin[$key]->need_correction = $value2->need_correction;
                    $map_izin[$key]->correction_note = $value2->correction_note;
                }
            }
        }

        $map_izin_pre = array();
        // $filled_persyaratan_pre = array();

        // $mst_kode_izin_pre = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=', '059000010066')->first();
        // $id_mst_izinlayanan_pre = $mst_kode_izin_pre->id;

        // $map_izin_pre = $common->get_map_izin($id_mst_izinlayanan_pre);
        // $map_izin_pre = $common->get_map_izin_pre($izin['id_proyek']);
        // dd($map_izin_pre);
        // $filled_persyaratan_pre = DB::table('tb_trx_persyaratan')->select('*')->where('id_trx_izin', '=', $izin['id_proyek'])->get();
        // $filled_persyaratan_pre = $filled_persyaratan_pre->toArray();

        // dd($filled_persyaratan);

        // foreach ($map_izin_pre as $key => $value) {
        //     // echo $value->persyaratan;
        //     // echo "<br>=============<br>";
        //     $map_izin_pre[$key] = $value;
        //     foreach ($filled_persyaratan_pre as $key2 => $value2) {
        //         if ($value->id == $value2->id_map_listpersyaratan) {
        //             // echo $value->persyaratan;
        //             // echo "<br>=============<br>";
        //             // echo $value2->filled_document;
        //             // echo "<br>******************<br>";
        //             $map_izin_pre[$key]->form_isian = $value2->filled_document;
        //             $map_izin_pre[$key]->nama_asli = $value2->nama_file_asli;
        //             $map_izin_pre[$key]->need_correction = $value2->need_correction;
        //             $map_izin_pre[$key]->correction_note = $value2->correction_note;
        //         }
        //     }
        // }
        $map_izin_pre = DB::table('vw_pre_izin_telsus')->select('*')
            ->where('id_proyek', '=', $izin['id_proyek'])
            ->where('kd_izin', '!=', $izin['kd_izin'])
            // ->leftjoin('vw_izinprinsip_pathsk as c', 'c.id_izin_prinsip', '=',
            // 'vw_pre_izin_telsus.id_proyek')
            ->get();
        // dd($map_izin_pre);
        $html = array();
        // $html = view('users.edit', compact('user'))->render();

        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        $cities = DB::table('tb_mst_kabupaten')->select('id', 'name')->get();
        $triger = Session::get('id_mst_jobposition');
        // dd($triger);
        // die;

        // return view('layouts.backend.evaluator.evaluasi-persyaratan', ['date_reformat' => $date_reformat, 'id' => $id, 'cities' => $cities, 'izin' => $izin, 'detailnib' => $detailNib, 'penanggungjawab' => $penanggungjawab, 'map_izin' => $map_izin, 'filled_persyaratan' => $filled_persyaratan, 'map_izin_pre' => $map_izin_pre, 'filled_persyaratan_pre' => $filled_persyaratan_pre, 'triger' => $triger]);
        return view('layouts.backend.evaluator.evaluasi-persyaratan', ['date_reformat' => $date_reformat, 'id' => $id, 'cities' => $cities, 'izin' => $izin, 'detailnib' => $detailNib, 'penanggungjawab' => $penanggungjawab, 'map_izin' => $map_izin, 'filled_persyaratan' => $filled_persyaratan, 'map_izin_pre' => $map_izin_pre, 'triger' => $triger]);
    }

    public function evaluasiPost($id, Request $request)
    {
        // dd($request);
        $date_reformat = new DateHelper();

        $common = new CommonHelper();
        $email = new EmailHelper();
        $log = new LogHelper();
        $id_departemen_user = Session::get('id_departemen');
        $id_izin = $request['id_izin'];

        // dd($id_izin,$id);

        if ($id_izin != $id) {
            return Redirect::route('admin.evaluator');
        }


        $izin = Izin::select('*')
            ->where('id_izin', '=', $id_izin)
            // ->whereIn('status_checklist', [44, 801, 901])
            ->first();

        // dd($izin);  


        $status_checklist = $izin->status_checklist;


        if (empty($izin)) {
            return abort(404);
        }

        $izin = $izin->toArray();
        $evaluator = DB::table('tb_trx_disposisi_evaluator as a')
            ->join('tb_mst_user_bo as b', 'b.id', '=', 'a.id_disposisi_user')
            // ->where('b.is_accounttesting', '!=', 1)
            ->where('a.id_izin', $izin['id_izin'])
            ->first();
        // dd($evaluator);
        $nib = $izin['nib'];
        $nibs = Nib::where('nib', $nib)->first();
        $nibs = $nibs->toArray();
        $kd_izin = $izin['kd_izin'];

        $koreksi_all = 0;
        $insert = array();
        $data = $request->all();
        $id_koreksi = array();
        $catatan_koreksi = array();
        $array_filled = array();
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'is_koreksi_dokumen_') !== false) {
                $id_koreksi[] = str_replace('is_koreksi_dokumen_', '', $key);
            }

            if (strpos($key, 'catatan_dokumen_') !== false) {
                $catatan_koreksi[] = str_replace('catatan_dokumen_', '', $key);
            }
        }

        foreach ($catatan_koreksi as $key => $value) {
            $array_filled[$value]['id_trx_izin'] = $id_izin;
            $array_filled[$value]['id_pemenuhan_syarat'] = $value;
            $array_filled[$value]['catatan'] = $data['catatan_dokumen_' . $value];
            if (isset($data['is_koreksi_dokumen_' . $value]) && $data['is_koreksi_dokumen_' . $value] == 'on') {
                $array_filled[$value]['koreksi'] = 1;
                $koreksi_all = 1;
            } else {
                $array_filled[$value]['koreksi'] = 0;
            }
        }
        // dd($koreksi_all);

        $catatan_hasil_evaluasi = $request->get('catatan_hasil_evaluasi');

        //get subkoordinator
        $subkoordinator = DB::table('tb_mst_user_bo')->select('id', 'nama', 'email', 'id_mst_jobposition');
        // ->where('tb_mst_user_bo.is_accounttesting', '!=', 1);

        if ($id_departemen_user == 2) { //jika user jasa dan jaringan
            $subkoordinator = $subkoordinator->where('tb_mst_user_bo.id_mst_jobposition', '=', 2);
            // ->where('tb_mst_user_bo.is_accounttesting', '!=', 1); //jabatan koordinator jaringan
        } else if ($id_departemen_user == 1) {
            $subkoordinator = $subkoordinator->where('tb_mst_user_bo.id_mst_jobposition', '=', 5);
            // ->where('tb_mst_user_bo.is_accounttesting', '!=', 1); //jabatan evaluator jasa
        } else if ($id_departemen_user == 3) { //jika user telsus
            $subkoordinator = $subkoordinator->where('tb_mst_user_bo.id_mst_jobposition', '=', 8);
            // ->where('tb_mst_user_bo.is_accounttesting', '!=', 1); //jabatan evaluator Telsus
        }

        $subkoordinator = $subkoordinator->first();

        $jabatan = DB::table('tb_mst_jobposition')->where('id', $subkoordinator->id_mst_jobposition)->first();
        //end get subkoordinator

        //kondisional departemen
        $departemen = $common->getDepartemen($id_departemen_user);
        //end konsidisional departemen

        DB::beginTransaction();

        $Izinoss = Izinoss::where('id_izin', '=', $id)->first(); //set status checklist telah didisposisi
        // dd($Izinoss);


        // try {
        if (count($array_filled) > 0) {
            foreach ($array_filled as $key => $value) {
                $update = DB::table('tb_trx_persyaratan')->select('*')->where('id_map_listpersyaratan', '=', $value['id_pemenuhan_syarat'])->where('id_trx_izin', '=', $id)->where('is_active', '=', 1)->update([
                    'created_by' => Session::get('id_user'),
                    'need_correction' => $value['koreksi'],
                    'correction_note' => $value['catatan']
                ]);
            }
        }

        // $Izinoss = Izinoss::where('id_izin', '=', $id)->where('status_checklist', '=', $status_checklist)->first(); //set status checklist telah didisposisi
        $catatan = $catatan_hasil_evaluasi;
        //insert log
        $insertIzinLog = $log->createIzinLog($Izinoss, $catatan);

        if ($koreksi_all == 1) {
            if (substr($izin['id_izin'], 0, 3) != 'TKI') {
                $Izinoss->status_checklist = 43;
                $email_jenis1 = 'koreksi-pj';
            } else {
                // $Izinoss->status_checklist = 90;
                // $Izinoss->status_checklist = 99901;
                // $email_jenis1 = 'tolak-pj';
                if ($Izinoss->kd_izin == '059000010066') {
                    $Izinoss->status_checklist = 99901;
                    $email_jenis1 = 'tolak-pj-ip';
                } elseif ($Izinoss->kd_izin == '059000020066') {
                    $Izinoss->status_checklist = 43;
                    $email_jenis1 = 'koreksi-pj';
                } elseif ($Izinoss->kd_izin == '059000030066') {
                    $Izinoss->status_checklist = 99901;
                    $email_jenis1 = 'tolak-pj-ip';
                } elseif ($Izinoss->kd_izin == '059000040066') {
                    $Izinoss->status_checklist = 90;
                    $email_jenis1 = 'tolak-pj-ip';
                } else {
                    $Izinoss->status_checklist = 43;
                    $email_jenis1 = 'koreksi-pj';
                }
            }
        } else {
            if (substr($izin['id_izin'], 0, 3) == 'TKI') {
                if ($Izinoss->kd_izin == '059000030066') {
                    $Izinoss->status_checklist = 702;
                } elseif ($Izinoss->kd_izin == '059000010066') {
                    $Izinoss->status_checklist = 802;
                } elseif ($Izinoss->kd_izin == '059000020066') {
                    $Izinoss->status_checklist = 602;
                } elseif ($Izinoss->kd_izin == '059000040066') {
                    $Izinoss->status_checklist = 8021;
                } else {
                    $Izinoss->status_checklist = 802;
                }
            } else {
                $Izinoss->status_checklist = 902;
            }

            $email_jenis1 = 'evaluasi-evaluator-pj';
        }
        $Izinoss->updated_at = date('Y-m-d H:i:s');
        $Izinoss->save();


        //insert ke catatan
        $insert = DB::table('tb_evaluasi_catatan_evaluator')->insert(['id_izin' => $id, 'catatan_hasil_evaluasi' => $catatan_hasil_evaluasi, 'created_by' => Session::get('id_user'), 'is_active' => 1]);

        session()->flash('message', 'Telah Berhasil Mengirim Hasil Evaluasi');
        //penanggungjawab dan kirim email
        $penanggungjawab = array();
        $email_data = array();
        $email_data_subkoordinator = array();
        $penanggungjawab = $common->get_pj_nib($nib);

        $nama2 = $evaluator->nama;
        if ($email_jenis1 != 'tolak-pj-ip') {
        $kirim_email = $email->kirim_email($penanggungjawab, $email_jenis1, $izin, $departemen, $catatan_hasil_evaluasi,
        $nama2, $nibs, $koreksi_all, '', '', '', '');
        }
        // $kirim_email = $email->kirim_email($penanggungjawab, $email_jenis1, $izin, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all);
        //end penganggungjawab

        // if ($koreksi_all == 0) {
        //kirim email subkoordinator
        $user['email'] = isset($subkoordinator->email) ? $subkoordinator->email : '';
        $user['nama'] = $subkoordinator->nama;
        $nama2 = $evaluator->nama;
        $email_jenis = 'evaluasi-evaluator';
        $catatan_hasil_evaluasi = $catatan_hasil_evaluasi;
        // dd($user, $email_jenis, $izin, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, $jabatan);

        //end mengirim email ke evaluator
        $kirim_email2 = $email->kirim_email2($user, $email_jenis, $izin, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, $jabatan);
        // }

        // $izin_status = [
        //     "nib" => $nibs['nib'],
        //     "id_produk" => $Izinoss->id_produk,
        //     "id_proyek" => $Izinoss->id_proyek,
        //     "oss_id" => $Izinoss->oss_id,
        //     "id_izin" => $Izinoss->id_izin,
        //     "kd_izin" => $Izinoss->kd_izin,
        //     "kd_instansi" => '059',
        //     "kd_status" => '10',
        //     "tgl_status" => date('Y-m-d h:i:s'),
        //     "nip_status" => '198901012016011100',
        //     "nama_status" => 'Sheriff Woody S.IP Msc',
        //     "keterangan" => 'Update license status',
        //     "data_pnbp" => [
        //         "kd_akun" => '',
        //         "kd_penerimaan" => '',
        //         "kd_billing" => '',
        //         "tgl_billing" => '',
        //         "tgl_expire" => '',
        //         "nominal" => '',
        //         "url_dokumen" => ''
        //     ]
        // ];

        // $osshub = new Osshub();
        // $licenseStatus = $osshub->updateIzin($izin_status);

        DB::commit();
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     // throw ValidationException::withMessages(['message' => 'Gagal']);
        //     session()->flash('message', 'Evaluasi gagal di proses');
        //     return Redirect::route('admin.evaluator');
        // }

        return Redirect::route('admin.evaluator')->with('message', 'Evaluasi berhasil di proses');
    }

    public function ulo()
    {
        $date_reformat = new DateHelper();

        $id_jabatan = Session::get('id_jabatan');
        $id_departemen_user = Session::get('id_departemen');
        if (Session::get('id_mst_jobposition') != 12) {
            return abort(404);
        }
        $id_user_session = Session::get('id_user');
        $limit_db = Config::get('app.admin.limit');
        $status_ulo = 901;

        // dd($id_jabatan);
        $is_evaluator = 1;
        $ulo = array();
        $ulo = new Ulo();
        $ulo = $ulo->view_ulo($id_departemen_user, 'EMPTY', $id_jabatan, $is_evaluator, $id_user_session);

        if ($ulo->count() > 0) { //handle paginate error division by zero
            $ulo = $ulo->paginate($limit_db);
        } else {
            $ulo = $ulo->get();
        }

        $paginate = $ulo;
        $ulo = $ulo->toArray();
        $data = isset($ulo['data']) ? count($ulo['data']) : 0;
        $jenis_izin = 'Izin Penyelenggaraan Jaringan Telekomunikasi';
        // dd($ulo);
        return view('layouts.backend.evaluator.dashboard-ulo', ['date_reformat' => $date_reformat, 'ulo' => $ulo, 'paginate' => $paginate, 'jenis_izin' => $jenis_izin, 'data' => $data]);
    }

    public function evaluasiUlo($id_izin, $urut, Request $request)
    {
        $date_reformat = new DateHelper();
        $common = new CommonHelper;
        $id_departemen_user = Session::get('id_departemen');
        $limit_db = Config::get('app.admin.limit');
        $status_checklist = 901;
        $id_jabatan = Session::get('id_jabatan');

        // $ulos = array();
        $ulo = new Ulo();
        $ulo = $ulo->view_ulo($id_departemen_user, $urut, $id_jabatan);
        $izin = Izin::select('*')->where('id_izin', '=', $id_izin)
            ->leftjoin('vw_izinprinsip_pathsk as c', 'c.id_izin_prinsip', '=', 'vw_list_izin.id_proyek')
            // ->where('status_checklist', '=', $status_checklist)
            ->first();
        // dd($ulo);
        if ($izin == null) {
            return abort(404);
        }
        $izin = $izin->toArray();

        if ($ulo == null) {
            return abort(404);
        }
        // $ulo = $ulo::where('tb_trx_ulo.id','=',$urut);
        $ulo = $ulo->toArray();
        // dd($ulo, $izin);
        $nib = $ulo['nib'];
        $kd_izin = $ulo['kd_izin'];

        $penanggungjawab = array();
        $detailNib = $common->get_detail_nib($nib);
        $penanggungjawab = $common->get_pj_nib($nib);

        $map_izin = array();
        $filled_persyaratan = array();


        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=', $kd_izin)->first();
        $id_mst_izinlayanan = $mst_kode_izin->id;

        $filled_persyaratan = DB::table('tb_trx_persyaratan')->select('*')->where('id_trx_izin', '=', $id_izin)->get();

        if ($filled_persyaratan->count() > 0) {
            $filled_persyaratan = $filled_persyaratan->toArray();
        }
        // dd($filled_persyaratan);
        $map_izin = $common->get_map_izin($id_mst_izinlayanan);

        foreach ($map_izin as $key => $value) {
            // echo $value->persyaratan;
            // echo "<br>=============<br>";
            $map_izin[$key] = $value;
            foreach ($filled_persyaratan as $key2 => $value2) {
                if ($value->id == $value2->id_map_listpersyaratan) {
                    $map_izin[$key]->form_isian = $value2->filled_document;
                    $map_izin[$key]->nama_asli = $value2->nama_file_asli;
                    $map_izin[$key]->need_correction = 1;
                }
            }
        }

        $triger = Session::get('id_mst_jobposition');
        $html = array();
        // dd($ulo);

        return view('layouts.backend.evaluator.evaluasi-ulo', ['date_reformat' => $date_reformat, 'id' => $id_izin, 'izin' => $izin, 'ulo' => $ulo, 'detailnib' => $detailNib, 'penanggungjawab' => $penanggungjawab, 'map_izin' => $map_izin, 'triger' => $triger]);
    }
    public function tanggalEvaluasiUlo($id_izin, $urut, Request $request)
    {
        $date_reformat = new DateHelper();

        $common = new CommonHelper;
        $id_departemen_user = Session::get('id_departemen');
        $limit_db = Config::get('app.admin.limit');
        $status_checklist = 901;
        $id_jabatan = Session::get('id_jabatan');
        $ulo = new Ulo();
        $ulo = $ulo->view_ulo($id_departemen_user, $urut, $id_jabatan);
        $izin = Izin::select('*')->where('id_izin', '=', $id_izin)
            // ->where('status_checklist', '=', $status_checklist)
            ->first();
        // dd($izin);
        if ($izin == null) {
            return abort(404);
        }
        $izin = $izin->toArray();

        if ($ulo == null) {
            return abort(404);
        }
        $ulo = $ulo->toArray();
        $nib = $ulo['nib'];
        $kd_izin = $ulo['kd_izin'];

        $penanggungjawab = array();
        $detailNib = $common->get_detail_nib($nib);
        $penanggungjawab = $common->get_pj_nib($nib);

        $map_izin = array();
        $filled_persyaratan = array();


        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=', $kd_izin)->first();
        $id_mst_izinlayanan = $mst_kode_izin->id;

        $filled_persyaratan = DB::table('tb_trx_persyaratan')->select('*')->where('id_trx_izin', '=', $id_izin)->get();
        if ($filled_persyaratan->count() > 0) {
            $filled_persyaratan = $filled_persyaratan->toArray();
        }

        $map_izin = $common->get_map_izin($id_mst_izinlayanan);
        // dd($map_izin);

        foreach ($map_izin as $key => $value) {
            // echo $value->persyaratan;
            // echo "<br>=============<br>";
            $map_izin[$key] = $value;
            foreach ($filled_persyaratan as $key2 => $value2) {
                if ($value->id == $value2->id_map_listpersyaratan) {
                    $map_izin[$key]->form_isian = $value2->filled_document;
                    $map_izin[$key]->nama_asli = $value2->nama_file_asli;
                }
            }
        }
        $triger = Session::get('id_mst_jobposition');


        $html = array();

        return view('layouts.backend.evaluator.tanggal-evaluasi-ulo', ['date_reformat' => $date_reformat, 'id' => $id_izin, 'izin' => $izin, 'ulo' => $ulo, 'detailnib' => $detailNib, 'penanggungjawab' => $penanggungjawab, 'map_izin' => $map_izin, 'triger' => $triger]);
    }
    public function saveHasilEvaluasiUlo($id, $urut, Request $request)
    {

        $date_reformat = new DateHelper();

        // dd($request->all());
        $common = new CommonHelper();
        $id_jabatan = Session::get('id_jabatan');
        $id_departemen_user = Session::get('id_departemen');
        $id_izin = $request['id_izin'];

        if ($id_izin != $id) {
            return Redirect::route('admin.evaluator-ulo');
        }

        $ulo = new Ulo();
        $ulo = $ulo->view_ulo($id_departemen_user, $urut, $id_jabatan);
        // dd($ulo);

        if (empty($ulo)) {
            return abort(404);
        }

        $ulo = $ulo->toArray();
        $nib = $ulo['nib'];
        $nibs = Nib::where('nib', $nib)->first();
        $nibs = $nibs->toArray();
        $kd_izin = $ulo['kd_izin'];
        $Izinoss = Izinoss::where('id_izin', '=', $id)->first(); //set status checklist telah didisposisi
        $insert = array();
        $data = $request->all();
        $id_koreksi = array();
        $catatan_koreksi = array();
        $catatan_hasil_evaluasi = $request->get('catatan_hasil_evaluasi');

        //get subkoordinator
        $subkoordinator = $common->get_subkoordinator_first($id_departemen_user);
        //end get subkoordinator

        //kondisional departemen
        $departemen = $common->getDepartemen($id_departemen_user);
        //end konsidisional departemen

        function tgl_indo($tanggal)
        {
            $pecahkan = explode('-', $tanggal);
            return $pecahkan[2] . '-' . $pecahkan[1] . '-' . $pecahkan[0];
        }

        DB::beginTransaction();

        // try {
        $data = $request->all();
        //
        $id_ulo = $ulo['id_ulo'];
        $uloSave = Ulo::select('*')->where('id', '=', $id_ulo)->first();
        // dd($uloSave);
        if (isset($uloSave['nomor_sklo'])) {
            $nomorsklo_int = $uloSave['nomor_sklo'];
            $nomorsklo_fixed = $uloSave['nomor_sklo_fixed'];
        } else {

            $nomorsklo = DB::table('latest_sklono')->select('*')->first();
            // dd($nomorsklo);
            $nomorsklo_int = $nomorsklo->sklono;
            $nomorsklo_fixed = $nomorsklo->sklono_fixed;

            if ($uloSave['jenis_izin'] == 'JASA') {
                $init = 'JASA';
                // $nomorsklo = DB::table('latest_sklono')->select('*')->first();
                // $nomorsklo_fixed = $init . '-' . $nomorsklo_fixed;
                $nomorsklo_fixed = $nomorsklo_fixed;
            } elseif ($uloSave['jenis_izin'] == 'JARINGAN') {
                $init = 'JAR';
                // $nomorsklo = DB::table('latest_sklono')->select('*')->first();
                // $nomorsklo_fixed = $init . '-' . $nomorsklo_fixed;
                $nomorsklo_fixed = $nomorsklo_fixed;
            } else {
                $init = 'TELSUS';
                // $nomorsklo = DB::table('latest_sklono')->select('*')->first();
                // $nomorsklo_fixed = $init . '-' . $nomorsklo_fixed;
                $nomorsklo_fixed = $nomorsklo_fixed;
            }
        }
        if (isset($uloSave['status_hasil_evaluasi'])) {
            if ($uloSave['status_hasil_evaluasi'] == 1) {

                $uloSave->status_hasil_evaluasi = null;
                $uloSave->save();
                DB::commit();
                return Redirect::back();
            } else {

                if ((isset($data['is_koreksi_surat_permohonan']) && $data['is_koreksi_surat_permohonan'] == 'on')
                    || isset($data['is_koreksi_surat_tugas']) && $data['is_koreksi_surat_tugas'] == 'on'
                    || isset($data['is_koreksi_surat_tugas']) && $data['is_koreksi_surat_tugas'] == 'on'
                ) {
                    $koreksi_all = 1;
                }

                $catatan = $catatan_hasil_evaluasi;

                if (isset($data['is_koreksi_surat_permohonan']) && $data['is_koreksi_surat_permohonan']) {
                    $uloSave->is_koreksi_surat_permohonan = 1;
                }

                if (isset($data['is_koreksi_surat_tugas']) && $data['is_koreksi_surat_tugas']) {
                    $uloSave->is_koreksi_surat_tugas = 1;
                }

                if (isset($data['is_koreksi_hasil_pengujian']) && $data['is_koreksi_hasil_pengujian']) {
                    $uloSave->is_koreksi_hasil_pengujian = 1;
                }

                // FILE
                if ($file1 = $request->file('uploadSuratPerintahTugas')) {
                    $date_reformat = new DateHelper();

                    $filename1 = "surat-perintah-tugas" . time() . '.' . $file1->extension();
                    $path1 = $file1->storeAs('public/file_ulo', $filename1);
                    $name1 = $file1->getClientOriginalName();
                    $path1 = str_replace('public/', 'storage/', $path1);
                } else {
                    $path1 = $ulo['upload_surat_perintah_tugas'];
                    $name1 = $ulo['upload_surat_perintah_tugas_asli'];
                }
                if ($file2 = $request->file('UploadDokumenHasilEvaluasiPelaksanaanUlo')) {
                    $date_reformat = new DateHelper();

                    $filename2 = "dokumen-hasil-evaluasi-pelaksanaan-ulo" . time() . '.' . $file2->extension();
                    $path2 = $file2->storeAs('public/file_ulo', $filename2);
                    $name2 = $file2->getClientOriginalName();
                    $path2 = str_replace('public/', 'storage/', $path2);
                } else {
                    $path2 = $ulo['upload_dokumen_hasil_evaluasi_pelaksanaan_ulo'];
                    $name2 = $ulo['upload_dokumen_hasil_evaluasi_pelaksanaan_ulo_asli'];
                }
                // END FILE

                // $uloSave->catatan_surat_permohonan = isset($data['catatan_surat_permohonan']) ? $data['catatan_surat_permohonan'] :'';
                // $uloSave->catatan_surat_tugas = isset($data['catatan_surat_tugas']) ? $data['catatan_surat_tugas'] :'';
                // $uloSave->catatan_hasil_pengujian = isset($data['catatan_hasil_pengujian']) ? $data['catatan_hasil_pengujian'] :'';
                $uloSave->catatan_evaluasi = $data['catatan_hasil_evaluasi'];
                $uloSave->status_laik = NULL;
                if (isset($data['MediaTransmisiYangDigunakan'])) {
                    $uloSave->media_transmisi_yang_digunakan = isset($data['MediaTransmisiYangDigunakan']) ? $data['MediaTransmisiYangDigunakan'] : '';
                }
                if (isset($data['alamatPusatLayananPelangan'])) {
                    $uloSave->alamat_pusat_layanan_pelangan = isset($data['alamatPusatLayananPelangan']) ? $data['alamatPusatLayananPelangan'] : '';
                }
                $uloSave->alamat_pelaksanaan_ulo = $data['AlamatPelaksanaanUlo'];
                $uloSave->tanggal_evaluasi_pelaksanaan_ulo = tgl_indo($data['TanggalEvaluasiPelaksanaanUlo']);
                $uloSave->no_surat_perintah_tugas = $data['NoSuratPerintahTugas'];
                $uloSave->tanggal_surat_perintah_tugas = tgl_indo($data['TanggalSuratPerintahTugas']);
                $uloSave->upload_surat_perintah_tugas = $path1;
                $uloSave->upload_surat_perintah_tugas_asli = $name1;
                $uloSave->dasar_surat_permohonan_ulo = $data['DasarSuratPermohonanUlo'];
                $uloSave->upload_dokumen_hasil_evaluasi_pelaksanaan_ulo = $path2;
                $uloSave->upload_dokumen_hasil_evaluasi_pelaksanaan_ulo_asli = $name2;
                $uloSave->nomor_sklo = $nomorsklo_int;
                $uloSave->nomor_sklo_fixed = $nomorsklo_fixed;
                $uloSave->status_hasil_evaluasi = $data['status_hasil_evaluasi'];

                $uloSave->save();

                // $insertUloLog = Ulolog::create($uloToLog); 

            }
        } else {

            if ((isset($data['is_koreksi_surat_permohonan']) && $data['is_koreksi_surat_permohonan'] == 'on')
                || isset($data['is_koreksi_surat_tugas']) && $data['is_koreksi_surat_tugas'] == 'on'
                || isset($data['is_koreksi_surat_tugas']) && $data['is_koreksi_surat_tugas'] == 'on'
            ) {
                $koreksi_all = 1;
            }

            $catatan = $catatan_hasil_evaluasi;

            if (isset($data['is_koreksi_surat_permohonan']) && $data['is_koreksi_surat_permohonan']) {
                $uloSave->is_koreksi_surat_permohonan = 1;
            }

            if (isset($data['is_koreksi_surat_tugas']) && $data['is_koreksi_surat_tugas']) {
                $uloSave->is_koreksi_surat_tugas = 1;
            }

            if (isset($data['is_koreksi_hasil_pengujian']) && $data['is_koreksi_hasil_pengujian']) {
                $uloSave->is_koreksi_hasil_pengujian = 1;
            }

            // FILE
            if ($file1 = $request->file('uploadSuratPerintahTugas')) {
                $date_reformat = new DateHelper();

                $filename1 = "surat-perintah-tugas" . time() . '.' . $file1->extension();
                $path1 = $file1->storeAs('public/file_ulo', $filename1);
                $name1 = $file1->getClientOriginalName();
                $path1 = str_replace('public/', 'storage/', $path1);
            } else {
                $path1 = $ulo['upload_surat_perintah_tugas'];
                $name1 = $ulo['upload_surat_perintah_tugas_asli'];
            }
            if ($file2 = $request->file('UploadDokumenHasilEvaluasiPelaksanaanUlo')) {
                $date_reformat = new DateHelper();

                $filename2 = "dokumen-hasil-evaluasi-pelaksanaan-ulo" . time() . '.' . $file2->extension();
                $path2 = $file2->storeAs('public/file_ulo', $filename2);
                $name2 = $file2->getClientOriginalName();
                $path2 = str_replace('public/', 'storage/', $path2);
            } else {
                $path2 = $ulo['upload_dokumen_hasil_evaluasi_pelaksanaan_ulo'];
                $name2 = $ulo['upload_dokumen_hasil_evaluasi_pelaksanaan_ulo_asli'];
            }
            // END FILE

            // $uloSave->catatan_surat_permohonan = isset($data['catatan_surat_permohonan']) ? $data['catatan_surat_permohonan'] :'';
            // $uloSave->catatan_surat_tugas = isset($data['catatan_surat_tugas']) ? $data['catatan_surat_tugas'] :'';
            // $uloSave->catatan_hasil_pengujian = isset($data['catatan_hasil_pengujian']) ? $data['catatan_hasil_pengujian'] :'';
            // $uloSave->catatan_evaluasi = $data['catatan_hasil_evaluasi'];
            // $uloSave->status_laik = $data['status_laik'];
            if (isset($data['MediaTransmisiYangDigunakan'])) {
                $uloSave->media_transmisi_yang_digunakan = isset($data['MediaTransmisiYangDigunakan']) ? $data['MediaTransmisiYangDigunakan'] : '';
            }
            if (isset($data['alamatPusatLayananPelangan'])) {
                $uloSave->alamat_pusat_layanan_pelangan = isset($data['alamatPusatLayananPelangan']) ? $data['alamatPusatLayananPelangan'] : '';
            }
            $uloSave->alamat_pelaksanaan_ulo = $data['AlamatPelaksanaanUlo'];
            $uloSave->tanggal_evaluasi_pelaksanaan_ulo = tgl_indo($data['TanggalEvaluasiPelaksanaanUlo']);
            $uloSave->no_surat_perintah_tugas = $data['NoSuratPerintahTugas'];
            $uloSave->tanggal_surat_perintah_tugas = tgl_indo($data['TanggalSuratPerintahTugas']);
            $uloSave->upload_surat_perintah_tugas = $path1;
            $uloSave->upload_surat_perintah_tugas_asli = $name1;
            $uloSave->dasar_surat_permohonan_ulo = $data['DasarSuratPermohonanUlo'];
            $uloSave->upload_dokumen_hasil_evaluasi_pelaksanaan_ulo = $path2;
            $uloSave->upload_dokumen_hasil_evaluasi_pelaksanaan_ulo_asli = $name2;
            $uloSave->nomor_sklo = $nomorsklo_int;
            $uloSave->nomor_sklo_fixed = $nomorsklo_fixed;
            $uloSave->status_hasil_evaluasi = 1;
            // dd($uloSave);
            $uloSave->save();

            
            if (substr($id, 0, 3) == 'TKI') {
            $ip_idproyek = DB::table('tb_trx_ulo')
                ->join('tb_oss_trx_izin as b', 'b.id_izin', '=', 'tb_trx_ulo.id_izin')
                ->select('b.id_proyek')
                ->where('tb_trx_ulo.id_izin', '=', $id)
                ->first();
            $ip_idproyek_iterasi = DB::table('tb_oss_trx_izin')
                ->join('tb_trx_izin_prinsip as b', 'b.id_trx_izin', '=', 'tb_oss_trx_izin.id_izin')
                ->select('b.id_trx_izin')
                ->where('tb_oss_trx_izin.id_proyek', '=', $ip_idproyek->id_proyek)
                ->where('b.iterasi_perpanjangan', '=', 1)
                ->first();
            if (isset($ip_idproyek_iterasi->id_trx_izin)) {
                $id_trxizinip = $ip_idproyek_iterasi->id_trx_izin;
            } else {
                $id_trxizinip = $ip_idproyek->id_proyek;
            }

            $nokomitmen = DB::table('latest_izinprinsipno_0302')->select('izinprisipno')->first();
            $latest_nokomitmen = $nokomitmen->izinprisipno;

            $IzinPrinsip = TrxIzinPrinsip::where('id_trx_izin', '=', $id_trxizinip)->first();
            // dd($nomorsklo_fixed);
            if (isset($IzinPrinsip->no_izin_penyelenggaraan)) {
                $latest_nokomitmen = $IzinPrinsip->no_izin_penyelenggaraan;
                $IzinPrinsip->no_izin_ulo = $nomorsklo_fixed;
                $IzinPrinsip->save();
            } else {
                // $IzinPrinsip->updated_by = Auth::user()->name;
                $IzinPrinsip->no_izin_ulo = $nomorsklo_fixed;
                $IzinPrinsip->no_izin_penyelenggaraan = $latest_nokomitmen;
                $IzinPrinsip->updated_date = date('Y-m-d H:i:s');
                $IzinPrinsip->save();
            }
            }

            // $insertUloLog = Ulolog::create($uloToLog); 

        }
        // dd($uloSave);


        // $izin_status = [
        //     "nib" => $nibs['nib'],
        //     "id_produk" => $Izinoss->id_produk,
        //     "id_proyek" => $Izinoss->id_proyek,
        //     "oss_id" => $Izinoss->oss_id,
        //     "id_izin" => $Izinoss->id_izin,
        //     "kd_izin" => $Izinoss->kd_izin,
        //     "kd_instansi" => '059',
        //     "kd_status" => '10',
        //     "tgl_status" => date('Y-m-d h:i:s'),
        //     "nip_status" => '198901012016011100',
        //     "nama_status" => 'Sheriff Woody S.IP Msc',
        //     "keterangan" => 'Update license status',
        //     "data_pnbp" => [
        //         "kd_akun" => '',
        //         "kd_penerimaan" => '',
        //         "kd_billing" => '',
        //         "tgl_billing" => '',
        //         "tgl_expire" => '',
        //         "nominal" => '',
        //         "url_dokumen" => ''
        //     ]
        // ];

        // $osshub = new Osshub();
        // $licenseStatus = $osshub->updateIzin($izin_status);

        DB::commit();
        // 
        session()->flash('message', 'Berhasil Menyimpan Hasil Evaluasi');
        return Redirect::back();
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     session()->flash('message', 'Gagal Menyimpan Hasil Evaluasi');
        //     return Redirect::back();
        // }
    }

    public function evaluasiUloPost($id, $urut, Request $request)
    {
        // dd($request);
        $date_reformat = new DateHelper();
        $common = new CommonHelper();
        $email = new EmailHelper();
        $log = new LogHelper();
        $id_jabatan = Session::get('id_jabatan');
        $id_departemen_user = Session::get('id_departemen');
        $id_izin = $request['id_izin'];

        if ($id_izin != $id) {
            return Redirect::route('admin.evaluator-ulo');
        }

        // $status_ulo = 901;

        $ulo = new Ulo();
        $ulo = $ulo->view_ulo($id_departemen_user, $urut, $id_jabatan);
        $ulo = $ulo->toArray();
        $evaluator = DB::table('tb_trx_disposisi_evaluator_ulo as a')
            ->join('tb_mst_user_bo as b', 'b.id', '=', 'a.id_disposisi_user')
            // ->where('b.is_accounttesting', '!=', 1)
            ->where('a.id_izin', $ulo['id_izin'])
            ->first();

        // dd($ulo['status_laik']);

        if (empty($ulo)) {
            return abort(404);
        }

        $nib = $ulo['nib'];
        $nibs = Nib::where('nib', $nib)->first();
        $nibs = $nibs->toArray();
        $kd_izin = $ulo['kd_izin'];
        $status_badan_hukum = $ulo['nama_master_izin'];
        // dd($ulo['nama_master_izin']);
        $koreksi_all = 0;
        $insert = array();
        $data = $request->all();

        $id_koreksi = array();
        $catatan_koreksi = array();
        // $catatan_hasil_evaluasi = $request->get('catatan_hasil_evaluasi');

        //get subkoordinator
        $subkoordinator = $common->get_subkoordinator_first($id_departemen_user);
        //end get subkoordinator

        //kondisional departemen
        $departemen = $common->getDepartemen($id_departemen_user);
        //end konsidisional departemen

        DB::beginTransaction();
        $data = $request->all();
        // dd($data);
        $id_ulo = $ulo['id_ulo'];
        $uloToLog = Ulo::select('*')->where('id', '=', $id_ulo)->first();
        $uloSave = $uloToLog;
        // dd($uloSave);

        // if ((isset($data['is_koreksi_surat_permohonan']) && $data['is_koreksi_surat_permohonan'] == 'on')
        //     || isset($data['is_koreksi_surat_tugas']) && $data['is_koreksi_surat_tugas'] == 'on'
        //     || isset($data['is_koreksi_surat_tugas']) && $data['is_koreksi_surat_tugas'] == 'on'
        // ) {
        //     $koreksi_all = 1;
        // }
        if(isset($request->status_laik)){
            if ($request->status_laik == 1) {
                $uloSave->status_ulo = 902;
            } elseif ($request->status_laik == 0) {
                $uloSave->status_ulo = 90;
                $uloSave->nomor_sklo = NULL;
                $uloSave->nomor_sklo_fixed = NULL;
                $uloSave->is_active = 0;
            }
        }


        // $catatan = $catatan_hasil_evaluasi;
        //insert log
        // $insertUloLog = $log->createUloLog($uloToLog, $catatan, $status_ulo);

        // if (isset($data['is_koreksi_surat_permohonan']) && $data['is_koreksi_surat_permohonan']) {
        //     $uloSave->is_koreksi_surat_permohonan = 1;
        // }

        // if (isset($data['is_koreksi_surat_tugas']) && $data['is_koreksi_surat_tugas']) {
        //     $uloSave->is_koreksi_surat_tugas = 1;
        // }

        // if (isset($data['is_koreksi_hasil_pengujian']) && $data['is_koreksi_hasil_pengujian']) {
        //     $uloSave->is_koreksi_hasil_pengujian = 1;
        // }

        // FILE
        // if ($file1 = $request->file('uploadSuratPerintahTugas')) {
        //     $date_reformat = new DateHelper();

        //     $filename1 = "surat-perintah-tugas" . time() . '.' . $file1->extension();
        //     $path1 = $file1->storeAs('public/file_ulo', $filename1);
        //     $name1 = $file1->getClientOriginalName();
        //     $path1 = str_replace('public/', 'storage/', $path1);
        // } else {
        //     $path1 = $ulo['upload_surat_perintah_tugas'];
        //     $name1 = $ulo['upload_surat_perintah_tugas_asli'];
        // }
        // if ($file2 = $request->file('UploadDokumenHasilEvaluasiPelaksanaanUlo')) {
        //     $date_reformat = new DateHelper();

        //     $filename2 = "dokumen-hasil-evaluasi-pelaksanaan-ulo" . time() . '.' . $file2->extension();
        //     $path2 = $file2->storeAs('public/file_ulo', $filename2);
        //     $name2 = $file2->getClientOriginalName();
        //     $path2 = str_replace('public/', 'storage/', $path2);
        // } else {
        //     $path2 = $ulo['upload_dokumen_hasil_evaluasi_pelaksanaan_ulo'];
        //     $name2 = $ulo['upload_dokumen_hasil_evaluasi_pelaksanaan_ulo_asli'];
        // }

        function tgl_indo($tanggal)
        {
            $pecahkan = explode('-', $tanggal);
            return $pecahkan[2] . '-' . $pecahkan[1] . '-' . $pecahkan[0];
        }
        // END FILE
        // dd($uloSave);
        if ($request->file('dok_surat_permohonan_ulo_asli') != null) {
            $path_dok_surat_permohonan_ulo_asli = '';
            // $id_konfigurasi_sistem = $data['id_konfigurasi_sistem'];
            if ($dok_surat_permohonan_ulo_asli = $request->file('dok_surat_permohonan_ulo_asli')) {
                $filename_dok_surat_permohonan_ulo_asli = "KOMINFO_dok_surat_permohonan_ulo_asli" . time() . '.' . $dok_surat_permohonan_ulo_asli->extension();
                $path_dok_surat_permohonan_ulo_asli = $dok_surat_permohonan_ulo_asli->storeAs('public/file_ulo', $filename_dok_surat_permohonan_ulo_asli);
                if ($path_dok_surat_permohonan_ulo_asli == '' || $path_dok_surat_permohonan_ulo_asli == NULL) {
                    $path_dok_surat_permohonan_ulo_asli = $data['path_dok_surat_permohonan_ulo_asli'];
                    // dd($path_konfigurasi_sistem);
                }
                // dd($path_konfigurasi_sistem);
                $name_dok_surat_permohonan_ulo_asli = $dok_surat_permohonan_ulo_asli->getClientOriginalName();
                $path_dok_surat_permohonan_ulo_asli = str_replace('public/', 'storage/', $path_dok_surat_permohonan_ulo_asli);
            }
            $uloSave->surat_permohonan_ulo =  $path_dok_surat_permohonan_ulo_asli;
            $uloSave->surat_permohonan_ulo_asli =  $filename_dok_surat_permohonan_ulo_asli;
        }

        // $uloSave->catatan_surat_permohonan = isset($data['catatan_surat_permohonan']) ? $data['catatan_surat_permohonan'] : '';
        // $uloSave->catatan_surat_tugas = isset($data['catatan_surat_tugas']) ? $data['catatan_surat_tugas'] : '';

        // $uloSave->catatan_hasil_pengujian = isset($data['catatan_hasil_pengujian']) ? $data['catatan_hasil_pengujian'] : '';
        // $uloSave->catatan_evaluasi = isset($uloSave['catatan_evaluasi']) ? $uloSave['catatan_evaluasi'] : $data['catatan_hasil_evaluasi'];
        // $uloSave->updated_date = date('Y-m-d H:i:s');
        // $uloSave->status_laik = isset($uloSave['status_laik']) ? $uloSave['status_laik'] : $data['status_laik'];
        // if (isset($data['MediaTransmisiYangDigunakan'])) {
        //     $uloSave->media_transmisi_yang_digunakan = isset($data['MediaTransmisiYangDigunakan']) ? $data['MediaTransmisiYangDigunakan'] : '';
        // }
        // if (isset($data['alamatPusatLayananPelangan'])) {
        //     $uloSave->alamat_pusat_layanan_pelangan = isset($data['alamatPusatLayananPelangan']) ? $data['alamatPusatLayananPelangan'] : '';
        // }
        // $uloSave->alamat_pelaksanaan_ulo = isset($uloSave['alamat_pelaksanaan_ulo']) ? $uloSave['alamat_pelaksanaan_ulo'] : $data['AlamatPelaksanaanUlo'];
        // $uloSave->tanggal_evaluasi_pelaksanaan_ulo =  isset($uloSave['tanggal_evaluasi_pelaksanaan_ulo']) ? $uloSave['tanggal_evaluasi_pelaksanaan_ulo'] : tgl_indo($data['TanggalEvaluasiPelaksanaanUlo']);
        // $uloSave->no_surat_perintah_tugas =  isset($uloSave['no_surat_perintah_tugas']) ? $uloSave['no_surat_perintah_tugas'] : $data['NoSuratPerintahTugas'];
        // $uloSave->tanggal_surat_perintah_tugas = isset($uloSave['tanggal_surat_perintah_tugas']) ? $uloSave['tanggal_surat_perintah_tugas'] : tgl_indo($data['TanggalSuratPerintahTugas']);
        // $uloSave->upload_surat_perintah_tugas = $path1;
        // $uloSave->upload_surat_perintah_tugas_asli = $name1;
        // $uloSave->dasar_surat_permohonan_ulo = isset($uloSave['dasar_surat_permohonan_ulo']) ? $uloSave['dasar_surat_permohonan_ulo'] : $data['DasarSuratPermohonanUlo'];
        // $uloSave->upload_dokumen_hasil_evaluasi_pelaksanaan_ulo = $path2;
        // $uloSave->upload_dokumen_hasil_evaluasi_pelaksanaan_ulo_asli = $name2;

        // dd($uloSave);
        $uloSave->save();

        //update persyaratan

        // $id_bukti_perangkat = $data['id_bukti_perangkat'];

        // if (isset($data['daftar_perangkat'])) {
        //     $path_sertifikat_alat = '';
        //     $path_foto_perangkat = '';
        //     $path_foto_sn_perangkat = '';
        //     $id_daftar_perangkat = $data['id_daftar_perangkat'];
        //     // if (count($request->file('daftar_perangkat'))) {
        //         foreach($request->file('daftar_perangkat') as $key => $file) {
        //             $updateDaftarPerangkat[$key]['lokasi_perangkat'] = $request->daftar_perangkat[$key]['lokasi_perangkat'];
        //             $updateDaftarPerangkat[$key]['jenis_perangkat'] = $request->daftar_perangkat[$key]['jenis_perangkat'];
        //             $updateDaftarPerangkat[$key]['merk_perangkat'] = $request->daftar_perangkat[$key]['merk_perangkat'];
        //             $updateDaftarPerangkat[$key]['sn_perangkat'] = $request->daftar_perangkat[$key]['sn_perangkat'];
        //             $updateDaftarPerangkat[$key]['tipe_perangkat'] = $request->daftar_perangkat[$key]['tipe_perangkat'];
        //             $updateDaftarPerangkat[$key]['buatan_perangkat'] = $request->daftar_perangkat[$key]['buatan_perangkat'];
        //             $updateDaftarPerangkat[$key]['sertifikat_perangkat'] = $request->daftar_perangkat[$key]['sertifikat_perangkat'];

        //             if($request->daftar_perangkat[$key]['sertifikat_alat']!=null){
        //                 $data_file = $request->daftar_perangkat[$key]['sertifikasi_alat'];
        //                 $filename_sertifikat_alat = "KOMINFO_sertifikat_alat".time().'.'.$sertifikat_alat->extension();
        //                 $path_sertifikat_alat = $sertifikat_alat->storeAs('public/file_ulo', $filename_sertifikat_alat);
        //                 $name_sertifikat_alat = $sertifikat_alat->getClientOriginalName();
        //                 $path_sertifikat_alat = str_replace('public/', 'storage/', $path_sertifikat_alat);
        //                 $updateDaftarPerangkat[$key]['sertifikasi_alat'] = $path_sertifikat_alat;
        //             }
        //             if($request->daftar_perangkat[$key]['foto_perangkat']!=null){
        //                 $data_file_foto = $request->daftar_perangkat[$key]['foto_perangkat'];
        //                 $filename_foto_perangkat = "KOMINFO_foto_perangkat".time().'.'.$foto_perangkat->extension();
        //                 $path_foto_perangkat = $foto_perangkat->storeAs('public/file_ulo', $filename_foto_perangkat);
        //                 $name_foto_perangkat = $foto_perangkat->getClientOriginalName();
        //                 $path_foto_perangkat = str_replace('public/', 'storage/', $path_foto_perangkat);
        //                 $updateDaftarPerangkat[$key]['foto_perangkat'] = $path_foto_perangkat;
        //             }
        //             if($request->daftar_perangkat[$key]['foto_sn_perangkat']!=null){
        //                 $data_file_foto_sn = $request->daftar_perangkat[$key]['foto_sn_perangkat'];
        //                 $filename_foto_sn_perangkat = "KOMINFO_foto_sn_perangkat".time().'.'.$foto_sn_perangkat->extension();
        //                 $path_foto_sn_perangkat = $foto_sn_perangkat->storeAs('public/file_ulo', $filename_foto_sn_perangkat);
        //                 $name_foto_sn_perangkat = $foto_sn_perangkat->getClientOriginalName();
        //                 $path_foto_sn_perangkat = str_replace('public/', 'storage/', $path_foto_sn_perangkat);
        //                 $updateDaftarPerangkat[$key]['foto_sn_perangkat'] = $path_foto_sn_perangkat;
        //             }
        //         }
        //         dd(json_encode($updateDaftarPerangkat));
        //         $update_daftar_perangkat = DB::table('tb_trx_persyaratan')->select('*')->where('id_map_listpersyaratan', '=', $id_daftar_perangkat)->where('id_trx_izin', '=', $id)->update([
        //             'filled_document' => json_encode($updateDaftarPerangkat)
        //         ]);
        //     // }

        // }
        // dd($data['daftar_perangkat_telsus']);
        // if (isset($data['daftar_perangkat_telsus'])) {
        //     // dd($data['daftar_perangkat_telsus']);
        //     if (count($data['daftar_perangkat_telsus'])) {

        //         foreach ($request->daftar_perangkat_telsus as $key => $file) {
        //             $updateDaftarPerangkatTelsus[$key]['lokasi_perangkat'] =
        //                 $request->daftar_perangkat_telsus[$key]['lokasi_perangkat'];
        //             $updateDaftarPerangkatTelsus[$key]['jenis_perangkat'] =
        //                 $request->daftar_perangkat_telsus[$key]['jenis_perangkat'];
        //             $updateDaftarPerangkatTelsus[$key]['merk_perangkat'] =
        //                 $request->daftar_perangkat_telsus[$key]['merk_perangkat'];
        //             $updateDaftarPerangkatTelsus[$key]['tipe_perangkat'] =
        //                 $request->daftar_perangkat_telsus[$key]['tipe_perangkat'];
        //             $updateDaftarPerangkatTelsus[$key]['sertifikat_perangkat'] =
        //                 $request->daftar_perangkat_telsus[$key]['sertifikat_perangkat'];
        //             // $updateDaftarPerangkat[$key]['buatan_perangkat'] =
        //             $request->daftar_perangkat_telsus[$key]['buatan_perangkat'];
        //             // $updateDaftarPerangkat[$key]['sn_perangkat'] = $request->daftar_perangkat_telsus[$key]['sn_perangkat'];

        //             if (isset($request->prv_sertifikasi_alat[$key])) {
        //                 if(isset($request->daftar_perangkat_telsus[$key]['sertifikasi_alat'])){
        //                     if ($request->hasFile('daftar_perangkat_telsus'[$key]['sertifikasi_alat'])) {
        //                         $data_file = $file['sertifikasi_alat'];
        //                         $filename = "KOMINFO-cert" . time() . $key . '.' . $data_file->extension();
        //                         $path = $data_file->storeAs('public/file_syarat', $filename);
        //                         $path = str_replace('public/', 'storage/', $path);
        //                         $updateDaftarPerangkatTelsus[$key]['sertifikasi_alat'] = $path;
        //                     } else {
        //                         $updateDaftarPerangkatTelsus[$key]['sertifikasi_alat'] = $request->prv_sertifikasi_alat[$key];
        //                     }
        //                 }else {
        //                     $updateDaftarPerangkatTelsus[$key]['sertifikasi_alat'] = $request->prv_sertifikasi_alat[$key];
        //                 }

        //             }

        //             if (isset($request->prv_foto_perangkat[$key])) {
        //                 if (isset($request->daftar_perangkat_telsus[$key]['foto_perangkat'])) {
        //                     if ($request->hasFile('daftar_perangkat_telsus'[$key]['foto_perangkat'])) {
        //                         $data_file_foto = $file['foto_perangkat'];
        //                         $filename_foto = "KOMINFO-foto" . time() . $key . '.' . $data_file_foto->extension();
        //                         $path_foto = $data_file_foto->storeAs('public/file_syarat', $filename_foto);
        //                         $path_foto = str_replace('public/', 'storage/', $path_foto);
        //                         $updateDaftarPerangkatTelsus[$key]['foto_perangkat'] = $path_foto;
        //                     } else {
        //                         $updateDaftarPerangkatTelsus[$key]['foto_perangkat'] = $request->prv_foto_perangkat[$key];
        //                     }
        //                 }else {
        //                     $updateDaftarPerangkatTelsus[$key]['foto_perangkat'] = $request->prv_foto_perangkat[$key];
        //                 }

        //             }



        //             // $data_file_foto_sn = $file['foto_sn_perangkat'];
        //             // $filename_foto_sn = "KOMINFO-foto-sn" . time() . $key . '.' . $data_file_foto_sn->extension();
        //             // $path_foto_sn = $data_file_foto_sn->storeAs('public/file_syarat', $filename_foto_sn);
        //             // $path_foto_sn = str_replace('public/', 'storage/', $path_foto_sn);
        //             // $updateDaftarPerangkat[$key]['foto_sn_perangkat'] = $path_foto_sn;
        //         }
        //     }
        //     // dd($data);
        //     $saveDaftarPerangkatTelsus = [
        //         'id_trx_izin' => $data['id_izin'],
        //         'id_map_listpersyaratan' => $data['id_daftar_perangkat'],
        //         'filled_document' => json_encode($updateDaftarPerangkatTelsus),
        //         'nama_file_asli' => null,
        //         'need_correction' => null,
        //         'correction_note' => '',
        //         'updated_by' => Session::get('nama'),
        //         'is_active' => '1'
        //     ];
        //     // dd($updateDaftarPerangkatTelsus);
        //     $daftar_perangkat_telsus = DB::table('tb_trx_persyaratan')
        //         ->select('id', 'filled_document')->where('id_map_listpersyaratan', '=', $data['id_daftar_perangkat'])
        //         ->where('id_trx_izin', '=', $data['id_izin'])
        //         ->update($saveDaftarPerangkatTelsus);
        //     // dd(json_encode($updateDaftarPerangkatTelsus));

        // }
        // dd(count($data['daftar_perangkat']));
        if (isset($data['daftar_perangkat'])) {
            // dd($request->file('daftar_perangkat'));
            if (count($data['daftar_perangkat'])) {

                foreach ($request->daftar_perangkat as $key => $file) {
                    // dd($request->daftar_perangkat[$key]['lokasi_perangkat']);
                    $updateDaftarPerangkat[$key]['lokasi_perangkat'] = $request->daftar_perangkat[$key]['lokasi_perangkat'];
                    $updateDaftarPerangkat[$key]['jenis_perangkat'] = $request->daftar_perangkat[$key]['jenis_perangkat'];
                    $updateDaftarPerangkat[$key]['merk_perangkat'] = $request->daftar_perangkat[$key]['merk_perangkat'];
                    $updateDaftarPerangkat[$key]['sn_perangkat'] = $request->daftar_perangkat[$key]['sn_perangkat'];
                    $updateDaftarPerangkat[$key]['tipe_perangkat'] = $request->daftar_perangkat[$key]['tipe_perangkat'];
                    $updateDaftarPerangkat[$key]['buatan_perangkat'] = $request->daftar_perangkat[$key]['buatan_perangkat'];
                    if (isset($request->daftar_perangkat[$key]['sertifikat_perangkat'])) {
                        $updateDaftarPerangkat[$key]['sertifikat_perangkat'] =
                            $request->daftar_perangkat[$key]['sertifikat_perangkat'];
                    }

                    if (isset($request->prv_sertifikasi_alat[$key])) {
                        // if ($request->hasFile('daftar_perangkat'[$key]['sertifikasi_alat'])) {
                        if (isset($request->daftar_perangkat[$key]['sertifikasi_alat'])) {
                            $data_file = $file['sertifikasi_alat'];
                            $filename = "KOMINFO-cert" . time() . $key . '.' . $data_file->extension();
                            $path = $data_file->storeAs('public/file_syarat', $filename);
                            $path = str_replace('public/', 'storage/', $path);
                            $updateDaftarPerangkat[$key]['sertifikasi_alat'] = $path;
                        } else {
                            $updateDaftarPerangkat[$key]['sertifikasi_alat'] = $request->prv_sertifikasi_alat[$key];
                        }
                    } else {
                        if (isset($request->daftar_perangkat[$key]['sertifikasi_alat'])) {
                            $data_file = $file['sertifikasi_alat'];
                            $filename = "KOMINFO-cert" . time() . $key . '.' . $data_file->extension();
                            $path = $data_file->storeAs('public/file_syarat', $filename);
                            $path = str_replace('public/', 'storage/', $path);
                            $updateDaftarPerangkat[$key]['sertifikasi_alat'] = $path;
                        }
                    }

                    if (isset($request->prv_foto_perangkat[$key])) {
                        // if ($request->hasFile('daftar_perangkat'[$key]['foto_perangkat'])) {
                        if (isset($request->daftar_perangkat[$key]['foto_perangkat'])) {
                            $data_file_foto = $file['foto_perangkat'];
                            $filename_foto = "KOMINFO-foto" . time() . $key . '.' . $data_file_foto->extension();
                            $path_foto = $data_file_foto->storeAs('public/file_syarat', $filename_foto);
                            $path_foto = str_replace('public/', 'storage/', $path_foto);
                            $updateDaftarPerangkat[$key]['foto_perangkat'] = $path_foto;
                        } else {
                            $updateDaftarPerangkat[$key]['foto_perangkat'] = $request->prv_foto_perangkat[$key];
                        }
                    } else {
                        if (isset($request->daftar_perangkat[$key]['foto_perangkat'])) {
                            $data_file_foto = $file['foto_perangkat'];
                            $filename_foto = "KOMINFO-foto" . time() . $key . '.' . $data_file_foto->extension();
                            $path_foto = $data_file_foto->storeAs('public/file_syarat', $filename_foto);
                            $path_foto = str_replace('public/', 'storage/', $path_foto);
                            $updateDaftarPerangkat[$key]['foto_perangkat'] = $path_foto;
                        }
                    }
                    if (isset($request->prv_foto_sn_perangkat[$key])) {
                        // if ($request->hasFile('daftar_perangkat'[$key]['foto_sn_perangkat'])) {
                        if (isset($request->daftar_perangkat[$key]['foto_sn_perangkat'])) {
                            $data_file_foto_sn = $file['foto_sn_perangkat'];
                            $filename_foto_sn = "KOMINFO-foto-sn" . time() . $key . '.' .
                                $data_file_foto_sn->extension();
                            $path_foto_sn = $data_file_foto_sn->storeAs('public/file_syarat', $filename_foto_sn);
                            $path_foto_sn = str_replace('public/', 'storage/', $path_foto_sn);
                            $updateDaftarPerangkat[$key]['foto_sn_perangkat'] = $path_foto_sn;
                        } else {
                            $updateDaftarPerangkat[$key]['foto_sn_perangkat'] = $request->prv_foto_sn_perangkat[$key];
                        }
                    } else {
                        if (isset($request->daftar_perangkat[$key]['foto_sn_perangkat'])) {
                            $data_file_foto_sn = $file['foto_sn_perangkat'];
                            $filename_foto_sn = "KOMINFO-foto-sn" . time() . $key . '.' .
                                $data_file_foto_sn->extension();
                            $path_foto_sn = $data_file_foto_sn->storeAs('public/file_syarat', $filename_foto_sn);
                            $path_foto_sn = str_replace('public/', 'storage/', $path_foto_sn);
                            $updateDaftarPerangkat[$key]['foto_sn_perangkat'] = $path_foto_sn;
                        }
                    }
                }
            }
            // dd(Session::get('nama'));
            $saveDaftarPerangkat = [
                'id_trx_izin' => $data['id_izin'],
                'id_map_listpersyaratan' => $data['id_daftar_perangkat'],
                'filled_document' => json_encode($updateDaftarPerangkat),
                'nama_file_asli' => null,
                'need_correction' => null,
                'correction_note' => '',
                'updated_by' => Session::get('nama'),
                'is_active' => '1'
            ];
            // dd($saveDaftarPerangkat, $request->id_maplist_daftar_perangkat);
            $daftar_perangkat = DB::table('tb_trx_persyaratan')
                ->select('id', 'filled_document')->where(
                    'id_map_listpersyaratan',
                    '=',
                    $data['id_daftar_perangkat']
                )
                ->where('id_trx_izin', '=', $data['id_izin'])
                ->update($saveDaftarPerangkat);
            // dd($data);

        }
        // dd($data['rencanausaha']);
        if (isset($data['rencanausaha'])) {

            $updateRencanaUsaha = [
                'id_trx_izin' => $data['id_izin'],
                'id_map_listpersyaratan' => $data['id_maplist_rencanausaha'],
                'filled_document' => json_encode($request->rencanausaha),
                'nama_file_asli' => null,
                'need_correction' => null,
                'correction_note' => '',
                'updated_by' => Session::get('nama'),
                'is_active' => '1'
            ];
            // dd($updateRencanaUsaha);
            $rencana_usaha = DB::table('tb_trx_persyaratan')
                ->select('id', 'filled_document')->where(
                    'id_map_listpersyaratan',
                    '=',
                    $request->id_maplist_rencanausaha
                )
                ->where('id_trx_izin', '=', $data['id_izin'])
                ->update($updateRencanaUsaha);
            // dd($data);

        }

        // dd('ewat');
        if ($request->file('konfigurasi_sistem') != null) {
            $path_konfigurasi_sistem = '';
            $id_konfigurasi_sistem = $data['id_konfigurasi_sistem'];
            if ($konfigurasi_sistem = $request->file('konfigurasi_sistem')) {
                $filename_konfigurasi_sistem = "KOMINFO_konfigurasi_sistem" . time() . '.' . $konfigurasi_sistem->extension();
                $path_konfigurasi_sistem = $konfigurasi_sistem->storeAs('public/file_ulo', $filename_konfigurasi_sistem);
                if ($path_konfigurasi_sistem == '' || $path_konfigurasi_sistem == NULL) {
                    $path_konfigurasi_sistem = $data['path_konfigurasi_sistem'];
                    // dd($path_konfigurasi_sistem);
                }
                // dd($path_konfigurasi_sistem);
                $name_konfigurasi_sistem = $konfigurasi_sistem->getClientOriginalName();
                $path_konfigurasi_sistem = str_replace('public/', 'storage/', $path_konfigurasi_sistem);
            }
            $update_konfigurasi_sistem = DB::table('tb_trx_persyaratan')->select('*')->where('id_map_listpersyaratan', '=', $id_konfigurasi_sistem)->where('id_trx_izin', '=', $id)->update([
                'filled_document' => $path_konfigurasi_sistem
            ]);
        }

        if ($request->file('bukti_perangkat') != null) {
            $id_bukti_perangkat = $data['id_bukti_perangkat'];
            $path_bukti_perangkat = '';
            if ($bukti_perangkat = $request->file('bukti_perangkat')) {
                $filename_bukti_perangkat = "KOMINFO_bukti_perangkat" . time() . '.' . $bukti_perangkat->extension();
                $path_bukti_perangkat = $bukti_perangkat->storeAs('public/file_ulo', $filename_bukti_perangkat);
                if ($path_bukti_perangkat == '' || $path_bukti_perangkat == NULL) {
                    $path_bukti_perangkat = $data['path_bukti_perangkat'];
                    // dd($path_bukti_perangkat);
                }
                $name_bukti_perangkat = $bukti_perangkat->getClientOriginalName();
                $path_bukti_perangkat = str_replace('public/', 'storage/', $path_bukti_perangkat);
            }
            $update_bukti_perangkat = DB::table('tb_trx_persyaratan')->select('*')->where('id_map_listpersyaratan', '=', $id_bukti_perangkat)->where('id_trx_izin', '=', $id)->update([
                'filled_document' => $path_bukti_perangkat
            ]);
        }
        if ($request->file('dok_layanan_prapurna_jual') != null) {
            $id_dok_layanan_prapurna_jual = $data['id_dok_layanan_prapurna_jual'];
            $path_dok_layanan_prapurna_jual = '';
            if ($dok_layanan_prapurna_jual = $request->file('dok_layanan_prapurna_jual')) {
                $filename_dok_layanan_prapurna_jual = "KOMINFO_dok_layanan_prapurna_jual" . time() . '.' . $dok_layanan_prapurna_jual->extension();
                $path_dok_layanan_prapurna_jual = $dok_layanan_prapurna_jual->storeAs('public/file_ulo', $filename_dok_layanan_prapurna_jual);
                if ($path_dok_layanan_prapurna_jual == '' || $path_dok_layanan_prapurna_jual == NULL) {
                    $path_dok_layanan_prapurna_jual = $data['path_dok_layanan_prapurna_jual'];
                    // dd($path_bukti_perangkat);
                }
                $name_dok_layanan_prapurna_jual = $dok_layanan_prapurna_jual->getClientOriginalName();
                $path_dok_layanan_prapurna_jual = str_replace('public/', 'storage/', $path_dok_layanan_prapurna_jual);
            }
            $update_bukti_perangkat = DB::table('tb_trx_persyaratan')->select('*')->where('id_map_listpersyaratan', '=', $id_dok_layanan_prapurna_jual)->where('id_trx_izin', '=', $id)->update([
                'filled_document' => $path_dok_layanan_prapurna_jual, 'nama_file_asli' => $filename_dok_layanan_prapurna_jual
            ]);
        }
        if ($request->file('dok_peta_jaringan') != null) {
            $id_dok_peta_jaringan = $data['id_dok_peta_jaringan'];
            $path_dok_peta_jaringan = '';
            if ($dok_peta_jaringan = $request->file('dok_peta_jaringan')) {
                $filename_dok_peta_jaringan = "KOMINFO_dok_peta_jaringan" . time() . '.' . $dok_peta_jaringan->extension();
                $path_dok_peta_jaringan = $dok_peta_jaringan->storeAs('public/file_ulo', $filename_dok_peta_jaringan);
                if ($path_dok_peta_jaringan == '' || $path_dok_peta_jaringan == NULL) {
                    $path_dok_peta_jaringan = $data['path_dok_peta_jaringan'];
                    // dd($path_bukti_perangkat);
                }
                $name_dok_peta_jaringan = $dok_peta_jaringan->getClientOriginalName();
                $path_dok_peta_jaringan = str_replace('public/', 'storage/', $path_dok_peta_jaringan);
            }
            $update_bukti_perangkat = DB::table('tb_trx_persyaratan')->select('*')->where('id_map_listpersyaratan', '=', $id_dok_peta_jaringan)->where('id_trx_izin', '=', $id)->update([
                'filled_document' => $path_dok_peta_jaringan, 'nama_file_asli' => $filename_dok_peta_jaringan
            ]);
        }



        // if ($status_badan_hukum=='TELSUS') {
        //     $data['daftar_perangkat_telsus'][0]['sertifikasi_alat'] = $path_sertifikat_alat;
        // } else {
        //     $data['daftar_perangkat'][0]['sertifikasi_alat'] = $path_sertifikat_alat;
        //     $data['daftar_perangkat'][0]['foto_sn_perangkat'] = $path_foto_sn_perangkat;
        // }


        // if($path_bukti_perangkat != ''){
        //     $data['bukti_perangkat'][0]['sertifikasi_alat'] = $path_bukti_perangkat;
        // }
        // if($path_konfigurasi_sistem != ''){
        //     $data['konfigurasi_sistem'][0]['sertifikasi_alat'] = $path_konfigurasi_sistem;
        // }
        // if ($status_badan_hukum=='TELSUS') {
        //     $daftar_perangkat_save = json_encode($data['daftar_perangkat_telsus']);

        //     //update konfigurasi teknis
        //     $update_daftar_perangkat = DB::table('tb_trx_persyaratan')->select('*')->where('id_map_listpersyaratan', '=', $id_daftar_perangkat)->where('id_trx_izin', '=', $id)->update([
        //     'filled_document' => $daftar_perangkat_save]);
        // } else {
        //     $daftar_perangkat_save = json_encode($data['daftar_perangkat']);

        //     //update konfigurasi teknis
        //     $update_daftar_perangkat = DB::table('tb_trx_persyaratan')->select('*')->where('id_map_listpersyaratan', '=', $id_daftar_perangkat)->where('id_trx_izin', '=', $id)->update([
        //     'filled_document' => $daftar_perangkat_save
        //     ]);
        // }


        //end update persyaratan


        // $insertUloLog = Ulolog::create($uloToLog);

        //insert survey
        // $code = bin2hex(random_bytes(20));

        // UserSurvey::create([
        //     'id_izin' => $id,
        //     'code' => $code,
        //     'jenis_perizinan' => 1,
        //     'is_active' => 0,
        //     'created_by' => Session::get('id_user'),
        // ]);

        DB::commit();
        session()->flash('message', 'Berhasil Memperbaharui Dokumen Persyaratan');
        return Redirect::back();
        // session()->flash('message', 'Berhasil Mengirim Evaluasi ke Subkoordinator');
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     throw ValidationException::withMessages(['message' => 'Gagal']);
        // }

        return Redirect::route('admin.evaluator.ulo');
    }

    public function kirimemail($id, $urut, Request $request)
    {
        // dd($id, $urut);
        $date_reformat = new DateHelper();
        $common = new CommonHelper();
        $email = new EmailHelper();
        $log = new LogHelper();
        $id_jabatan = Session::get('id_jabatan');
        $id_departemen_user = Session::get('id_departemen');
        $id_izin = $request['id_izin'];
        // dd($request, $id_izin,$id);
        if ($id_izin != $id) {
            return Redirect::route('admin.evaluator-ulo');
        }
        $catatan_hasil_evaluasi = $request->catatan_evaluasi;
        $status_ulo = 901;

        $ulo = new Ulo();
        $ulo = $ulo->view_ulo($id_departemen_user, $urut, $id_jabatan);
        $ulo = $ulo->toArray();
        // $catatan = ->status_laik;
        $Izinoss = Izinoss::where('id_izin', '=', $id)->first(); //set status checklist telah didisposisi
        
        // dd($Izinoss);
        if ($Izinoss == null) {
        return abort(404);
        }
        $izin = $Izinoss->toArray();
        $insertIzinLog = $log->createIzinLog($Izinoss, $catatan_hasil_evaluasi);
        // dd($ulo);
        $evaluator = DB::table('tb_trx_disposisi_evaluator_ulo as a')
            ->join('tb_mst_user_bo as b', 'b.id', '=', 'a.id_disposisi_user')
            // ->where('b.is_accounttesting', '!=', 1)
            ->where('a.id_izin', $ulo['id_izin'])
            ->first();
        $nama2 = $evaluator->nama;

        // dd($evaluator);

        if (empty($ulo)) {
            return abort(404);
        }

        $nib = $ulo['nib'];
        $nibs = Nib::where('nib', $nib)->first();
        $nibs = $nibs->toArray();
        $kd_izin = $ulo['kd_izin'];
        $status_badan_hukum = $ulo['nama_master_izin'];
        // dd($ulo['nama_master_izin']);
        $koreksi_all = 0;
        $insert = array();
        // $data = $request->all();

        $id_koreksi = array();
        $catatan_koreksi = array();
        $catatan_hasil_evaluasi = $request->catatan_evaluasi;

        //get subkoordinator
        $subkoordinator = $common->get_subkoordinator_first($id_departemen_user);
        //end get subkoordinator

        //kondisional departemen
        $departemen = $common->getDepartemen($id_departemen_user);
        //end konsidisional departemen

        DB::beginTransaction();
        // try{
        $data = $request->all();
        // if (!isset($data['status_laik'])){
        //     session()->flash('message', 'Gagal Menyimpan Hasil Evaluasi. Harap Memilih Hasil Evaluasi');
        //     return Redirect::back();
        // }
        // dd($request->all());

        $id_ulo = $ulo['id_ulo'];
        $uloToLog = Ulo::select('*')->where('id', '=', $id_ulo)->first();
        $uloSave = $uloToLog;
        // dd($uloSave);

        if ((isset($data['is_koreksi_surat_permohonan']) && $data['is_koreksi_surat_permohonan'] == 'on')
            || isset($data['is_koreksi_surat_tugas']) && $data['is_koreksi_surat_tugas'] == 'on'
            || isset($data['is_koreksi_surat_tugas']) && $data['is_koreksi_surat_tugas'] == 'on'
        ) {
            $koreksi_all = 1;
        }

        if ($request->status_laik == 1) {
            if (substr($uloSave['id_izin'], 0, 3) != 'TKI') {
            $uloSave->status_ulo = 902;
            $uloSave->status_laik = 1;
            $uloSave->is_active = 1;
            $Izinoss->status_checklist = 902;
            $Izinoss->updated_at = date('Y-m-d H:i:s');
            $Izinoss->save();
            } else {
                $uloSave->status_ulo = 9021;
                $uloSave->is_active = 1;
                $uloSave->status_laik = 1;
                $Izinoss->status_checklist = 9021;
                $Izinoss->updated_at = date('Y-m-d H:i:s');
                $Izinoss->save();
            }
        } elseif ($request->status_laik == 0) {
            $uloSave->status_ulo = 90;
            $Izinoss->status_checklist = 90;
            $Izinoss->updated_at = date('Y-m-d H:i:s');
            $Izinoss->save();
            $uloSave->nomor_sklo = NULL;
            $uloSave->nomor_sklo_fixed = NULL;
            $uloSave->status_laik = 0;
            $uloSave->is_active = 0;
            // $uloSave->is_active = 0;
        }


        $catatan = $catatan_hasil_evaluasi;
        //insert log
        $insertUloLog = $log->createUloLog($uloToLog, $catatan, $status_ulo);
        
        function tgl_indo($tanggal)
        {
            $pecahkan = explode('-', $tanggal);
            return $pecahkan[2] . '-' . $pecahkan[1] . '-' . $pecahkan[0];
        }
        // END FILE
        // dd($uloSave);
        // $uloSave->status_laik = isset($uloSave['status_laik']) ? $uloSave['status_laik'] : $data['status_laik'];
        // $uloSave->status_laik = $uloSave['status_laik'];
        $uloSave->catatan_evaluasi = $catatan_hasil_evaluasi;
        $uloSave->updated_date = date('Y-m-d H:i:s');
        $uloSave->save();

        DB::commit();

        $datenow = Carbon::now();
        $date_format = new DateHelper();
        $date = $date_format->dateday_lang_reformat_long($datenow);
        $jabatanulo = DB::table('tb_mst_user_bo')->select('id', 'nama', 'email', 'id_mst_jobposition')
            ->where('tb_mst_user_bo.id_mst_jobposition', '=', 11)
            // ->where('tb_mst_user_bo.is_accounttesting', '!=', 1)
            ->first();
        $jabatan = DB::table('tb_mst_jobposition')->where('id', $jabatanulo->id_mst_jobposition)->first();

        //penanggungjawab dan kirim email
        $email_data = array();
        $email_data_subkoordinator = array();
        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);

        $subkoorulo = DB::table('tb_mst_user_bo')->select('id', 'nama', 'email', 'id_mst_jobposition')
            ->where('tb_mst_user_bo.id_mst_jobposition', '=', 11)
            // ->where('tb_mst_user_bo.is_accounttesting', '!=', 1)
            ->first();
        $jabatan = DB::table('tb_mst_jobposition')->where('id', $subkoorulo->id_mst_jobposition)->first();
        //penanggungjawab dan kirim email
        $email_data = array();
        $email_data_koordinator = array();
        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        // dd($ulo['status_laik'] );
        if ($request->status_laik== 1) {
            $email_jenis1 = 'evaluasi-evaluator-pj';
        } elseif ($request->status_laik== 0) {
            $email_jenis1 = 'tolak-pj';
        }


        $email_jenis1 =  $email_jenis1;
        // $nama2 = '';
        $kirim_email = $email->kirim_email($penanggungjawab, $email_jenis1, $ulo, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, '', '', '', '');

        //kirim email subkoordinator
        $user['email'] = isset($subkoordinator->email) ? $subkoordinator->email : '';
        $user['nama'] = isset($subkoordinator->nama) ? $subkoordinator->nama : '';
        $email_jenis = 'evaluasi-evaluator';
        $catatan_hasil_evaluasi = $catatan_hasil_evaluasi;

        //end mengirim email ke evaluator
        if ($request->status_laik == 1) {
            // dd($user, $email_jenis, $ulo, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, $jabatan);
            $kirim_email2 = $email->kirim_email2($user, $email_jenis, $ulo, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, $jabatan);
        }


        // session()->flash('message', 'Berhasil Mengirim Evaluasi ke Subkoordinator');
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     throw ValidationException::withMessages(['message' => 'Gagal Mengirim Evaluasi ke Subkoordinator']);
        // }

        return Redirect::route('admin.evaluator.ulo');
    }

    public function tglEvaluasiUloPost($id, $urut, Request $request)
    {
        $date_reformat = new DateHelper();
        $id_izin = $request->id_izin;
        $data_user = Izinoss::where('id_izin', '=', $id_izin)->join('users', 'users.oss_id', '=', 'tb_oss_trx_izin.oss_id')->first();



        $email = $data_user->email;
        // dd($request->all());
        $common = new CommonHelper();
        $email = new EmailHelper();

        $id_jabatan = Session::get('id_jabatan');
        $id_departemen_user = Session::get('id_departemen');
        $ulo = new Ulo();
        $ulo = $ulo->view_ulo($id_departemen_user, $urut, $id_jabatan);
        // dd($ulo);

        $log = new LogHelper();
        $tgl_before = $ulo['tgl_pelaksanaan_ulo'];
        // dd($request->TanggalEvaluasiPelaksanaanUlo);
        $tgl = $request->TanggalEvaluasiPelaksanaanUlo;
        $uloToLog = Ulo::where('id_izin', '=', $id_izin)->first();
        $insertUloLog = $log->createUloLog($uloToLog, "perubahan Tanggal", $uloToLog->status_ulo);
        $update = Ulo::where('id_izin', '=', $id_izin)->update(['tgl_pengajuan_ulo' => date("Y-m-d", strtotime($tgl))]);
        if ($update) {
            $email_data = array();
            $email_data['id_izin'] = $id_izin;
            $email_data['tgl_pelaksanaan_ulo'] = $tgl;
            // dd($ulo);
            $email->kirim_email_perubahan_tgl($id_izin, $email_data, $ulo, $tgl_before);
        }
        session()->flash('message', 'Berhasil Mengirim Perubahan Tanggal Pelaksanaan Uji Laik Operasi');
        return Redirect::route('admin.evaluator.ulo');
    }

    public function evaluasiUloPostTolak($id, $urut, Request $request)
    {
        $date_reformat = new DateHelper();


        // dd($request);
        $common = new CommonHelper();
        $id_jabatan = Session::get('id_jabatan');
        $id_departemen_user = Session::get('id_departemen');
        $id_izin = $request['id_izin'];

        if ($id_izin != $id) {
            return Redirect::route('admin.evaluator-ulo');
        }

        $status_ulo = 901;

        $ulo = new Ulo();
        $ulo = $ulo->view_ulo($id_departemen_user, $urut, $id_jabatan);

        if (empty($ulo)) {
            return abort(404);
        }

        $ulo = $ulo->toArray();
        $nib = $ulo['nib'];
        $kd_izin = $ulo['kd_izin'];

        $koreksi_all = 0;
        $insert = array();
        $data = $request->all();
        $id_koreksi = array();
        $catatan_koreksi = array();


        $catatan_hasil_evaluasi = $request->get('catatan_hasil_evaluasi');

        //get subkoordinator
        $subkoordinator = $common->get_subkoordinator_first($id_departemen_user);
        //end get subkoordinator

        //kondisional departemen
        $departemen = $common->getDepartemen($id_departemen_user);
        //end konsidisional departemen

        DB::beginTransaction();

        // try {
        $data = $request->all();
        //
        $id_ulo = $ulo['id'];
        $uloToLog = Ulo::select('*')->where('id', '=', $id_ulo)->first();
        $uloSave = $uloToLog;

        if (!empty($uloToLog)) {
            $uloToLog = $uloToLog->toArray();
        } else {
            $uloToLog = array();
        }

        unset($uloToLog['created_date']);
        unset($uloToLog['updated_date']);
        unset($uloToLog['id']);
        unset($uloToLog['status_ulo']);


        $uloToLog['created_by'] = Session::get('id_user');
        $uloToLog['created_name'] = Session::get('nama');



        if ((isset($data['is_koreksi_surat_permohonan']) && $data['is_koreksi_surat_permohonan'] == 'on')
            || isset($data['is_koreksi_surat_tugas']) && $data['is_koreksi_surat_tugas'] == 'on'
            || isset($data['is_koreksi_surat_tugas']) && $data['is_koreksi_surat_tugas'] == 'on'
        ) {
            $koreksi_all = 1;
        }

        $uloToLog['status_ulo'] = 90;
        $uloSave->status_ulo = 90;

        if (isset($data['is_koreksi_surat_permohonan']) && $data['is_koreksi_surat_permohonan']) {
            $uloSave->is_koreksi_surat_permohonan = 1;
        }

        if (isset($data['is_koreksi_surat_tugas']) && $data['is_koreksi_surat_tugas']) {
            $uloSave->is_koreksi_surat_tugas = 1;
        }

        if (isset($data['is_koreksi_hasil_pengujian']) && $data['is_koreksi_hasil_pengujian']) {
            $uloSave->is_koreksi_hasil_pengujian = 1;
        }

        // FILE
        if ($file1 = $request->file('uploadSuratPerintahTugas')) {
            $date_reformat = new DateHelper();

            $filename1 = "surat-perintah-tugas" . time() . '.' . $file1->extension();
            $path1 = $file1->storeAs('public/file_ulo', $filename1);
            $name1 = $file1->getClientOriginalName();
            $path1 = str_replace('public/', 'storage/', $path1);
        }
        if ($file2 = $request->file('UploadDokumenHasilEvaluasiPelaksanaanUlo')) {
            $date_reformat = new DateHelper();

            $filename2 = "dokumen-hasil-evaluasi-pelaksanaan-ulo" . time() . '.' . $file2->extension();
            $path2 = $file2->storeAs('public/file_ulo', $filename2);
            $name2 = $file2->getClientOriginalName();
            $path2 = str_replace('public/', 'storage/', $path2);
        }

        function tgl_indo($tanggal)
        {
            $pecahkan = explode('-', $tanggal);
            return $pecahkan[2] . '-' . $pecahkan[2] . '-' . $pecahkan[0];
        }
        // END FILE
        $uloSave->catatan_surat_permohonan = isset($data['catatan_surat_permohonan']) ? $data['catatan_surat_permohonan'] : '';
        $uloSave->catatan_surat_tugas = isset($data['catatan_surat_tugas']) ? $data['catatan_surat_tugas'] : '';
        $uloSave->catatan_hasil_pengujian = isset($data['catatan_hasil_pengujian']) ? $data['catatan_hasil_pengujian'] : '';
        $uloSave->catatan_evaluasi = $data['catatan_hasil_evaluasi'];
        $uloSave->updated_date = date('Y-m-d H:i:s');
        $uloSave->status_laik = $data['status_laik'];

        if ($uloToLog['jenis_izin'] == "TELSUS") {
            $uloSave->media_transmisi_yang_digunakan = isset($data['MediaTransmisiYangDigunakan']) ? $data['MediaTransmisiYangDigunakan'] : '';
        } else {
            $uloSave->alamat_pusat_layanan_pelangan = isset($data['alamatPusatLayananPelangan']) ? $data['alamatPusatLayananPelangan'] : '';
        }
        $uloSave->alamat_pelaksanaan_ulo = isset($data['AlamatPelaksanaanUlo']) ? $data['AlamatPelaksanaanUlo'] : '';
        $uloSave->tanggal_evaluasi_pelaksanaan_ulo = isset($data['TanggalEvaluasiPelaksanaanUlo']) ? tgl_indo($data['TanggalEvaluasiPelaksanaanUlo']) : '';
        $uloSave->no_surat_perintah_tugas = isset($data['NoSuratPerintahTugas']) ? $data['NoSuratPerintahTugas'] : '';
        $uloSave->tanggal_surat_perintah_tugas = isset($data['TanggalSuratPerintahTugas']) ? tgl_indo($data['TanggalSuratPerintahTugas']) : '';
        $uloSave->upload_surat_perintah_tugas = isset($path1) ? $path1 : '';
        $uloSave->upload_surat_perintah_tugas_asli = isset($name1) ? $name1 : '';
        $uloSave->dasar_surat_permohonan_ulo = isset($data['DasarSuratPermohonanUlo']) ? $data['DasarSuratPermohonanUlo'] : '';
        $uloSave->upload_dokumen_hasil_evaluasi_pelaksanaan_ulo = isset($path2) ? $path2 : '';
        $uloSave->upload_dokumen_hasil_evaluasi_pelaksanaan_ulo_asli = isset($name2) ? $name2 : '';

        $uloSave->save();


        DB::commit();
        session()->flash('message', 'Berhasil Mengirim Evaluasi ke Subkoordinator');

        //penanggungjawab dan kirim email
        $email_data = array();
        $email_data_subkoordinator = array();
        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);

        $email_jenis = 'evaluasi-evaluator-pj';
        $nama2 = '';
        $kirim_email = $email->kirim_email($penanggungjawab, $email_jenis, $ulo, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, '', '', '', '');

        //kirim email subkoordinator
        $user['email'] = isset($subkoordinator->email) ? $subkoordinator->email : '';
        $user['nama'] = isset($subkoordinator->nama) ? $subkoordinator->nama : '';
        $nama2 = '';
        $email_jenis = 'evaluasi-evaluator';
        $catatan_hasil_evaluasi = $catatan_hasil_evaluasi;

        $kirim_email2 = $email->kirim_email2($user, $email_jenis, $ulo, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all);

        // } catch (\Exception $e) {
        //     DB::rollback();
        //     throw ValidationException::withMessages(['message' => 'Gagal']);
        // }

        return Redirect::route('admin.evaluator.ulo');
    }

    public function penomoran(Request $request)
    {
        $id_user_session = Session::get('id_user');
        $id_departemen_user = Session::get('id_departemen');

        if ($id_departemen_user != 5) {
            return abort(404);
        }

        $limit_db = Config::get('app.admin.limit');
        $status_penomoran = 901;
        $date_reformat = new DateHelper();

        // $penomoran = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses', 't.*', 'v.*',
        // 'y.kode_akses','x.kode_akses as bloknomor_list')
        //     ->join('vw_list_izin as v', 't.id_izin', '=', 'v.id_izin')
        //     ->join('tb_trx_disposisi_evaluator_penomoran as d', 'd.id_izin', '=', 'v.id_izin')
        //     ->leftjoin('tb_trx_kode_akses_alokasi as y', 't.id_mst_kode_akses','=','y.id')
        //     ->leftjoin('vw_kodeakses_bloknomor as x', 't.id_izin','=','x.id_izin')
        //     ->where('d.id_disposisi_user', '=', Session::get('id_user'))
        //     ->distinct('t.id', 't.id_izin')
        //     ->where('v.status_checklist', '=', $status_penomoran)
        //     // ->with('KodeIzin')->with('KodeAkses')->with('KodeAkses.JenisKodeAkses')
        //     ->take($limit_db);
        $penomoran = Penomoran::from('tb_trx_kode_akses as t')->select(
            't.id as id_kode_akses',
            't.*',
            'v.*',
            'y.kode_akses',
            'x.kode_akses as bloknomor_list'
        )
            ->join('vw_list_izin as v', 't.id_izin', '=', 'v.id_izin')
            ->join('tb_trx_disposisi_evaluator_penomoran as d', 'd.id_izin', '=', 'v.id_izin')
            ->leftjoin('tb_trx_kode_akses_alokasi as y', 't.id_mst_kode_akses', '=', 'y.id')
            ->leftjoin('vw_kodeakses_bloknomor as x', 't.id_izin', '=', 'x.id_izin')
            ->where('d.id_disposisi_user', '=', Session::get('id_user'))
            ->with('KodeIzin')->with('KodeAkses')->distinct('t.id', 't.id_izin');
        // ->with('KodeIzin')->with('KodeAkses')->with('KodeAkses.JenisKodeAkses')
        // ->take($limit_db);
        // $penomoran = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses','t.*','v.*',
        // 'z.name_status_fo as penomoran_fo', 'z.name_status_bo as penomoran_bo', 'y.kode_akses')
        // ->join('vw_list_izin as v','t.id_izin','=','v.id_izin')
        // ->join('tb_oss_mst_kodestatusizin as z','t.status_permohonan','=','z.oss_kode')
        // ->leftjoin('tb_mst_kode_akses as y','t.id_mst_kode_akses','=','y.id')
        // ->where('d.id_disposisi_user', '=', Session::get('id_user'))
        // ->take($limit_db);

        // $penomoran = $penomoran->where('t.status_permohonan', '=', $status_penomoran);
        // dd($penomoran->get());
        // $countdisposisi = $penomoran->count();

        // if ($penomoran->count() > 0) { //handle paginate error division by zero
        //     $penomoran = $penomoran->paginate($limit_db);
        // } else {
        //     $penomoran = $penomoran->get();
        // }
        // $paginate = $penomoran;
        // $penomoran = $penomoran->toArray();
        $countevaluasi = $penomoran->clone()->where(function ($q) {
            $q->where('t.status_permohonan', '=', 901);
        })->get()->count();
        //getcountiizin 
        // IzinHelper::countPenomoran($status_penomoran,$id_departemen_user);
        $jenis_izin = 'Izin Penyelenggaraan Penomoran Telekomunikasi';
        // dd($countevaluasi);
        $log = DB::table('vw_penomoran_all as t')->select('t.*')
            ->whereIn('t.status_permohonan', [901])
            ->where('id_disposisi_user', '=', Session::get('id_user'))->get();
        $log = $log->toArray();


        return view('layouts.backend.evaluator.dashboard-penomoran', [
            'log' => $log, 'date_reformat' => $date_reformat,
            'penomoran' => $penomoran, 'countevaluasi' => $countevaluasi, 'jenis_izin' =>
            $jenis_izin
        ]);
    }

    public function pencabutanPenomoran($id)
    {
        // dd($id);
        $id_user_session = Session::get('id_user');
        $id_departemen_user = Session::get('id_departemen');
        $common = new CommonHelper();
        $date = new DateHelper();
        if ($id_departemen_user != 5) {
            return abort(404);
        }

        $limit_db = Config::get('app.admin.limit');
        $status_penomoran = 901;

        $penomoran_alokasi = DB::table('vw_penomoran_alokasi_new as t')->select('t.*')
            ->where('t.id', '=', $id)
            // ->whereIn('t.status_permohonan',[$status_penomoran,915])
            ->first();
        // $penomoran_alokasi = $penomoran_alokasi->toArray();

        if (empty($penomoran_alokasi)) {
            return abort(404);
        }

        $date_reformat = new DateHelper();
        // $id = $penomoran_alokasi->id;
        // dd($penomoran_alokasi->id_mst_kode_akses);
        return view('layouts.backend.evaluator.evaluasi-pencabutan-penomoran', [
            'date_reformat' => $date_reformat, 'id' => $id,
            'penomoran' => $penomoran_alokasi
        ]);
    }

    public function evaluasiPenomoran($id, Request $request)
    {
        $id_user_session = Session::get('id_user');
        $id_departemen_user = Session::get('id_departemen');
        $common = new CommonHelper();
        $date = new DateHelper();
        if ($id_departemen_user != 5) {
            return abort(404);
        }

        $limit_db = Config::get('app.admin.limit');
        $status_penomoran = 901;

        $penomoran_bloknomor = BlokNomor_List::where('id_izin', '=', $id)->get()->toArray();
        $vw_kodeakses_additional = vw_kodeakses_adds::where(
            'id_izin',
            '=',
            $id
        )->get();
        $vw_kodeakses_additional_count = $vw_kodeakses_additional->count();
        $vw_kodeakses_additional = $vw_kodeakses_additional->toArray();
        $vw_kodeakses_additional_nonarray = vw_kodeakses_adds::where(
            'id_izin',
            '=',
            $id
        )
            ->get();
        $penomoran = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses', 't.*', 'v.*')
            ->join('vw_list_izin as v', 't.id_izin', '=', 'v.id_izin')
            ->join('tb_trx_disposisi_evaluator_penomoran as d', 'd.id_izin', '=', 'v.id_izin')
            ->where('d.id_disposisi_user', '=', Session::get('id_user'))
            ->where('t.id_izin', '=', $id)
            ->with('KodeIzin')->with('KodeAkses');
        $penomoran = $penomoran->where('t.status_permohonan', '=', $status_penomoran);

        $penomoran = $penomoran->first();
        if (empty($penomoran)) {
            return abort(404);
        }
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
        $note = $penomoran['jenis_permohonan'] . ' (' . $penomoran['note'] . ')';
        $map = $common->getMapKodeAkses($id_mst_kode_akses);

        $detailNib = $common->get_detail_nib($nib);

        $penomoranlog = Penomoranlog::where('id_izin', '=', $id)
            // ->where('id_kode_akses','=',$id_kodeakses)
            ->with('KodeIzin')->get()->toArray();
        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        $jenis_izin = 'Penomoran';
        // dd($penomoran['kode_akses']['kode_akses']);
        return view('layouts.backend.evaluator.evaluasi-penomoran', [
            'date_reformat' => $date_reformat, 'penomoran' =>
            $penomoran, 'penomoranlog' => $penomoranlog, 'jenis_izin' => $jenis_izin, 'id' => $id, 'detailnib' =>
            $detailNib, 'penanggungjawab' => $penanggungjawab, 'penomoran_bloknomor' => $penomoran_bloknomor,
            'vw_kodeakses_additional' => $vw_kodeakses_additional, 'vw_kodeakses_additional_nonarray' =>
            $vw_kodeakses_additional_nonarray, 'vw_kodeakses_additional_count' => $vw_kodeakses_additional_count, 'note'
            => $note
        ]);
    }
    public function updatebloknomor(Request $request)
    {
        try {
            // dd($request->all());
            // Log::info($request->all());
            if ($request['value'] != "") {

                $cek_bloknomor = DB::table('tb_trx_kode_akses_alokasi_bloknomor')->select('*')
                    ->where('id_izin', '=', $request['id_izin'])
                    ->where('kode_wilayah', '=', $request['kode_wilayah'])
                    ->where('prefix_awal', '=', $request['prefix_awal'])
                    ->get();
                $cek_bloknomor = $cek_bloknomor->count();
                if ($cek_bloknomor > 0) {
                    if ($request['value'] == "1") {
                        $update = DB::table('tb_trx_kode_akses_alokasi_bloknomor')->select('*')
                            ->where('id_izin', '=', $request['id_izin'])
                            ->where('kode_wilayah', '=', $request['kode_wilayah'])
                            ->where('prefix_awal', '=', $request['prefix_awal'])
                            ->update([
                                'status' => 'DALAM PROSES',
                                'status_evaluasi_bloknomor' => $request['value'],
                                'updated_date' => date('Y-m-d H:i:s'),
                                'updated_by' => Session::get('nama')
                            ]);
                    } else {
                        $update = DB::table('tb_trx_kode_akses_alokasi_bloknomor')->select('*')
                            ->where('id_izin', '=', $request['id_izin'])
                            ->where('kode_wilayah', '=', $request['kode_wilayah'])
                            ->where('prefix_awal', '=', $request['prefix_awal'])
                            ->update([
                                'status' => 'Idle',
                                'status_evaluasi_bloknomor' => $request['value'],
                                'updated_date' => date('Y-m-d H:i:s'),
                                'updated_by' => Session::get('nama')

                            ]);
                    }
                } else {
                    $insertBlokNomor = [
                        'id_izin' => $request['id_izin'],
                        'id_mst_jenis_kode_akses' => '17',
                        'jenis_penomoran' => 'Blok Nomor',
                        'kode_wilayah' => $request['kode_wilayah'],
                        'prefix_awal' => $request['prefix_awal'],
                        'id_mst_kodestatusizin' => '913',
                        'status' => 'DALAM PROSES',
                        'status_evaluasi_bloknomor' => 1,
                        'nomor_penetapan' => '',
                        'tanggal_penetapan' => null,
                        'nama_pelakuusaha' => null,
                        // 'nib' => $oss_id,
                        'is_active' => '1',
                        'updated_date' => date('Y-m-d H:i:s'),
                        'created_date' => date('Y-m-d H:i:s'),
                        'updated_by' => Session::get('nama'),
                        'created_by' => Session::get('nama')
                    ];
                    $bloknomor_query = DB::table('tb_trx_kode_akses_alokasi_bloknomor')->insert($insertBlokNomor);
                }
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Log the exception
            Log::error($e);

            // Return a meaningful error response
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function updatekodeakses(Request $request)
    {
        try {
            // dd($request->all());
            // Log::info($request->all());
            if ($request['value'] != "") {

                $check_kodeakses_ = DB::table('tb_trx_kode_akses_alokasi')
                    ->where('tb_trx_kode_akses_alokasi.kode_akses', '=', $request['kode_akses'])
                    ->first();

                $check_kodeakses = DB::table('tb_trx_kode_akses_additional')->select('*')
                    ->where('id_permohonan', '=', $request['id_izin'])
                    ->where('id_mst_kode_akses', '=', $check_kodeakses_->id)
                    ->get();
                $check_kodeakses = $check_kodeakses->count();

                if ($check_kodeakses > 0) {
                    if ($request['value'] == 1) {
                        $update_trxkodeakses = DB::table('tb_trx_kode_akses_additional')->select('*')
                            ->where('id_izin', '=', $request['id_izin'])
                            ->where('id_mst_kode_akses', '=', $check_kodeakses_->id)
                            ->update([
                                'status_permohonan' => '302',
                                'jenis_permohonan' => 'Penetapan Penomoran Ulang',
                                // 'status' => 'DALAM PROSES',
                                'is_active' => 1,
                                'updated_date' => date('Y-m-d H:i:s'),
                                'created_date' => date('Y-m-d H:i:s'),
                                'updated_by' => Session::get('nama'),
                                'created_by' => Session::get('nama')
                            ]);
                    } else {
                        $update_trxkodeakses = DB::table('tb_trx_kode_akses_additional')->select('*')
                            ->where('id_izin', '=', $request['id_izin'])
                            ->where('id_mst_kode_akses', '=', $check_kodeakses_->id)
                            ->update([
                                'status_permohonan' => '301',
                                'jenis_permohonan' => 'Penetapan Pencabutan',
                                // 'status' => 'DALAM PROSES',
                                'is_active' => 1,
                                'updated_date' => date('Y-m-d H:i:s'),
                                'created_date' => date('Y-m-d H:i:s'),
                                'updated_by' => Session::get('nama'),
                                'created_by' => Session::get('nama')
                            ]);
                    }
                } else {
                    if ($request['value'] == 1) {
                        $insert_trxkodeakses = [
                            'is_active' => 1,
                            'id_permohonan' => $request['id_izin'],
                            'id_izin' => $request['id_izin'],
                            'id_mst_kode_akses' => $check_kodeakses_->id,
                            'status_permohonan' => '302',
                            'jenis_permohonan' => 'Penetapan Penomoran Ulang',
                            // 'status' => 'DALAM PROSES',
                            'is_active' => 1,
                            'updated_date' => date('Y-m-d H:i:s'),
                            'created_date' => date('Y-m-d H:i:s'),
                            'updated_by' => Session::get('nama'),
                            'created_by' => Session::get('nama')
                        ];
                    } else {
                        $insert_trxkodeakses = [
                            'is_active' => 1,
                            'id_permohonan' => $request['id_izin'],
                            'id_izin' => $request['id_izin'],
                            'id_mst_kode_akses' => $check_kodeakses_->id,
                            'status_permohonan' => '301',
                            'jenis_permohonan' => 'Penetapan Pencabutan',
                            // 'status' => 'DALAM PROSES',
                            'is_active' => 1,
                            'updated_date' => date('Y-m-d H:i:s'),
                            'created_date' => date('Y-m-d H:i:s'),
                            'updated_by' => Session::get('nama'),
                            'created_by' => Session::get('nama')
                        ];
                    }
                    $bloknomor_query = DB::table('tb_trx_kode_akses_additional')->insert($insert_trxkodeakses);
                }
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Log the exception
            Log::error($e);

            // Return a meaningful error response
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }


    public function disactivatedkodeakses(Request $request)
    {
        try {
            // dd($request->all());
            // Log::info($request);
            $check_kodeakses_ = DB::table('tb_trx_kode_akses_alokasi')
                ->where('tb_trx_kode_akses_alokasi.kode_akses', '=', $request['kode_akses'])
                ->first();
            // Log::info('Value of idIzin: ', $request['kode_akses']);

            $check_kodeakses = DB::table('tb_trx_kode_akses_additional')->select('*')
                ->where('id_permohonan', '=', $request['id_izin'])
                ->where('id_mst_kode_akses', '=', $check_kodeakses_->id)
                ->get();
            // // Log::info(
            // Log::info('Value of idIzin: ', $check_kodeakses_->id);
            $check_kodeakses = $check_kodeakses->count();

            if ($check_kodeakses > 0) {
                $update_trxkodeakses = DB::table('tb_trx_kode_akses_additional')->select('*')
                    ->where('id_izin', '=', $request['id_izin'])
                    ->where('id_mst_kode_akses', '=', $check_kodeakses_->id)
                    ->update([
                        'status_permohonan' => NULL,
                        'jenis_permohonan' => NULL,
                        // 'status' => 'DALAM PROSES',
                        'is_active' => 0,
                        'updated_date' => date('Y-m-d H:i:s'),
                        'created_date' => date('Y-m-d H:i:s'),
                        'updated_by' => Session::get('nama'),
                        'created_by' => Session::get('nama')
                    ]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Log the exception
            Log::error($e);

            // Return a meaningful error response
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function updateskinfokodeakses(Request $request)
    {
        try {
            // dd($request->all());
            $update_trxkodeakses = DB::table('tb_trx_kode_akses')->select('*')
                ->where('id_izin', '=', $request['id_izin'])
                ->where('id', '=', $request['id_kodeakses'])
                ->update([
                    'pe_no_sk' => $request['no_sk'],
                    'pe_date_sk' => $request['tgl_sk'],
                    // 'status' => 'DALAM PROSES',
                    'is_active' => 0,
                    'updated_date' => date('Y-m-d H:i:s'),
                    'created_date' => date('Y-m-d H:i:s'),
                    'updated_by' => Session::get('nama'),
                    'created_by' => Session::get('nama')
                ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Log the exception
            Log::error($e);

            // Return a meaningful error response
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
    public function updateskpencabutankodeakses(Request $request)
    {
        try {
            // dd($request->all());
            $update_penomoran_pencabutan_count = DB::table('tb_trx_penomoran_pencabutan')->select('*')
                ->where('id_mst_kode_akses', '=', $request['id'])
                ->first();
            // $update_penomoran_pencabutan_count = $update_penomoran_pencabutan_count->count();
            if (isset($update_penomoran_pencabutan_count)) {
                $update_penomoran_pencabutan = DB::table('tb_trx_penomoran_pencabutan')->select('*')
                    ->where('id_mst_kode_akses', '=', $request['id'])
                    ->update([
                        'dasar_pencabutan' => $request['dasarpencabutan'],
                        'pertimbangan_pencabutan' => $request['pertimbanganpencabutan'],
                        // 'status' => 'DALAM PROSES',
                        // 'is_active' => 0
                        'updated_date' => date('Y-m-d H:i:s'),
                        'created_date' => date('Y-m-d H:i:s'),
                        'updated_by' => Session::get('nama'),
                        'created_by' => Session::get('nama')
                    ]);
            } else {
                $update_penomoran_pencabutan = [
                    'id_mst_kode_akses' => $request['id'],
                    'dasar_pencabutan' => $request['dasarpencabutan'],
                    'pertimbangan_pencabutan' => $request['pertimbanganpencabutan'],
                    'updated_date' => date('Y-m-d H:i:s'),
                    'created_date' => date('Y-m-d H:i:s'),
                    'updated_by' => Session::get('nama'),
                    'created_by' => Session::get('nama')
                ];
                $bloknomor_query = DB::table('tb_trx_penomoran_pencabutan')->insert($update_penomoran_pencabutan);
            }


            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Log the exception
            Log::error($e);

            // Return a meaningful error response
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function evaluasiPenomoranPost($id, $id_kodeakses, Request $request)
    {
        $date_reformat = new DateHelper();

        $common = new CommonHelper();
        $email = new EmailHelper();
        $log = new LogHelper();
        $id_departemen_user = Session::get('id_departemen');

        $id_izin = $request['id_izin'];
        $koreksi_all = 0;
        if ($id_izin != $id) {
            return Redirect::route('admin.evaluator');
        }

        $status_penomoran = 901;

        $penomoran_query = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses', 't.*', 'v.*', 'd.id_disposisi_user')
            ->join('vw_list_izin as v', 't.id_izin', '=', 'v.id_izin')
            ->join('tb_trx_disposisi_evaluator_penomoran as d', 'd.id_izin', '=', 'v.id_izin')
            ->where('d.id_disposisi_user', '=', Session::get('id_user'))
            ->where('t.id', '=', $id_kodeakses)
            ->with('KodeIzin')
            ->with('KodeAkses');
        $penomoran_query = $penomoran_query->where('t.status_permohonan', '=', $status_penomoran);

        $penomoran_query = $penomoran_query->first();
        // dd($penomoran_query);

        if (empty($penomoran_query)) {
            return abort(404);
        }

        $penomoran = $penomoran_query->toArray();
        // dd($penomoran);
        $mst_kodeakses = $common->getDetailKodeAkses($penomoran, $penomoran['id_mst_kode_akses']);

        $nib = $penomoran['nib'];
        $nibs = Nib::where('nib', $nib)->first();
        $nibs = $nibs->toArray();

        $id_izin = $penomoran['id_oss_trxizin'];
        $getPenomoran = Penomoran::where('id', '=', $id_kodeakses)->where('status_permohonan', '=', $status_penomoran)->with('KodeIzin')->with('KodeAkses')->first();

        if (empty($getPenomoran)) {
            return abort(404);
        }

        $koreksi_all = 0;
        $data = $request->all();
        // dd($data['no_sk'],$data['tgl_sk']);
        $id_koreksi = array();
        $catatan_koreksi = array();

        $catatan_hasil_evaluasi = $request->get('catatan_hasil_evaluasi');

        //kondisional departemen
        $departemen = $common->getDepartemen($id_departemen_user);

        //end konsidisional departemen
        // try {
        DB::beginTransaction();
        $penomoranToSave = $getPenomoran;
        $Izinoss = Izinoss::where('id_izin', '=', $id)->first();
        //set status checklist telah didisposisi


        if ($data['status_sk'] == 0) { //jika ditolak
            $penomoranToSave->status_permohonan = 90;
            $penomoran_alokasi =
                DB::table('tb_trx_kode_akses_alokasi')->select('*')->where(
                    'id',
                    '=',
                    $penomoran['id_mst_kode_akses']
                )->update([
                    'status' => 'Idle', 'id_mst_kodestatusizin' =>
                    '916', 'nomor_penetapan' => NULL, 'tanggal_penetapan' => NULL,
                    'nib' => NULL, 'nama_pelakuusaha' => NULL
                ]);
            // if (
            //     $penomoran['jenis_permohonan'] == 'Pengembalian Penomoran' || $penomoran['jenis_permohonan'] ==
            //     'Perubahan Penetapan'
            // ) {
            //     $penomoran_alokasi =
            //         DB::table('tb_trx_kode_akses_alokasi')->select('*')->where(
            //             'id',
            //             '=',
            //             $penomoran['id_mst_kode_akses']
            //         )->update([
            //             'status' => 'DALAM PROSES'
            //         ]);
            // } else {
            //     $penomoran_alokasi =
            //         DB::table('tb_trx_kode_akses_alokasi')->select('*')->where(
            //             'id',
            //             '=',
            //             $penomoran['id_mst_kode_akses']
            //         )->update([
            //             'status' => 'Idle'
            //         ]);
            // }
            // if ($request['bloknomor']) {
            //     foreach ($request->bloknomor as $p) {
            //         // dd($request['bloknomor'],$request['id_izin'], $p['bn_kode_wilayah'], $p['bn_prefix_awal']);
            //         $update = DB::table('tb_trx_kode_akses_alokasi_bloknomor')->select('*')
            //             ->where('id_izin', '=', $request['id_izin'])
            //             ->where('kode_wilayah', '=', $p['bn_kode_wilayah'])
            //             ->where('prefix_awal', '=', $p['bn_prefix_awal'])
            //             ->update([
            //                 'status' => 'Idle',
            //                 'status_evaluasi_bloknomor' => $p['is_deleted'],
            //                 'updated_date' => date('Y-m-d H:i:s'),
            //                 'updated_by' => Session::get('nama')

            //             ]);
            //     }
            // }
            $Izinoss->status_checklist = 90;
            $Izinoss->updated_at = date('Y-m-d H:i:s');
            $Izinoss->save();
            $insertIzinLog = $log->createIzinLog($Izinoss, $catatan_hasil_evaluasi);
        } else {

            // if ($request['bloknomor']) {
            //     foreach ($request->bloknomor as $p) {
            //         // dd($request['bloknomor'],$request['id_izin'], $p['bn_kode_wilayah'], $p['bn_prefix_awal']);
            //         $update = DB::table('tb_trx_kode_akses_alokasi_bloknomor')->select('*')
            //             ->where('id_izin', '=', $request['id_izin'])
            //             ->where('kode_wilayah', '=', $p['bn_kode_wilayah'])
            //             ->where('prefix_awal', '=', $p['bn_prefix_awal'])
            //             ->update([
            //                 'status_evaluasi_bloknomor' => $p['is_deleted'],
            //                 'updated_date' => date('Y-m-d H:i:s'),
            //                 'updated_by' => Session::get('nama')

            //             ]);
            //     }
            // }

            if ($file1 = $request->file('berkas_tambahan')) {
                // $date_reformat = new DateHelper();

                $filename1 = "KOMINFO" . time() . '-' . $id . '-' . $id_kodeakses . '.' . $file1->extension();
                $path1 = $file1->storeAs('public/file_penomoran', $filename1);
                $name1 = $file1->getClientOriginalName();
                $path1 = str_replace('public/', 'storage/', $path1);
                $penomoranToSave->path_dok_evaluasi_tambahan = $path1;
            }

            if (isset($data['is_koreksi_dokumen_1']) && $data['is_koreksi_dokumen_1'] == 'on') {
                $koreksi_all = 1;
                $penomoranToSave->is_koreksi_dok_pengguna_penomoran = 1;
            } else {
                $penomoranToSave->is_koreksi_dok_pengguna_penomoran = 0;
            }
            if (isset($data['is_koreksi_dokumen_2']) && $data['is_koreksi_dokumen_2'] == 'on') {
                $koreksi_all = 1;
                $penomoranToSave->is_koreksi_dok_kode_akses_konten = 1;
            } else {
                $penomoranToSave->is_koreksi_dok_kode_akses_konten = 0;
            }
            if (isset($data['is_koreksi_dokumen_3']) && $data['is_koreksi_dokumen_3'] == 'on') {
                $koreksi_all = 1;
                $penomoranToSave->is_koreksi_dok_call_center = 1;
            } else {
                $penomoranToSave->is_koreksi_dok_call_center = 0;
            }
            if (isset($data['is_koreksi_dokumen_4']) && $data['is_koreksi_dokumen_4'] == 'on') {
                $koreksi_all = 1;
                $penomoranToSave->is_koreksi_pe_dok_sk = 1;
            } else {
                $penomoranToSave->is_koreksi_pe_dok_sk = 0;
            }
            if (isset($data['is_koreksi_dokumen_5']) && $data['is_koreksi_dokumen_5'] == 'on') {
                $koreksi_all = 1;
                $penomoranToSave->is_koreksi_pe_dok_perizinan_terakhir = 1;
            } else {
                $penomoranToSave->is_koreksi_pe_dok_perizinan_terakhir = 0;
            }
            if (isset($data['is_koreksi_dokumen_6']) && $data['is_koreksi_dokumen_6'] == 'on') {
                $koreksi_all = 1;
                $penomoranToSave->is_koreksi_pe_pe_dok_pendukung = 1;
            } else {
                $penomoranToSave->is_koreksi_pe_pe_dok_pendukung = 0;
            }
            if (isset($data['is_koreksi_dokumen_7']) && $data['is_koreksi_dokumen_7'] == 'on') {
                $koreksi_all = 1;
                $penomoranToSave->is_koreksi_dok_izin_penyelenggaraan = 1;
            } else {
                $penomoranToSave->is_koreksi_dok_izin_penyelenggaraan = 0;
            }

            //kondisional jika koreksi
            if ($koreksi_all == 1 || $data['status_sk'] == 0) {
                $penomoranToSave->status_permohonan = 90;
                $penomoranToSave->catatan_dok_pengguna_penomoran = isset($data['catatan_dok_pengguna_penomoran ']) ? $data['catatan_dok_pengguna_penomoran '] : '';
                $penomoranToSave->catatan_dok_kode_akses_konten = isset($data['catatan_dok_kode_akses_konten']) ? $data['catatan_dok_kode_akses_konten'] : '';
                $penomoranToSave->catatan_dok_call_center = isset($data['catatan_dok_call_center']) ? $data['catatan_dok_call_center'] : '';
                $penomoranToSave->catatan_dok_izin_penyelenggaraan = isset($data['catatan_dok_izin_penyelenggaraan']) ? $data['catatan_dok_izin_penyelenggaraan'] : '';
                $penomoranToSave->catatan_pe_dok_sk = isset($data['catatan_pe_dok_sk']) ? $data['catatan_pe_dok_sk'] : '';
                $penomoranToSave->catatan_pe_dok_perizinan_terakhir = isset($data['catatan_pe_dok_perizinan_terakhir']) ? $data['catatan_pe_dok_perizinan_terakhir'] : '';
                $penomoranToSave->catatan_pe_dok_pendukung = isset($data['catatan_pe_dok_pendukung']) ? $data['catatan_pe_dok_pendukung'] : '';
            } else {
                $penomoranToSave->catatan_dok_pengguna_penomoran = '';
                $penomoranToSave->catatan_dok_kode_akses_konten = '';
                $penomoranToSave->catatan_dok_call_center = '';
                $penomoranToSave->catatan_dok_izin_penyelenggaraan = '';
                $penomoranToSave->catatan_pe_dok_sk = '';
                $penomoranToSave->catatan_pe_dok_perizinan_terakhir = '';
                $penomoranToSave->catatan_pe_dok_pendukung = '';
                $penomoranToSave->status_permohonan = 902;
                if (isset($data['no_sk'])) {
                    $penomoranToSave->pe_no_sk = $data['no_sk'];
                    $penomoranToSave->pe_date_sk = $data['tgl_sk'];
                }
            }
        }
        $penomoranToSave->catatan_hasil_evaluasi = $catatan_hasil_evaluasi;
        $penomoranToSave->updated_date = date('Y-m-d H:i:s');
        $penomoranToSave->updated_by = Session::get('nama');
        $penomoranToSave->save();

        //Jika ada ada tambahan penetapan

        if ($penomoran['jenis_permohonan'] == 'Pengembalian Penomoran' || $penomoran['jenis_permohonan'] == 'Perubahan Penetapan') {
            if ($request['kodeakses_hapus']) {
                foreach ($request->kodeakses_hapus as $hapus) {
                    // $check_exist = DB::table('tb_trx_kode_akses_alokasi')
                    //     ->join('tb_trx_kode_akses', 'tb_trx_kode_akses.id_mst_kode_akses','=','tb_trx_kode_akses_alokasi.id')
                    //     ->where('tb_trx_kode_akses_alokasi.kode_akses', '=', $hapus['kode_akses'])
                    //     ->where('tb_trx_kode_akses.status_permohonan', '!=','90')
                    //     ->where('tb_trx_kode_akses.status_permohonan', '!=','50')
                    //     ->where('tb_trx_kode_akses.jenis_permohonan','=','Pengembalian Penomoran')
                    //     ->get();
                    // $check_exist_count = $check_exist -> count();
                    // if($check_exist_count>0){
                    //     // dd($check_exist);
                    // }
                    // else{
                    $check_kodeakses_ = DB::table('tb_trx_kode_akses_alokasi')
                        ->where('tb_trx_kode_akses_alokasi.kode_akses', '=', $hapus['kode_akses'])
                        ->first();

                    // $check_kodeakses_ = $check_kodeakses_ ->array();
                    if ($hapus['status_pe_sk'] == 1) {
                        $insert_trxkodeakses = new TrxKodeAkses_Additional([
                            'is_active' => 1,
                            'id_permohonan' => $request['id_izin'],
                            'id_izin' => $request['id_izin'],
                            'id_mst_kode_akses' => $check_kodeakses_->id,
                            'status_permohonan' => '302',
                            'jenis_permohonan' => 'Penetapan Penomoran Ulang',
                            'is_active' => 1,
                            'updated_date' => date('Y-m-d H:i:s'),
                            'created_date' => date('Y-m-d H:i:s'),
                            'updated_by' => Session::get('nama'),
                            'created_by' => Session::get('nama')
                        ]);
                    } else {
                        $insert_trxkodeakses = new TrxKodeAkses_Additional([
                            'is_active' => 1,
                            'id_permohonan' => $request['id_izin'],
                            'id_izin' => $request['id_izin'],
                            'id_mst_kode_akses' => $check_kodeakses_->id,
                            'status_permohonan' => '301',
                            'jenis_permohonan' => 'Penetapan Pencabutan',
                            'is_active' => 1,
                            'updated_date' => date('Y-m-d H:i:s'),
                            'created_date' => date('Y-m-d H:i:s'),
                            'updated_by' => Session::get('nama'),
                            'created_by' => Session::get('nama')
                        ]);
                    }

                    // $insert_trxkodeakses->save();
                    $penomoran_alokasi = DB::table('tb_trx_kode_akses_alokasi')
                        ->select('*')
                        ->where('id', '=', $check_kodeakses_->id)
                        ->update(['status' => 'DALAM PROSES']);
                    // }
                }
            }
        }



        //insert log
        $penomoranToLog = Penomoran::where('id', '=', $id_kodeakses)->first()->toArray();
        $insertUloLog = $log->createPenomoranLog($penomoranToLog, $status_penomoran);
        $Izinoss = Izinoss::where('id_izin', '=', $id)->first();
        //set status checklist telah didisposisi
        $insertIzinLog = $log->createIzinLog($Izinoss, $catatan_hasil_evaluasi);

        if ($koreksi_all == 1) {
            $Izinoss->status_checklist = 90;
        } elseif ($data['status_sk'] == 0) {
            $Izinoss->status_checklist = 90;
        } else {
            $Izinoss->status_checklist = 902;
        }
        $Izinoss->updated_at = date('Y-m-d H:i:s');
        $Izinoss->save();
        DB::commit();

        $departemen = [
            "full_kode_akses" => $mst_kodeakses['kode_akses']['kode_akses'],
            "jenis_penomoran" => $mst_kodeakses['kode_akses']['jenis_penomoran'],
            "jenis_permohonan" => $mst_kodeakses['jenis_permohonan'],
        ];

        //penanggungjawab dan kirim email
        $penanggungjawab = array();
        $email_data = array();
        $email_data_subkoordinator = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        $evaluator = DB::table('tb_trx_disposisi_evaluator_penomoran as a')
            ->join('tb_mst_user_bo as b', 'b.id', '=', 'a.id_disposisi_user')
            // ->where('b.is_accounttesting', '!=', 1)
            ->where('a.id_izin', $id)
            ->first();
            // dd();
        $nama2 = $evaluator->nama;
        if ($data['status_sk'] == 0 || $koreksi_all == 1) {
            session()->flash('message', 'Permohonan Ditolak');
            $email_jenis = 'tolak-penomoran-pj';
            $nama2 = $evaluator->nama;
            $kirim_email = $email->kirim_email($penanggungjawab, $email_jenis, $penomoran, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, '', '', '', '');
        } else {
            session()->flash('message', 'Berhasil Mengirim Evaluasi ke Verifikator');

            //get subkoordinator
            $subkoordinator = $common->get_subkoordinator_first($id_departemen_user);
            $jabatan = DB::table('tb_mst_jobposition')->where('id', $subkoordinator->id_mst_jobposition)->first();
            //end get subkoordinator

            $email_jenis = 'evaluasi-evaluator-pj';
            $nama2 = $evaluator->nama;
            $kirim_email = $email->kirim_email($penanggungjawab, $email_jenis, $penomoran, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, '', '', '', '');
            //end penganggungjawab

            //kirim email subkoordinator
            $user['email'] = isset($subkoordinator->email) ? $subkoordinator->email : '';
            $user['nama'] = $subkoordinator->nama;
            // $nama2 = $subkoordinator->nama;
            $email_jenis = 'evaluasi-evaluator';
            $catatan_hasil_evaluasi = $catatan_hasil_evaluasi;

            //end mengirim email ke evaluator
            $kirim_email2 = $email->kirim_email2($user, $email_jenis, $penomoran, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, $jabatan);
        }


        // } catch (\Exception $e) {
        //     DB::rollback();
        //     throw ValidationException::withMessages(['message' => 'Gagal']);
        // }

        return Redirect::route('admin.evaluator.penomoran');
    }

    public function setLog($id_oss_trxizin, $id_mst_Kodeakses, $id_izin, $jenis_permohonan)
    {
    $log = new LogKodeAkses();
    $log->id_oss_trxizin = $id_oss_trxizin;
    $log->id_mst_kode_akses = $id_mst_Kodeakses;
    $log->id_permohonan = $id_izin;
    $log->id_izin = $id_izin;
    $log->status_permohonan = '901';
    $log->jenis_permohonan = $jenis_permohonan;
    $log->is_active = 1;
    $log->updated_date = date('Y-m-d H:i:s');
    $log->created_date = date('Y-m-d H:i:s');
    $log->created_by = Session::get('id_user');
    $log->created_name = Session::get('nama');

    return $log->save();
    }
    public function savepencabutanpenomoran(Request $req)
    {
        // dd($req->all());
        $log = new LogHelper();
        $jenis_permohonan = "Pencabutan Penetapan Penomoran Telekomunikasi";
        $catatan_hasil_evaluasi = $req->get('catatan_hasil_evaluasi');
        // dd($req->all());
        $status_penomoran = 901;
        if ($file1 = $req->file('berkas_tambahan')) {
            $filename1 = "DataDukungPencabutan-" . time() . '.' . $file1->extension();
            $path1 = $file1->storeAs('public/penambahan/penomoran', $filename1);
            $name1 = $file1->getClientOriginalName();
            $path1 = str_replace('public/', 'storage/', $path1);
            // $penambahan_flag = true;
            // $jenis_permohonan = "Penetapan Nomor Tambahan";
        }
        $path1 = isset($path1) ? $path1 : '';
        // dd($id_jenislayanan, $id_jeniskodeakses, $kodeakses);
        // $oss_id = Auth::user()->oss_id;
        // $oss_nib = DB::table('tb_oss_nib')->select('*')->where('oss_id', $oss_id)->first();

        // $maxId = DB::table('tb_oss_trx_izin')->where('id_izin', 'LIKE', substr($oss_id, 0, 3) . '%')->get()->count();
        $maxId = DB::table('tb_oss_trx_izin')->where('id_izin', 'LIKE', 'NEV%')->get()->count();

        if ($maxId > 0) {
            // $maxId = substr($oss_id, 0, 3) . '-' . date('Ymd') . sprintf("%05s", $maxId + 1);
            $maxId = 'NEV-' . date('Ymd') . sprintf("%05s", $maxId + 1);
        } else {
            // $maxId = substr($oss_id, 0, 3) . '-' . date('Ymd') . sprintf("%05s", 1);
            $maxId = 'NEV-' . date('Ymd') . sprintf("%05s", 1);
        }
        $id_jeniskodeakses = DB::table('tb_trx_kode_akses_alokasi')->select('tb_mst_jenis_kode_akses.short_name')
            ->join(
                'tb_mst_jenis_kode_akses',
                'tb_mst_jenis_kode_akses.id',
                '=',
                'tb_trx_kode_akses_alokasi.id_mst_jenis_kode_akses'
            )->where('tb_trx_kode_akses_alokasi.id','=',$req->id)->first();
            // dd($id_jeniskodeakses);
        $jenis_izin = 'K03';
        $msg_success = 'Permohonan sudah berhasil disimpan dan akan dilakukan verifikasi.';
        $msg_failed = 'Mohon maaf permohonan penomoran tidak dapat diajukan, karena terdapat permohonan yang masih  belum selesai dengan jenis permohonan kode akses yang sama';
        // dd($id_jeniskodeakses->short_name, $maxId, $jenis_izin);

        $insert = new Izinoss([
            // 'oss_id' => $oss_id,
            'id_proyek' => $id_jeniskodeakses->short_name,
            // 'nib' => $oss_nib->nib,
            'id_izin' => $maxId,
            'jenis_izin' => $jenis_izin,
            // 'kd_daerah' => $oss_nib->perseroan_daerah_id,
            // 'kd_izin' => $id_jenislayanan,
            'status_checklist' => '902',
            'submitted_at' => date('Y-m-d H:i:s')
        ]);

        $insert->save();

        // $disposisi = Disposisi::create([
        // 'id_izin'=>$maxId,
        // 'id_disposisi_user'=>Session::get('id_user'),
        // 'catatan'=>$catatan_hasil_evaluasi,
        // 'created_by'=>Session::get('id_user'),
        // 'status_checklist_awal'=>'901',
        // 'is_active'=>1
        // ]);

        $disposisi = DB::table('tb_trx_disposisi_evaluator_penomoran')->insert([
        'id_izin'=>$maxId,
        'id_disposisi_user'=>Session::get('id_user'),
        'catatan'=>$catatan_hasil_evaluasi,
        'created_at'=>date('Y-m-d H:i:s'),
        'updated_at'=>date('Y-m-d H:i:s'),
        'created_by'=>Session::get('id_user'),
        'status_checklist_awal'=>'901',
        'is_active'=>1
        ]);

        $penomoran_alokasi = DB::table('tb_trx_kode_akses_alokasi')
        ->select('*')
        ->where('id', '=', $req->id)
        ->update(['status' => 'DALAM PROSES']);

        $insert_trxkodeakses = new TrxKodeAkses([
            'is_active' => 1,
            'id_permohonan' => $maxId,
            'id_izin' => $maxId,
            'id_mst_kode_akses' => $req->id,
            'status_permohonan' => '902',
            'jenis_permohonan' => $jenis_permohonan,
            'path_dok_evaluasi_tambahan' => $path1,
            'updated_date' => date('Y-m-d H:i:s'),
            'created_date' => date('Y-m-d H:i:s'),
            'updated_by' => Session::get('nama'),
            'catatan_hasil_evaluasi' => $catatan_hasil_evaluasi,
            'note' => $catatan_hasil_evaluasi,
            'created_by' => Session::get('nama')
        ]);

        $insert_trxkodeakses->save();

        $Izinoss = Izinoss::where('id_izin', '=', $maxId)->first();
        $insertIzinLog = $log->createIzinLog($Izinoss, $catatan_hasil_evaluasi);

        $insert_trxkodeakses_additional = new TrxKodeAkses_Additional([
            'is_active' => 1,
            'id_permohonan' => $maxId,
            'id_izin' => $maxId,
            'id_mst_kode_akses' => $req->id,
            'status_permohonan' => '302',
            'jenis_permohonan' => $jenis_permohonan,
            'is_active' => 1,
            'updated_date' => date('Y-m-d H:i:s'),
            'created_date' => date('Y-m-d H:i:s'),
            'updated_by' => Session::get('nama'),
            'created_by' => Session::get('nama')
        ]);
        $insert_trxkodeakses_additional->save();

        if ($insert_trxkodeakses->save()) {
            $update_penomoran_pencabutan = DB::table('tb_trx_penomoran_pencabutan')->select('*')
            ->where('id_mst_kode_akses', '=', $req->id)
            ->where('id_izin', '=', NULL)
            ->update([
            'id_izin' => $maxId,
            'updated_date' => date('Y-m-d H:i:s'),
            'created_date' => date('Y-m-d H:i:s'),
            'updated_by' => Session::get('nama'),
            'created_by' => Session::get('nama')
            ]);
            $penomoran_alokasi =
                DB::table('tb_trx_kode_akses_alokasi')->select('*')->where(
                    'id',
                    '=',
                    $req->id
                )->update([
                    'status' => 'DALAM PROSES'
                ]);
            // $this->setLog($req->id_oss_trxizin, $req->id, $maxId, $jenis_permohonan);
            $penomoranToLog = Penomoran::where('id_izin', '=', $maxId)->first()->toArray();
            $insertUloLog = $log->createPenomoranLog($penomoranToLog, $status_penomoran);

            // $jenis_izin = Izin::where('id_izin', $maxId)->first();
            // $izins = $jenis_izin->toArray();
            // $nib = $jenis_izin['nib'];
            // $nibs = Nib::where('nib', $nib)->first();
            // $nibs = $nibs->toArray();
            $common = new CommonHelper();
            $email = new EmailHelper();

            //penanggungjawab dan kirim email
            // $penanggungjawab = array();
            // $email_data = array();
            // $email_data_koordinator = array();
            // $penanggungjawab = $common->get_pj_nib($nib);
            // $catatan_hasil_evaluasi = '';
            // $datenow = Carbon::now();
            // $date = new DateHelper();
            // $date = $date->dateday_lang_reformat_long($datenow);

            $jenis_penomoran = DB::table('tb_mst_jenis_kode_akses')->where(
                'short_name',
                $id_jeniskodeakses->short_name
            )->first();
            // dd($izins);

            $departemen = [
                // "availno" => $req->availno,
                // "kode_wilayah" => $req->kode_wilayah,
                // "prefix" => $req->prefix,
                "jenis_penomoran" => $jenis_penomoran->full_name,
                "jenis_permohonan" => $jenis_permohonan,
            ];

            // $koreksi_all = '';

            // $email_jenis = 'pemenuhan-syarat';
            // $nama2 = '';
            // $kirim_email = $email->kirim_email(
            //     $penanggungjawab,
            //     $email_jenis,
            //     $izins,
            //     $departemen,
            //     $catatan_hasil_evaluasi,
            //     $nama2,
            //     $nibs,
            //     $koreksi_all
            // );
            //end penganggungjawab

            //get jenis Penomoran

            //

            //kirim email subkoordinator
            $penomoran_query = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses', 't.*', 'v.*')
            ->leftjoin('vw_list_izin as v', 't.id_izin', '=', 'v.id_izin')
            ->where('t.id_izin', '=', $maxId)->with('KodeIzin')->with('KodeAkses');
            // $penomoran_query = $penomoran_query->where('t.status_permohonan', '=', $status_penomoran);

            $penomoran_query = $penomoran_query->first();
            // dd($penomoran_query);

            if (empty($penomoran_query)) {
            return abort(404);
            }

            $penomoran = $penomoran_query->toArray();
            $id_departemen_user = Session::get('id_departemen');
            $koreksi_all = 0;
            session()->flash('message', 'Berhasil Mengirim Evaluasi ke Subkoordinator');

            //get subkoordinator
            $subkoordinator = $common->get_subkoordinator_first($id_departemen_user);
            $jabatan = DB::table('tb_mst_jobposition')->where('id', $subkoordinator->id_mst_jobposition)->first();
            //end get subkoordinator

            $email_jenis = 'evaluasi-evaluator-pj';
            $nama2 = Session::get('nama');
            //end penganggungjawab

            //kirim email subkoordinator
            $user['email'] = isset($subkoordinator->email) ? $subkoordinator->email : '';
            $user['nama'] = $subkoordinator->nama;
            $nama2 = $subkoordinator->nama;
            $email_jenis = 'evaluasi-evaluator';
            $catatan_hasil_evaluasi = $req->catatan_hasil_evaluasi;

            //end mengirim email ke evaluator
            $kirim_email2 = $email->kirim_email2($user, $email_jenis, $penomoran, $departemen, $catatan_hasil_evaluasi,
            $nama2, '', $koreksi_all, $jabatan);
        } else {
            return back()->with('error', 'Gagal Menyimpan Data');
        }

        return redirect('/admin')->with('message', $msg_success);
    }

    public function evaluasiPenomoranSave($id, $id_kodeakses, Request $request)
    {
        // dd($request);
        // dd($request['bloknomor'],$request['id_izin']);
        $common = new CommonHelper();
        $email = new EmailHelper();
        $log = new LogHelper();
        $id_departemen_user = Session::get('id_departemen');

        $id_izin = $request['id_izin'];
        $koreksi_all = 0;
        if ($id_izin != $id) {
            return Redirect::route('admin.evaluator');
        }

        $status_penomoran = 901;

        $penomoran_query = Penomoran::from('tb_trx_kode_akses as t')->select(
            't.id as id_kode_akses',
            't.*',
            'v.*',
            'd.id_disposisi_user'
        )
            ->join('vw_list_izin as v', 't.id_izin', '=', 'v.id_izin')
            ->join('tb_trx_disposisi_evaluator_penomoran as d', 'd.id_izin', '=', 'v.id_izin')
            ->where('d.id_disposisi_user', '=', Session::get('id_user'))
            ->where('t.id', '=', $id_kodeakses)->with('KodeIzin')->with('KodeAkses');
        $penomoran_query = $penomoran_query->where('t.status_permohonan', '=', $status_penomoran);

        $penomoran_query = $penomoran_query->first();


        if (empty($penomoran_query)) {
            return abort(404);
        }

        $penomoran = $penomoran_query->toArray();
        // dd($request);
        $mst_kodeakses = $common->getDetailKodeAkses($penomoran, $penomoran['id_mst_kode_akses']);

        $nib = $penomoran['nib'];
        $nibs = Nib::where('nib', $nib)->first();
        $nibs = $nibs->toArray();

        $id_izin = $penomoran['id_oss_trxizin'];
        $getPenomoran = Penomoran::where('id', '=', $id_kodeakses)->where(
            'status_permohonan',
            '=',
            $status_penomoran
        )->with('KodeIzin')->with('KodeAkses')->first();

        if (empty($getPenomoran)) {
            return abort(404);
        }

        $koreksi_all = 0;
        $data = $request->all();
        // dd($data['no_sk'],$data['tgl_sk']);
        $id_koreksi = array();
        $catatan_koreksi = array();

        $catatan_hasil_evaluasi = $request->get('catatan_hasil_evaluasi');

        //kondisional departemen
        $departemen = $common->getDepartemen($id_departemen_user);
        //end konsidisional departemen
        try {
            DB::beginTransaction();
            $penomoranToSave = $getPenomoran;
            $Izinoss = Izinoss::where('id_izin', '=', $id)->first();
            //set status checklist telah didisposisi


            if ($data['status_sk'] == 0) { //jika ditolak
                $penomoranToSave->status_permohonan = 90;
                if (
                    $penomoran['jenis_permohonan'] == 'Pengembalian Penomoran' || $penomoran['jenis_permohonan'] ==
                    'Perubahan Penetapan'
                ) {
                    $penomoran_alokasi =
                        DB::table('tb_trx_kode_akses_alokasi')->select('*')->where(
                            'id',
                            '=',
                            $penomoran['id_mst_kode_akses']
                        )->update([
                            'status' => 'Aktif'
                        ]);
                } else {
                    $penomoran_alokasi =
                        DB::table('tb_trx_kode_akses_alokasi')->select('*')->where(
                            'id',
                            '=',
                            $penomoran['id_mst_kode_akses']
                        )->update([
                            'status' => 'Idle'
                        ]);
                }
                if ($request['bloknomor']) {
                    foreach ($request->bloknomor as $p) {
                        // dd($request['bloknomor'],$request['id_izin'], $p['bn_kode_wilayah'], $p['bn_prefix_awal']);
                        $update = DB::table('tb_trx_kode_akses_alokasi_bloknomor')->select('*')
                            ->where('id_izin', '=', $request['id_izin'])
                            ->where('kode_wilayah', '=', $p['bn_kode_wilayah'])
                            ->where('prefix_awal', '=', $p['bn_prefix_awal'])
                            ->update([
                                'status' => 'Idle',
                                'status_evaluasi_bloknomor' => $p['is_deleted'],
                                'updated_date' => date('Y-m-d H:i:s'),
                                'updated_by' => Session::get('nama')

                            ]);
                    }
                }
                // $Izinoss->status_checklist = 90;
                $Izinoss->updated_at = date('Y-m-d H:i:s');
                $Izinoss->save();
                $insertIzinLog = $log->createIzinLog($Izinoss, $catatan_hasil_evaluasi);
            } else {

                if ($request['bloknomor']) {
                    foreach ($request->bloknomor as $p) {
                        // dd($request['bloknomor'],$request['id_izin'], $p['bn_kode_wilayah'], $p['bn_prefix_awal']);
                        $update = DB::table('tb_trx_kode_akses_alokasi_bloknomor')->select('*')
                            ->where('id_izin', '=', $request['id_izin'])
                            ->where('kode_wilayah', '=', $p['bn_kode_wilayah'])
                            ->where('prefix_awal', '=', $p['bn_prefix_awal'])
                            ->update([
                                'status_evaluasi_bloknomor' => $p['is_deleted'],
                                'updated_date' => date('Y-m-d H:i:s'),
                                'updated_by' => Session::get('nama')

                            ]);
                    }
                }

                if ($file1 = $request->file('berkas_tambahan')) {
                    // $date_reformat = new DateHelper();

                    $filename1 = "KOMINFO" . time() . '-' . $id . '-' . $id_kodeakses . '.' . $file1->extension();
                    $path1 = $file1->storeAs('public/file_penomoran', $filename1);
                    $name1 = $file1->getClientOriginalName();
                    $path1 = str_replace('public/', 'storage/', $path1);
                    $penomoranToSave->path_dok_evaluasi_tambahan = $path1;
                }

                if (isset($data['is_koreksi_dokumen_1']) && $data['is_koreksi_dokumen_1'] == 'on') {
                    $koreksi_all = 1;
                    $penomoranToSave->is_koreksi_dok_pengguna_penomoran = 1;
                } else {
                    $penomoranToSave->is_koreksi_dok_pengguna_penomoran = 0;
                }
                if (isset($data['is_koreksi_dokumen_2']) && $data['is_koreksi_dokumen_2'] == 'on') {
                    $koreksi_all = 1;
                    $penomoranToSave->is_koreksi_dok_kode_akses_konten = 1;
                } else {
                    $penomoranToSave->is_koreksi_dok_kode_akses_konten = 0;
                }
                if (isset($data['is_koreksi_dokumen_3']) && $data['is_koreksi_dokumen_3'] == 'on') {
                    $koreksi_all = 1;
                    $penomoranToSave->is_koreksi_dok_call_center = 1;
                } else {
                    $penomoranToSave->is_koreksi_dok_call_center = 0;
                }
                if (isset($data['is_koreksi_dokumen_4']) && $data['is_koreksi_dokumen_4'] == 'on') {
                    $koreksi_all = 1;
                    $penomoranToSave->is_koreksi_pe_dok_sk = 1;
                } else {
                    $penomoranToSave->is_koreksi_pe_dok_sk = 0;
                }
                if (isset($data['is_koreksi_dokumen_5']) && $data['is_koreksi_dokumen_5'] == 'on') {
                    $koreksi_all = 1;
                    $penomoranToSave->is_koreksi_pe_dok_perizinan_terakhir = 1;
                } else {
                    $penomoranToSave->is_koreksi_pe_dok_perizinan_terakhir = 0;
                }
                if (isset($data['is_koreksi_dokumen_6']) && $data['is_koreksi_dokumen_6'] == 'on') {
                    $koreksi_all = 1;
                    $penomoranToSave->is_koreksi_pe_pe_dok_pendukung = 1;
                } else {
                    $penomoranToSave->is_koreksi_pe_pe_dok_pendukung = 0;
                }
                if (isset($data['is_koreksi_dokumen_7']) && $data['is_koreksi_dokumen_7'] == 'on') {
                    $koreksi_all = 1;
                    $penomoranToSave->is_koreksi_dok_izin_penyelenggaraan = 1;
                } else {
                    $penomoranToSave->is_koreksi_dok_izin_penyelenggaraan = 0;
                }

                //kondisional jika koreksi
                if ($koreksi_all == 1 || $data['status_sk'] == 0) {
                    // $penomoranToSave->status_permohonan = 90;
                    $penomoranToSave->catatan_dok_pengguna_penomoran = isset($data['catatan_dok_pengguna_penomoran ']) ?
                        $data['catatan_dok_pengguna_penomoran '] : '';
                    $penomoranToSave->catatan_dok_kode_akses_konten = isset($data['catatan_dok_kode_akses_konten']) ?
                        $data['catatan_dok_kode_akses_konten'] : '';
                    $penomoranToSave->catatan_dok_call_center = isset($data['catatan_dok_call_center']) ?
                        $data['catatan_dok_call_center'] : '';
                    $penomoranToSave->catatan_dok_izin_penyelenggaraan = isset($data['catatan_dok_izin_penyelenggaraan']) ?
                        $data['catatan_dok_izin_penyelenggaraan'] : '';
                    $penomoranToSave->catatan_pe_dok_sk = isset($data['catatan_pe_dok_sk']) ? $data['catatan_pe_dok_sk'] : '';
                    $penomoranToSave->catatan_pe_dok_perizinan_terakhir = isset($data['catatan_pe_dok_perizinan_terakhir']) ?
                        $data['catatan_pe_dok_perizinan_terakhir'] : '';
                    $penomoranToSave->catatan_pe_dok_pendukung = isset($data['catatan_pe_dok_pendukung']) ?
                        $data['catatan_pe_dok_pendukung'] : '';
                } else {
                    $penomoranToSave->catatan_dok_pengguna_penomoran = '';
                    $penomoranToSave->catatan_dok_kode_akses_konten = '';
                    $penomoranToSave->catatan_dok_call_center = '';
                    $penomoranToSave->catatan_dok_izin_penyelenggaraan = '';
                    $penomoranToSave->catatan_pe_dok_sk = '';
                    $penomoranToSave->catatan_pe_dok_perizinan_terakhir = '';
                    $penomoranToSave->catatan_pe_dok_pendukung = '';
                    // $penomoranToSave->status_permohonan = 902;
                    if (isset($data['no_sk'])) {
                        $penomoranToSave->pe_no_sk = $data['no_sk'];
                        $penomoranToSave->pe_date_sk = $data['tgl_sk'];
                    }
                }
            }
            $penomoranToSave->catatan_hasil_evaluasi = $catatan_hasil_evaluasi;
            $penomoranToSave->updated_date = date('Y-m-d H:i:s');
            $penomoranToSave->updated_by = Session::get('nama');
            $penomoranToSave->save();

            //Jika ada ada tambahan penetapan

            if ($penomoran['jenis_permohonan'] == 'Pengembalian Penomoran' || $penomoran['jenis_permohonan'] == 'Perubahan
    Penetapan') {
                if ($request['kodeakses_hapus']) {
                    foreach ($request->kodeakses_hapus as $hapus) {
                        // $check_exist = DB::table('tb_trx_kode_akses_alokasi')
                        // ->join('tb_trx_kode_akses', 'tb_trx_kode_akses.id_mst_kode_akses','=','tb_trx_kode_akses_alokasi.id')
                        // ->where('tb_trx_kode_akses_alokasi.kode_akses', '=', $hapus['kode_akses'])
                        // ->where('tb_trx_kode_akses.status_permohonan', '!=','90')
                        // ->where('tb_trx_kode_akses.status_permohonan', '!=','50')
                        // ->where('tb_trx_kode_akses.jenis_permohonan','=','Pengembalian Penomoran')
                        // ->get();
                        // $check_exist_count = $check_exist -> count();
                        // if($check_exist_count>0){
                        // // dd($check_exist);
                        // }
                        // else{
                        $check_kodeakses_ = DB::table('tb_trx_kode_akses_alokasi')
                            ->where('tb_trx_kode_akses_alokasi.kode_akses', '=', $hapus['kode_akses'])
                            ->first();

                        // $check_kodeakses_ = $check_kodeakses_ ->array();
                        if ($hapus['status_pe_sk'] == 1) {
                            $insert_trxkodeakses = new TrxKodeAkses_Additional([
                                'is_active' => 1,
                                'id_permohonan' => $request['id_izin'],
                                'id_izin' => $request['id_izin'],
                                'id_mst_kode_akses' => $check_kodeakses_->id,
                                'status_permohonan' => '302',
                                'jenis_permohonan' => 'Penetapan Penomoran Ulang',
                                'is_active' => 1,
                                'updated_date' => date('Y-m-d H:i:s'),
                                'created_date' => date('Y-m-d H:i:s'),
                                'updated_by' => Session::get('nama'),
                                'created_by' => Session::get('nama')
                            ]);
                        } else {
                            $insert_trxkodeakses = new TrxKodeAkses_Additional([
                                'is_active' => 1,
                                'id_permohonan' => $request['id_izin'],
                                'id_izin' => $request['id_izin'],
                                'id_mst_kode_akses' => $check_kodeakses_->id,
                                'status_permohonan' => '301',
                                'jenis_permohonan' => 'Penetapan Pencabutan',
                                'is_active' => 1,
                                'updated_date' => date('Y-m-d H:i:s'),
                                'created_date' => date('Y-m-d H:i:s'),
                                'updated_by' => Session::get('nama'),
                                'created_by' => Session::get('nama')
                            ]);
                        }

                        $insert_trxkodeakses->save();
                        $penomoran_alokasi = DB::table('tb_trx_kode_akses_alokasi')
                            ->select('*')
                            ->where('id', '=', $check_kodeakses_->id)
                            ->update(['status' => 'DALAM PROSES']);
                        // }
                    }
                }
            }



            //insert log
            $penomoranToLog = Penomoran::where('id', '=', $id_kodeakses)->first()->toArray();
            $insertUloLog = $log->createPenomoranLog($penomoranToLog, $status_penomoran);
            $Izinoss = Izinoss::where('id_izin', '=', $id)->first();
            //set status checklist telah didisposisi
            $insertIzinLog = $log->createIzinLog($Izinoss, $catatan_hasil_evaluasi);

            if ($koreksi_all == 1) {
                // $Izinoss->status_checklist = 90;
            } elseif ($data['status_sk'] == 0) {
                // $Izinoss->status_checklist = 90;
            } else {
                // $Izinoss->status_checklist = 902;
            }
            $Izinoss->updated_at = date('Y-m-d H:i:s');
            $Izinoss->save();
            DB::commit();

            $departemen = [
                "full_kode_akses" => $mst_kodeakses['kode_akses']['kode_akses'],
                "jenis_penomoran" => $mst_kodeakses['kode_akses']['jenis_penomoran'],
                "jenis_permohonan" => $mst_kodeakses['jenis_permohonan'],
            ];

            //penanggungjawab dan kirim email
            // $penanggungjawab = array();
            // $email_data = array();
            // $email_data_subkoordinator = array();
            // $penanggungjawab = $common->get_pj_nib($nib);
            // $evaluator = $common->get_subkoordinator_first($penomoran['id_disposisi_user']);

            // if ($data['status_sk'] == 0 || $koreksi_all == 1) {
            //     session()->flash('message', 'Permohonan Ditolak');
            //     $email_jenis = 'tolak-penomoran-pj';
            //     $nama2 = $evaluator->nama;
            //     $kirim_email = $email->kirim_email(
            //         $penanggungjawab,
            //         $email_jenis,
            //         $penomoran,
            //         $departemen,
            //         $catatan_hasil_evaluasi,
            //         $nama2,
            //         $nibs,
            //         $koreksi_all
            //     );
            // } else {
            //     session()->flash('message', 'Berhasil Mengirim Evaluasi ke Subkoordinator');

            //     //get subkoordinator
            //     $subkoordinator = $common->get_subkoordinator_first($id_departemen_user);
            //     $jabatan = DB::table('tb_mst_jobposition')->where('id', $subkoordinator->id_mst_jobposition)->first();
            //     //end get subkoordinator

            //     $email_jenis = 'evaluasi-evaluator-pj';
            //     $nama2 = $evaluator->nama;
            //     $kirim_email = $email->kirim_email(
            //         $penanggungjawab,
            //         $email_jenis,
            //         $penomoran,
            //         $departemen,
            //         $catatan_hasil_evaluasi,
            //         $nama2,
            //         $nibs,
            //         $koreksi_all
            //     );
            //     //end penganggungjawab

            //     //kirim email subkoordinator
            //     $user['email'] = isset($subkoordinator->email) ? $subkoordinator->email : '';
            //     $user['nama'] = $subkoordinator->nama;
            //     $nama2 = $subkoordinator->nama;
            //     $email_jenis = 'evaluasi-evaluator';
            //     $catatan_hasil_evaluasi = $catatan_hasil_evaluasi;

            //     //end mengirim email ke evaluator
            //     $kirim_email2 = $email->kirim_email2(
            //         $user,
            //         $email_jenis,
            //         $penomoran,
            //         $departemen,
            //         $catatan_hasil_evaluasi,
            //         $nama2,
            //         $nibs,
            //         $koreksi_all,
            //         $jabatan
            //     );
            // }


        } catch (\Exception $e) {
            DB::rollback();
            throw ValidationException::withMessages(['message' => 'Gagal']);
        }

        return Redirect::route('admin.evaluator.penomoran');
        // return Redirect::back();
    }

    public function sendSurvey($id)
    {
        $date_reformat = new DateHelper();
        $common = new CommonHelper();
        $email = new EmailHelper();
        $log = new LogHelper();
        $id_departemen_user = Session::get('id_departemen');
        $userbo = Session::get('nama');
        $status_checklist = 903;
        $izin = Izin::select('*')->where('id_izin', '=', $id)->first();
        $nib = $izin['nib'];
        $nibs = Nib::where('nib', $nib)->first();
        $nibs = $nibs->toArray();
        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);

        $survey = UserSurvey::where("id_izin", $id)->update(["is_active" => 1]);
        $survey = UserSurvey::where("id_izin", $id)->first();

        $kirim_email_survey = $email->kirim_email($penanggungjawab, '', $izin, '', '', '', $nibs, 0, '', $id . '?code=' . $survey->code);

        return Redirect::route('admin.evaluator')->with('message', 'Survey berhasil di kirim');
    }

    // public function evaluasiPenyesuaian($id, Request $request)
    // {
    //     // dd(Auth::user()->name);

    //     $date_reformat = new DateHelper();

    //     $common = new CommonHelper;
    //     $id_departemen_user = Session::get('id_departemen');
    //     $limit_db = Config::get('app.admin.limit');
    //     // $status_checklist = 901;
    //     $izin = Izin::select('*')->where('id_izin', '=', $id)
    //     // ->where('status_checklist', '=', $status_checklist)
    //     // ->orWhere(function($query) {
    //     //     $query->where('status_checklist', 901);
    //     // })
    //     ->first();
    //     // dd($izin);
    //     if ($izin == null) {
    //         return abort(404);
    //     }
    //     $izin = $izin->toArray();
    //     $nib = $izin['nib'];
    //     $kd_izin = $izin['kd_izin'];

    //     $detailNib = Nib::select('*')->where('nib', '=', $nib)->first();
    //     if (empty($detailNib)) {
    //         $detailNib = array();
    //     } else {
    //         $detailNib->toArray();
    //     }

    //     $penyesuaian = DB::table('tb_trx_penyesuaian_komitmen')->where('id_izin', '=', $izin['id_izin'])->first();

    //     $html = array();
    //     // $html = view('users.edit', compact('user'))->render();

    //     $penanggungjawab = array();
    //     $penanggungjawab = $common->get_pj_nib($nib);
    //     $cities = DB::table('tb_mst_kabupaten')->select('id', 'name')->get();
    //     $triger = Session::get('id_mst_jobposition');
    //     // dd($triger);
    //     // die;

    //     return view('layouts.backend.evaluator.evaluasi-penyesuaian', ['date_reformat' => $date_reformat, 'id' => $id, 'cities' => $cities, 'izin' => $izin, 'detailnib' => $detailNib, 'penanggungjawab' => $penanggungjawab, 'triger' => $triger, 'penyesuaian' => $penyesuaian]);
    // }

    public function evaluasiPenyesuaianPost($id, Request $request)
    {
        $common = new CommonHelper();
        $email = new EmailHelper();
        $id_departemen_user = Session::get('id_departemen');
        $id_izin = $request['id_izin'];

        if ($id_izin != $id) {
            return Redirect::route('admin.evaluator');
        }

        if ($id_izin != $id) {
            return Redirect::route('admin.evaluator');
        }

        $izin = Izin::select('*')
            ->where('id_izin', '=', $id_izin)
            ->where('status_penyesuaian', '=', 20)
            ->first();

        if (empty($izin)) {
            return abort(404);
        }

        $izin = $izin->toArray();
        $evaluator = DB::table('tb_trx_disposisi_evaluator_komitmen as a')
            ->join('tb_mst_user_bo as b', 'b.id', '=', 'a.id_disposisi_user')
            // ->where('b.is_accounttesting', '!=', 1)
            ->where('a.id_izin', $izin['id_izin'])
            ->first();
        // dd($evaluator);
        $nib = $izin['nib'];
        $nibs = Nib::where('nib', $nib)->first();
        $nibs = $nibs->toArray();

        $getPenyesuaian = Penyesuaian::where('id_izin', '=', $id_izin)->where('status_penyesuaian', '=', 20)->first();

        if (empty($getPenyesuaian)) {
            return abort(404);
        }

        $catatan_hasil_evaluasi = $request->get('catatan_hasil_evaluasi');

        //get subkoordinator
        $subkoordinator = DB::table('tb_mst_user_bo')->select('id', 'nama', 'email', 'id_mst_jobposition')
            // ->where('tb_mst_user_bo.is_accounttesting', '!=', 1)
        ;

        if ($id_departemen_user == 2) { //jika user jasa dan jaringan
            $subkoordinator = $subkoordinator->where('tb_mst_user_bo.id_mst_jobposition', '=', 2)
                // ->where('tb_mst_user_bo.is_accounttesting', '!=', 1)
            ; //jabatan koordinator jaringan
        } else if ($id_departemen_user == 1) {
            $subkoordinator = $subkoordinator->where('tb_mst_user_bo.id_mst_jobposition', '=', 5)
                // ->where('tb_mst_user_bo.is_accounttesting', '!=', 1)
            ; //jabatan evaluator jasa
        } else if ($id_departemen_user == 3) { //jika user telsus
            $subkoordinator = $subkoordinator->where('tb_mst_user_bo.id_mst_jobposition', '=', 8)
                // ->where('tb_mst_user_bo.is_accounttesting', '!=', 1)
            ; //jabatan evaluator Telsus
        }

        $subkoordinator = $subkoordinator->first();

        $jabatan = DB::table('tb_mst_jobposition')->where('id', $subkoordinator->id_mst_jobposition)->first();
        //end get subkoordinator

        //kondisional departemen
        $departemen = $common->getDepartemen($id_departemen_user);

        $koreksi_all = 0;

        if ($koreksi_all == 1) {
            $email_jenis1 = 'koreksi-pj';
        } else {
            $email_jenis1 = 'evaluasi-evaluator-pj';
        }

        $data = $request->all();

        DB::beginTransaction();
        try {
            $penomoranToSave = $getPenyesuaian;

            if (isset($data['is_koreksi_dokumen']) && $data['is_koreksi_dokumen'] == 'on') {
                $koreksi_all = 1;
                $penomoranToSave->need_correction = 1;
            } else {
                $penomoranToSave->need_correction = 0;
            }

            //kondisional jika koreksi
            if ($koreksi_all == 1) {
                $penomoranToSave->status_penyesuaian = 90;
                $penomoranToSave->correction_note = isset($data['catatan_dokumen']) ? $data['catatan_dokumen'] : '';
            } else {
                $penomoranToSave->correction_note = '';
                $penomoranToSave->status_penyesuaian = 902;
            }

            $penomoranToSave->updated_date = date('Y-m-d H:i:s');
            $penomoranToSave->updated_by = Session::get('nama');
            $penomoranToSave->save();

            DB::commit();
            session()->flash('message', 'Berhasil Evaluasi Penyesuaian Komitmen');

            //penanggungjawab dan kirim email
            $penanggungjawab = array();
            $email_data = array();
            $email_data_subkoordinator = array();
            $penanggungjawab = $common->get_pj_nib($nib);

            $nama2 = $evaluator->nama;
            $kirim_email = $email->kirim_email($penanggungjawab, $email_jenis1, $izin, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, '', '', '', '');
            //end penganggungjawab

            if ($koreksi_all != 1) {
                //kirim email subkoordinator
                $user['email'] = isset($subkoordinator->email) ? $subkoordinator->email : '';
                $user['nama'] = $subkoordinator->nama;
                $nama2 = $evaluator->nama;
                $email_jenis = 'evaluasi-evaluator';
                $catatan_hasil_evaluasi = $catatan_hasil_evaluasi;

                //end mengirim email ke evaluator
                $kirim_email2 = $email->kirim_email2($user, $email_jenis, $izin, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, $jabatan);
            }
        } catch (\Exception $e) {
            DB::rollback();
            // throw ValidationException::withMessages(['message' => 'Gagal']);
            session()->flash('message', 'Evaluasi gagal di prosess');
            return Redirect::route('admin.evaluator');
        }

        return Redirect::route('admin.evaluator')->with('message', 'Evaluasi berhasil di prosess');
    }

    public function evaluasiPenyesuaian($id, Request $request)
    {
        // dd(Auth::user()->name);

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
                    $map_izin[$key]->form_isian = $value2->filled_document;
                    $map_izin[$key]->nama_asli = $value2->nama_file_asli;
                    $map_izin[$key]->need_correction = $value2->need_correction;
                    $map_izin[$key]->correction_note = $value2->correction_note;
                }
            }
        }

        $map_izin_perubahan = $common->get_map_izin($id_mst_izinlayanan);
        $filled_perubahan = DB::table('tb_trx_persyaratan_komitmen')->where('id_izin', $id)->get()->toArray();

        foreach ($map_izin_perubahan as $key => $value) {
            // echo $value->persyaratan;
            // echo "<br>=============<br>";
            $map_izin_perubahan[$key] = $value;
            foreach ($filled_perubahan as $key2 => $value2) {
                if ($value->id == $value2->id_map_listpersyaratan) {
                    // echo $value->persyaratan;
                    // echo "<br>=============<br>";
                    // echo $value2->filled_document;
                    // echo "<br>******************<br>";
                    $map_izin_perubahan[$key]->form_isian = $value2->filled_document;
                    $map_izin_perubahan[$key]->nama_asli = $value2->nama_file_asli;
                    $map_izin_perubahan[$key]->need_correction = $value2->need_correction;
                    $map_izin_perubahan[$key]->correction_note = $value2->correction_note;
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

        return view('layouts.backend.evaluator.evaluasi-penyesuaian', ['date_reformat' => $date_reformat, 'id' => $id, 'cities' => $cities, 'izin' => $izin, 'detailnib' => $detailNib, 'penanggungjawab' => $penanggungjawab, 'map_izin' => $map_izin, 'filled_persyaratan' => $filled_persyaratan, 'triger' => $triger, 'penyesuaian' => $penyesuaian, 'component' => $component, 'map_izin_perubahan' => $map_izin_perubahan]);
    }
}