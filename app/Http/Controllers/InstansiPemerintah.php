<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Nib;
use App\Models\RegisterIP;
use App\Models\reqPelakuUsaha;
use Illuminate\Http\Request;
use Carbon\Carbon;


use App\Helpers\CommonHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Penanggungjawab;


class InstansiPemerintah extends Controller
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

    public function registerpt()
    {
        $oss = DB::table('vw_nib_detail')->select("*")->where(['oss_id' => Auth::user()->oss_id])->first();
        // dd($oss);
        return view('layouts.frontend.instansipemerintah.registerpt', compact(['oss']));
    }

    public function registerptPost(Request $req)
    {
        // dd($req);
        $prov =  DB::table('tb_mst_provinsi')->select('id', 'name')->where(['id' => $req->vProvinsi])->first();
        $kab =  DB::table('tb_mst_kabupaten')->select('id', 'name')->where(['id' => $req->vKotaKabupaten])->first();
        $kec =  DB::table('tb_mst_kecamatan')->select('id', 'name')->where(['id' => $req->vKecamatan])->first();
        $kel =  DB::table('tb_mst_kelurahan')->select('id', 'name')->where(['id' => $req->vKelurahan])->first();
        $alamat = $req->vAlamat . ", Kel." . $kel->name . ", Kec." . $kec->name . ", Kab/Kota." . $kab->name . ", Prov." . $prov->name . " " . $req->vKodePos;
        // dd($req->all());
        
        $updateNib = Nib::where('id', $req->vKey)
            ->update([
                // 'status_badan_hukum' => '02',
                'jenis_pelaku_usaha' => '11',
                'npwp_perseroan' => $req->vNpwp,
                'nama_perseroan' => $req->vNamaPerusahaan,
                'jenis_perseroan' => $req->vJenisInstansi,
                'alamat_perseroan' => $req->vAlamat,
                'kelurahan_perseroan' => $kel->name,
                'perseroan_daerah_id' => $req->vKelurahan,
                'kode_pos_perseroan' => $req->vKodePos,
                'nomor_telpon_perseroan' => $req->vNoTlp,
                'email_perusahaan' => Auth::user()->email,
                'no_pengesahan' => $req->vAktaTerakhir,
                'status_nib' => '02',
                'updated_by' => Auth::user()->name
            ]);
            $check_evaluasi = Penanggungjawab::where('nib', Auth::user()->nib[0]->nib)->first();
            if (isset($check_evaluasi)) {
                $update_evaluasi = Penanggungjawab::where('nib', Auth::user()->nib[0]->nib)
                ->update([
                'status_evaluasi' => 0
                ]);
            }
        

        if ($file = $req->file('vDokumenNib')) {
            $filename = "NIB-" . time() . '.' . $file->extension();
            $path = $file->storeAs('public/registerip', $filename);
            $name = $file->getClientOriginalName();
            $path = str_replace('public/', 'storage/', $path);
        } else {
            $path = '';
        }

        if ($file2 = $req->file('vUploadNpwp')) {
            $filename2 = "NPWP-" . time() . '.' . $file2->extension();
            $path2 = $file2->storeAs('public/registerip', $filename2);
            $name2 = $file2->getClientOriginalName();
            $path2 = str_replace('public/', 'storage/', $path2);
        }
        if ($file3 = $req->file('vUngahSk')) {
            $filename3 = "SK-" . time() . '.' . $file3->extension();
            $path3 = $file3->storeAs('public/registerip', $filename3);
            $name3 = $file3->getClientOriginalName();
            $path3 = str_replace('public/', 'storage/', $path3);
        }

        $cek_table =  DB::table('tb_trx_regisip')->where(['id_inb' => $req->vNib])->first();

        if (isset($cek_table)) {
            $update = RegisterIP::where('id_inb', $req->vNib)
                ->update([
                    'path_berkas_nib' => isset($path) ? $path : '',
                    'path_berkas_npwp' => $path2,
                    'path_berkas_kemenkumham' => $path3,
                    'provinsi' => $req->vProvinsi,
                    'kabupaten' => $req->vKotaKabupaten,
                    'kecamatan' => $req->vKecamatan,
                    'kelurahan' => $req->vKelurahan,
                    'kode_pos' => $req->vKodePos,
                    'alamat' => $req->vAlamat,
                    'is_active' => 1,
                    'updated_by' => Auth::user()->name
                ]);
            if ($update) {
                return redirect('/')->with('message', 'Kelengkapan berkas berhasil di ubah.');
            } else {
                return redirect('/')->with('message', 'Kelengkapan berkas gagal di ubah.');
            }
        } else {
            $insert = new RegisterIP([
                'id_inb' => $req->vNib,
                'path_berkas_nib' => isset($path) ? $path : '',
                'path_berkas_npwp' => $path2,
                'path_berkas_kemenkumham' => $path3,
                'provinsi' => $req->vProvinsi,
                'kabupaten' => $req->vKotaKabupaten,
                'kecamatan' => $req->vKecamatan,
                'kelurahan' => $req->vKelurahan,
                'kode_pos' => $req->vKodePos,
                'alamat' => $req->vAlamat,
                'is_active' => 1,
                'created_by' => Auth::user()->name,
            ]);
            if ($insert->save()) {
                return redirect('/')->with('message', 'Kelengkapan berkas berhasil di tambah.');
            } else {
                return redirect('/')->with('message', 'Kelengkapan berkas gagal di tambah.');
            }
        }
    }

    public function registerpj()
    {
        // dd(Auth::user()->oss_id);
        $oss = DB::table('vw_pj_detail')->select("*")->where(['oss_id' => Auth::user()->oss_id])->first();
        // dd(Auth::user()->oss_id);
        // $user_post = DB::table('users')->select("*")->where(['oss_id' => Auth::user()->oss_id])->first();
        // dd($user_post);
        return view('layouts.frontend.instansipemerintah.registerpj', compact(['oss']));
        // dd($oss);
    }

    public function registerpjPost(Request $req)
    {

        // dd(Auth::user()->nib[0]->nib );
        // dd(Auth::user()->nib[0]->nib );

        $prov =  DB::table('tb_mst_provinsi')->select('id', 'name')->where(['id' => $req->vProvinsi])->first();
        $kab =  DB::table('tb_mst_kabupaten')->select('id', 'name')->where(['id' => $req->vKotaKabupaten])->first();
        $kec =  DB::table('tb_mst_kecamatan')->select('id', 'name')->where(['id' => $req->vKecamatan])->first();
        $kel =  DB::table('tb_mst_kelurahan')->select('id', 'name')->where(['id' => $req->vKelurahan])->first();
        $alamat = $req->vAlamat . ", Kel." . $kel->name . ", Kec." . $kec->name . ", Kab/Kota." . $kab->name . ", Prov." . $prov->name . " " . $req->vKodePos;

        if ($file = $req->file('vSuratTugas')) {
            $filename = "SURAT TUGAS-" . time() . '.' . $file->extension();
            $path = $file->storeAs('public/registerip/useross', $filename);
            $name = $file->getClientOriginalName();
            $path = str_replace('public/', 'storage/', $path);
        }

        if ($ktp = $req->file('vBerkasKtp')) {
            $namektp = "KTP-" . time() . '.' . $ktp->extension();
            $pathktp = $ktp->storeAs('public/registerip/useross', $namektp);
            $nameOrKtp = $file->getClientOriginalName();
            $pathktp = str_replace('public/', 'storage/', $pathktp);
        }

        if ($kartupegawai = $req->file('vKartuPegawai')) {
            $nameekatrupegawai = "Kepegawaian-" . time() . '.' . $kartupegawai->extension();
            $patkartu = $kartupegawai->storeAs('public/registerip/useross', $nameekatrupegawai);
            $nameOrKartu = $file->getClientOriginalName();
            $patkartu = str_replace('public/', 'storage/', $patkartu);
        }
        $cek_table = Penanggungjawab::where('nib', Auth::user()->nib[0]->nib)->first();
        // dd($req->vNib);
        if (isset($cek_table)) {
            $update = Penanggungjawab::where('nib', Auth::user()->nib[0]->nib)
                ->update([
                    'nib' => Auth::user()->nib[0]->nib,
                    'jenis_id_user_proses' => $req->vJenisUser,
                    'no_id_user_proses' => Auth::user()->id,
                    'nama_user_proses' => $req->vNamaPj,
                    'email_user_proses' => Auth::user()->email,
                    'hp_user_proses' => $req->vNoPj,
                    'file_surat_tugas' => $path,
                    'no_ktp' => $req->vKtpPj,
                    'file_ktp' => $pathktp,
                    'jabatan' => $req->vJabatan,
                    'file_kartu_pegawai' => $patkartu,
                    'alamat_user_proses' => $req->vAlamat,
                    'id_provinsi' => $req->vProvinsi,
                    'id_kota' => $req->vKotaKabupaten,
                    'id_kecamatan' => $req->vKecamatan,
                    'id_kelurahan' => $req->vKelurahan,
                    'kode_pos' => $req->vKodePos,
                    'status_evaluasi' => 0
                ]);
                $checkNib = Nib::where('nib','=', Auth::user()->nib[0]->nib)
                    ->where('status_nib','=','07')->first();
                    if (isset($checkNIB)) {
                        $updateNib = Nib::where('nib','=', Auth::user()->nib[0]->nib)
                            ->where('status_nib','=','07')
                            ->update([
                                'status_nib' => '02',
                                'updated_by' => Auth::user()->name
                            ]);
                    }
            // dd($update);
            if ($update) {
                return redirect('/')->with('message', 'Kelengkapan Data Penanggung Jawab berhasil di ubah.');
            } else {
                return redirect('/')->with('message', 'Kelengkapan Data Penanggung Jawab gagal di ubah.');
            }
        } else {
            $updateUserOss = new Penanggungjawab([
                $cek_table = Penanggungjawab::where('nib', Auth::user()->nib[0]->nib)->first()
            ]);
            // dd($req->vNib);
            if (isset($cek_table)) {
                $update = Penanggungjawab::where('nib', Auth::user()->nib[0]->nib)
                    ->update([
                        'nib' => Auth::user()->nib[0]->nib,
                        'jenis_id_user_proses' => $req->vJenisUser,
                        'no_id_user_proses' => Auth::user()->id,
                        'nama_user_proses' => $req->vNamaPj,
                        'email_user_proses' => Auth::user()->email,
                        'hp_user_proses' => $req->vNoPj,
                        'file_surat_tugas' => $path,
                        'no_ktp' => $req->vKtpPj,
                        'file_ktp' => $pathktp,
                        'jabatan' => $req->vJabatan,
                        'file_kartu_pegawai' => $patkartu,
                        'alamat_user_proses' => $req->vAlamat,
                        'id_provinsi' => $req->vProvinsi,
                        'id_kota' => $req->vKotaKabupaten,
                        'id_kecamatan' => $req->vKecamatan,
                        'id_kelurahan' => $req->vKelurahan,
                        'kode_pos' => $req->vKodePos,
                        'status_evaluasi' => 0
                    ]);
                $checkNib = Nib::where('nib','=', Auth::user()->nib[0]->nib)
                    ->where('status_nib','=','07')->first();
                    if (isset($checkNIB)) {
                        $updateNib = Nib::where('nib','=', Auth::user()->nib[0]->nib)
                            ->where('status_nib','=','07')
                            ->update([
                                'status_nib' => '02',
                                'updated_by' => Auth::user()->name
                            ]);
                    }
                // dd($update);
                if ($update) {
                    return redirect('/')->with('message', 'Kelengkapan Data Penanggung Jawab berhasil di ubah.');
                } else {
                    return redirect('/')->with('message', 'Kelengkapan Data Penanggung Jawab gagal di ubah.');
                }
            } else {
                $updateUserOss = new Penanggungjawab([
                    'nib' => Auth::user()->nib[0]->nib,
                    'jenis_id_user_proses' => $req->vJenisUser,
                    'no_id_user_proses' => Auth::user()->id,
                    'nama_user_proses' => $req->vNamaPj,
                    'email_user_proses' => Auth::user()->email,
                    'hp_user_proses' => $req->vNoPj,
                    'file_surat_tugas' => $path,
                    'no_ktp' => $req->vKtpPj,
                    'file_ktp' => $pathktp,
                    'jabatan' => $req->vJabatan,
                    'file_kartu_pegawai' => $patkartu,
                    'alamat_user_proses' => $req->vAlamat,
                    'id_provinsi' => $req->vProvinsi,
                    'id_kota' => $req->vKotaKabupaten,
                    'id_kecamatan' => $req->vKecamatan,
                    'id_kelurahan' => $req->vKelurahan,
                    'kode_pos' => $req->vKodePos,
                    'status_evaluasi' => 0
                ]);
                
                $checkNib = Nib::where('nib','=', Auth::user()->nib[0]->nib)
                    ->where('status_nib','=','07')->first();
                    if (isset($checkNIB)) {
                        $updateNib = Nib::where('nib','=', Auth::user()->nib[0]->nib)
                            ->where('status_nib','=','07')
                            ->update([
                                'status_nib' => '02',
                                'updated_by' => Auth::user()->name
                            ]);
                    }
                if ($updateUserOss->save()) {
                    return redirect('/')->with('message', 'Kelengkapan Data Penanggung Jawab telah Berhasil Diperbaharui.');
                } else {
                    return redirect('/')->with('message', 'Kelengkapan Data Penanggung Jawab Gagal Diperbaharui.');
                }
            }
        }
    }

    // API ALAMAT

    function getKabupaten(Request $req)
    {
        $getKabupaten = DB::table('tb_mst_kabupaten')->select('id', 'name')->where(['id_mst_provinsi' => $req->provinsi])->get();
        if ($getKabupaten) {
            return response()->json([
                'pesan' => 'Suksess',
                'data' => $getKabupaten,
            ]);
        } else {
            return response()->json([
                'pesan' => 'Error'
            ]);
        }
    }
    function getKecamatan(Request $req)
    {
        $getKecamatan = DB::table('tb_mst_kecamatan')->select('id', 'name')->where(['id_mst_kabupaten' => $req->kabupaten])->get();
        if ($getKecamatan) {
            return response()->json([
                'pesan' => 'Suksess',
                'data' => $getKecamatan,
            ]);
        } else {
            return response()->json([
                'pesan' => 'Error'
            ]);
        }
    }
    function getKelurahan(Request $req)
    {
        $getKelurahan = DB::table('tb_mst_kelurahan')->select('id', 'name')->where(['id_mst_kecamatan' => $req->kecamatan])->get();
        if ($getKelurahan) {
            return response()->json([
                'pesan' => 'Suksess',
                'data' => $getKelurahan,
            ]);
        } else {
            return response()->json([
                'pesan' => 'Error'
            ]);
        }
    }

    public function updateemail(Request $req){
        $common = new CommonHelper;
        $detailNib = Nib::select('*')->where('oss_id', '=', Auth::user()->oss_id)->first();
        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($detailNib['nib']);
        $isupdateemail = true;
        return view('layouts.frontend.updateemailnib',['detailNib'=> $detailNib,'penanggungjawab'=> $penanggungjawab,'isupdateemail'=> $isupdateemail]);
    }

    public function updatenib(Request $req){
        $common = new CommonHelper;
        $detailNib = Nib::select('*')->where('oss_id', '=', Auth::user()->oss_id)->first();
        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($detailNib['nib']);
        $isupdatenib = true;
        return view('layouts.frontend.updateemailnib',['detailNib'=> $detailNib,'penanggungjawab'=> $penanggungjawab,'isupdatenib'=> $isupdatenib]);
    }

    public function updateemailnibpost(Request $req){
        // dd($req);

        try {
            DB::beginTransaction();
                if ($file = $req->file('surat_permohonan_NIB')) {
                    $filename = "PermohonanPerubahanAkun-" . time() . '.' . $file->extension();
                    $path = $file->storeAs('public/registerip/useross', $filename);
                    $name = $file->getClientOriginalName();
                    $path = str_replace('public/', 'storage/', $path);
                }
                if (isset($req['email-update'])) {
                    $count_email_req = DB::table('tb_trx_req_ip')->where('oss_id','=',Auth::user()->oss_id)
                    ->where('type','=','Perubahan Email Akun')->where('status','=','0')->count();
                    if($count_email_req>0){
                        
                        return redirect('/')->with('message', 'Mohon maaf Permohonan Anda tidak bisa diajukan, mohon menunggu proses verifikasi atas permohonan sebelumnya.');
                    }
                    // dd($req['email-update'], $path, Auth::user()->oss_id, $req->all());
                    $insertcatatan = reqPelakuUsaha::create([
                        'oss_id' => Auth::user()->oss_id,
                        'type' => 'Perubahan Email Akun',
                        'req_letter' => $path,
                        'req_date' => Carbon::now(),
                        'prev_data' => $req['prev_email-update'],
                        'updated_data' => $req['email-update'],
                        'status' => 0,
                        'submitted_date' => Carbon::now(),
                        'created_by' => Auth::user()->name,
                        'created_date' => Carbon::now()
                    ]);
                }
                if (isset($req['nib-update'])) {
                    $count_email_req = DB::table('tb_trx_req_ip')->where('oss_id','=',Auth::user()->oss_id)
                    ->where('type','=','Perubahan NIB Akun')->where('status','=','0')->count();
                    if($count_email_req>0){
                        
                        return redirect('/')->with('message', 'Mohon maaf Permohonan Anda tidak bisa diajukan, mohon menunggu proses verifikasi atas permohonan sebelumnya.');
                    }
                    $insertcatatan = reqPelakuUsaha::create([
                        'oss_id' => Auth::user()->oss_id,
                        'type' => 'Perubahan NIB Akun',
                        'req_letter' => $path,
                        'req_date' => Carbon::now(),
                        'prev_data' => $req['prev_nib-update'],
                        'updated_data' => $req['nib-update'],
                        'status' => 0,
                        'submitted_date' => Carbon::now(),
                        'created_by' => Auth::user()->name,
                        'created_date' => Carbon::now()
                    ]);
                }
                $updateNib = Nib::where('nib','=', Auth::user()->nib[0]->nib)
                            ->update([
                                'status_nib' => '02',
                                'updated_by' => Auth::user()->name
                            ]);
                $updateUserOss = Penanggungjawab::where('nib','=', Auth::user()->nib[0]->nib)
                            ->update([
                                'status_evaluasi' => '0',
                                'updated_by' => Auth::user()->name
                            ]);
            DB::commit();
            return redirect('/')->with('message', 'Permohonan Anda sudah kami terima, mohon menunggu proses verifiikasi 3 Hari Kerja.');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('/')->with('message', 'Permohonan Anda tidak berhasil diajukan, Silahkan ajukan kembali.');
        }
    }
}