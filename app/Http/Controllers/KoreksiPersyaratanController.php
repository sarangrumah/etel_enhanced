<?php

namespace App\Http\Controllers;

use Session;
use Carbon\Carbon;
use App\Models\Nib;
use App\Models\User;

use App\Models\Proyek;
use App\Models\MstIzin;
use App\Models\Izin_oss;
use App\Models\Viewizin;
use App\Models\DetailNIB;
use App\Models\MstUserBo;
use App\Models\Admin\Izin;
use App\Helpers\DateHelper;
use App\Helpers\EmailHelper;
use Illuminate\Http\Request;
use App\Helpers\CommonHelper;
use App\Models\Admin\Izinlog;

use App\Models\Admin\Izinoss;
use App\Models\MstIzinSyarat;
use App\Helpers\UtilPerizinan;

use App\Mail\Persyaratan\Pemohon;
use App\Models\TrxPemenuhanSyarat;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Persyaratan\Koordinator;
use Symfony\Component\Mime\Header\DateHeader;
use Illuminate\Support\Facades\Redirect;
class KoreksiPersyaratanController extends Controller
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

    public function index(Request $req)
    {
        $utilizin = new UtilPerizinan();
        $izin = $utilizin->getIzinkoreksisyarat(strtoupper($req->izin), 'where');
        // dd($izin);
        $kategori = MstIzin::where('name', strtoupper($req->izin))->first();
        $tipe = $req->izin;
        $date_reformat = new DateHelper();

        return view('koreksisyarat.index', compact('tipe', 'izin', 'kategori', 'date_reformat'));
    }

    public function formpersyaratan(Request $req)
    {
        $id_izin = $req->id;
        $izin = Izinoss::where('id_izin', $req->id)->first();
        // dd( $izin->kd_izin);
        // $datasyarat = MstIzinSyarat::where('kib', $izin->kd_izin)->orderBy('urutan')->get();

        // $datasyaratpdf = DB::table('tb_map_listpersyaratan as a')->select('a.is_mandatory', 'b.persyaratan', 'b.file_type', 'b.desc', 'b.download_link')
        //     ->join('tb_mst_listpersyaratan as b', 'b.id', '=', 'a.id_mst_listpersyaratan')
        //     ->join('tb_mst_izinlayanan as c', 'c.id', '=', 'a.id_mst_izinlayanan')
        //     ->where('a.is_active', '=', '1')
        //     ->where('b.file_type', '=', 'pdf')
        //     ->where('c.kode_izin', '=', $izin->kd_izin)
        //     ->get();


        // $datasyaratpdf = DB::table('tb_map_listpersyaratan as a')->select('a.is_mandatory', 'a.component_name', 'a.id as id_maplist', 'd.is_active', 'b.persyaratan', 'b.persyaratan_html', 'b.file_type', 'b.desc', 'a.download_link', 'b.group_by', 'c.kode_izin', 'd.need_correction', 'd.nama_file_asli', 'd.correction_note', 'd.filled_document')
        //     ->join('tb_mst_listpersyaratan as b', 'b.id', '=', 'a.id_mst_listpersyaratan')
        //     ->join('tb_mst_izinlayanan as c', 'c.id', '=', 'a.id_mst_izinlayanan')
        //     ->leftjoin('tb_trx_persyaratan as d', 'd.id_map_listpersyaratan', '=', 'a.id')
        //     ->where('a.is_active', '=', '1')
        //     // ->where('b.file_type', '=', 'pdf')
        //     ->where('c.kode_izin', '=', $izin->kd_izin)
        //     ->where('d.id_trx_izin', '=', $izin->id_izin)
        //     ->orderBy('b.order_group', 'asc')
        //     ->orderBy('a.order_no', 'asc')
        //     ->get();
        $datasyaratpdf = DB::table('vw_persyaratan_izin as a')->select('a.*', 'd.need_correction', 'd.nama_file_asli', 'd.correction_note', 'd.filled_document')
        ->leftjoin('tb_trx_persyaratan as d', 
        function($join)
                         {
                             $join->on('d.id_map_listpersyaratan', '=', 'a.id_maplist');
                             $join->on('d.id_trx_izin','=','a.id_izin');
                         })
        ->where('a.id_izin', '=', $izin->id_izin)
        ->orderBy('a.order_group', 'asc')
        ->orderBy('a.order_no', 'asc')
        ->get();
        // dd($datasyaratpdf);
        $datasyarattable = DB::table('tb_map_listpersyaratan as a')->select('b.persyaratan', 'b.persyaratan', 'b.file_type', 'b.desc', 'a.download_link')
            ->join('tb_mst_listpersyaratan as b', 'b.id', '=', 'a.id_mst_listpersyaratan')
            ->join('tb_mst_izinlayanan as c', 'c.id', '=', 'a.id_mst_izinlayanan')
            ->join('tb_trx_persyaratan as d', 'd.id_map_listpersyaratan', '=', 'a.id')
            ->where('a.is_active', '=', '1')
            ->where('b.file_type', '=', 'table')
            ->where('c.kode_izin', '=', $izin->kd_izin)
            ->where('d.id_trx_izin', '=', $izin->id_izin)
            ->orderBy('b.order_group', 'asc')
            ->orderBy('a.order_no', 'asc')
            ->get();
        // dd($datasyaratpdf); 



        $common = new CommonHelper();
        $detailNib = $common->get_detail_nib_by_oss($izin->oss_id);
        // dd($detailNib);

        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($detailNib->nib);
        // dd($penanggungjawab);

        $utilizin = new UtilPerizinan();
        $izin2 = array();
        $izin2 = $utilizin->getizinBtidIzin(strtoupper($izin->id_izin));

        $map_izin = array();
        $filled_persyaratan = array();

        // dd($ulo['kode_izin']);   


        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=', $izin->kd_izin)->first();
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
        return view('koreksisyarat.persyaratan', compact('id_izin', 'izin', 'izin2', 'detailNib', 'penanggungjawab', 'datasyarattable', 'datasyaratpdf', 'map_izin'));
    }
    public function downloadlampiran(Request $req)
    {
        $datasyarat = MstIzinSyarat::find($req->id);
        // dd($datasyarat->file_lampiran);
        return response()->download(storage_path('app/lampiran/' . $datasyarat->file_lampiran));
    }

    public function submitpersyaratan(Request $req)
    {
        // dd($req->all());
        DB::beginTransaction();
        // try {
            $update = array();
        if ($req->hasfile('syarat')) {
            foreach ($req->file('syarat') as $key => $file) {
                $filename = "KOMINFO-" . time() . $key . '.' . $file->extension();
                $path = $file->storeAs('public/file_syarat', $filename);
                $name = $file->getClientOriginalName();
                $path = str_replace('public/', 'storage/', $path);
                // dd($req);
                $item = DB::table('tb_trx_persyaratan')->select('id')->where('id_map_listpersyaratan', '=', $req->id_maplist[$key])->where('id_trx_izin', '=', $req->id_izin)->first();
                $update = array(
                    'id_trx_izin' => $req->id_izin,
                    'id_map_listpersyaratan' => $req->id_maplist[$key],
                    'filled_document' => $path,
                    'need_correction' => null,
                    // 'correction_note' => '',
                    // 'nama_file_asli' => $file->getClientOriginalName(),
                    'nama_file_asli' => $filename,
                    'updated_by' => Auth::user()->id,
                );
                if (isset($item->id)){
                    $fileupdate = DB::table('tb_trx_persyaratan')->where('id', $item->id)->update($update);
                }
                else{
                    $fileUpload = DB::table('tb_trx_persyaratan')->insert($update);
                }
                
            }
        }

        if (isset($req->cakupanwilayahtelsus_skrd)) {
            // dd($req->cakupanwilayahtelsus_skrd);
            $updateSkrd = [
                'id_trx_izin' => $req->id_izin,
                'id_map_listpersyaratan' => $req->id_maplist_cakupanwilayahtelsus_skrd,
                'filled_document' => json_encode($req->cakupanwilayahtelsus_skrd),
                'nama_file_asli' => null,
                'need_correction' => null,
                // 'correction_note' => '',
                'updated_by' => Auth::user()->id,
                'is_active' => '1'
            ];
            $skrd = DB::table('tb_trx_persyaratan')
                ->where('id_trx_izin', '=', $req->id_izin)
                ->where('id_map_listpersyaratan', '=', $req->id_maplist_cakupanwilayahtelsus_skrd)
                ->update($updateSkrd);
        }

        if (isset($req->cakupanwilayahtelsus_mtk)) {
            $updateMtk = [
                'id_trx_izin' => $req->id_izin,
                'id_map_listpersyaratan' => $req->id_maplist_cakupanwilayahtelsus_mtk,
                'filled_document' => json_encode($req->cakupanwilayahtelsus_mtk),
                'nama_file_asli' => null,
                'need_correction' => null,
                // 'correction_note' => '',
                'updated_by' => Auth::user()->id,
                'is_active' => '1'
            ];
            // dd($updateMtk);
            $mtk = DB::table('tb_trx_persyaratan')
                ->where('id_trx_izin', '=', $req->id_izin)
                ->where('id_map_listpersyaratan', '=', $req->id_maplist_cakupanwilayahtelsus_mtk)
                ->update($updateMtk);
        }

        if (isset($req->cakupanwilayahtelsus_skrk)) {
            $updateSkrk = [
                'id_trx_izin' => $req->id_izin,
                'id_map_listpersyaratan' => $req->id_maplist_cakupanwilayahtelsus_skrk,
                'filled_document' => json_encode($req->cakupanwilayahtelsus_skrk),
                'nama_file_asli' => null,
                'need_correction' => null,
                // 'correction_note' => '',
                'updated_by' => Auth::user()->id,
                'is_active' => '1'
            ];
            $skrk = DB::table('tb_trx_persyaratan')
                ->select('id')
                ->where('id_map_listpersyaratan', '=', $req->id_maplist_cakupanwilayahtelsus_skrk)
                ->where('id_trx_izin', '=', $req->id_izin)
                ->update($updateSkrk);
        }

        if (isset($req->cakupanwilayahtelsus_skrt)) {
            $updateSkrt = [
                'id_trx_izin' => $req->id_izin,
                'id_map_listpersyaratan' => $req->id_maplist_cakupanwilayahtelsus_skrt,
                'filled_document' => json_encode($req->cakupanwilayahtelsus_skrt),
                'nama_file_asli' => null,
                'need_correction' => null,
                // 'correction_note' => '',
                'updated_by' => Auth::user()->id,
                'is_active' => '1'
            ];
            $skrt = DB::table('tb_trx_persyaratan')
                ->select('id')->where('id_map_listpersyaratan', '=', $req->id_maplist_cakupanwilayahtelsus_skrt)
                ->where('id_trx_izin', '=', $req->id_izin)
                ->update($updateSkrt);
        }

        if (isset($req->cakupanwilayahtelsus_sks)) {
            $updateSks = [
                'id_trx_izin' => $req->id_izin,
                'id_map_listpersyaratan' => $req->id_maplist_cakupanwilayahtelsus_sks,
                'filled_document' => json_encode($req->cakupanwilayahtelsus_sks),
                'nama_file_asli' => null,
                'need_correction' => null,
                // 'correction_note' => '',
                'updated_by' => Auth::user()->id,
                'is_active' => '1'
            ];
            $sks = DB::table('tb_trx_persyaratan')
                ->select('id')->where('id_map_listpersyaratan', '=', $req->id_maplist_cakupanwilayahtelsus_sks)
                ->where('id_trx_izin', '=', $req->id_izin)
                ->update($updateSks);
        }

        // $fileUpload = DB::table('tb_trx_persyaratan')->insert($insert);
        $jenis_izin = Izin::where('id_izin', $req->id_izin)->first();
        $jenis_izin = $jenis_izin->nama_master_izin;
        $datenow = Carbon::now();
        $izin = Izin_oss::where('id_izin', $req->id_izin)
            ->update(['status_checklist' => '44','corrected_at'=> $datenow]);

        
        if (isset($req->rencanausaha)) {
            $updateRencanaUsaha = [
                'id_trx_izin' => $req->id_izin,
                'id_map_listpersyaratan' => $req->id_maplist_rencanausaha,
                'filled_document' => json_encode($req->rencanausaha),
                'nama_file_asli' => null,
                'need_correction' => null,
                // 'correction_note' => '',
                'updated_by' => Auth::user()->id,
                'is_active' => '1'
            ];
            $mtk = DB::table('tb_trx_persyaratan')
                ->select('id')
                ->where('id_map_listpersyaratan', '=', $req->id_maplist_rencanausaha)
                ->where('id_trx_izin', '=', $req->id_izin)
                ->update($updateRencanaUsaha);
        }
        
        if (isset($req->daftar_perangkat)) {
            foreach ($req->daftar_perangkat as $key => $file) {
                // dd($req->daftar_perangkat[$key]['lokasi_perangkat']);
                if (isset($req->daftar_perangkat[$key]['isdeleted_perangkat'])) {
                    $updateDaftarPerangkat[$key]['isdeleted_perangkat'] =
                        $req->daftar_perangkat[$key]['isdeleted_perangkat'];
                }

                $updateDaftarPerangkat[$key]['lokasi_perangkat'] = $req->daftar_perangkat[$key]['lokasi_perangkat'];
                $updateDaftarPerangkat[$key]['jenis_perangkat'] = $req->daftar_perangkat[$key]['jenis_perangkat'];
                $updateDaftarPerangkat[$key]['merk_perangkat'] = $req->daftar_perangkat[$key]['merk_perangkat'];
                $updateDaftarPerangkat[$key]['sn_perangkat'] = $req->daftar_perangkat[$key]['sn_perangkat'];
                $updateDaftarPerangkat[$key]['tipe_perangkat'] = $req->daftar_perangkat[$key]['tipe_perangkat'];
                $updateDaftarPerangkat[$key]['buatan_perangkat'] = $req->daftar_perangkat[$key]['buatan_perangkat'];
                if (isset($req->daftar_perangkat[$key]['sertifikat_perangkat'])) {
                    $updateDaftarPerangkat[$key]['sertifikat_perangkat'] =
                        $req->daftar_perangkat[$key]['sertifikat_perangkat'];
                } else {
                    $updateDaftarPerangkat[$key]['sertifikat_perangkat'] = null;
                }



                if (isset($req->file('daftar_perangkat')[$key])) {
                    if (isset($file['sertifikasi_alat'])) {
                        $data_file_foto_sn = $file['sertifikasi_alat'];
                        $filename = "KOMINFO-cert" . time() . $key . '.' . $data_file_foto_sn->extension();
                        $path = $data_file_foto_sn->storeAs('public/file_syarat', $filename);
                        $path = str_replace('public/', 'storage/', $path);
                        $updateDaftarPerangkat[$key]['sertifikasi_alat'] = $path;
                    } else {
                        $updateDaftarPerangkat[$key]['sertifikasi_alat'] = null;
                    }

                    if (isset($file['foto_sn_perangkat'])) {
                        $data_file_foto_sn = $file['foto_sn_perangkat'];
                        $filename_foto_sn = "KOMINFO-foto-sn-" . time() . $key . '.' . $data_file_foto_sn->extension();
                        $path_foto_sn = $data_file_foto_sn->storeAs('public/file_syarat', $filename_foto_sn);
                        $path_foto_sn = str_replace('public/', 'storage/', $path_foto_sn);
                        $updateDaftarPerangkat[$key]['foto_sn_perangkat'] = $path_foto_sn;
                    } else {
                        $updateDaftarPerangkat[$key]['foto_sn_perangkat'] = $req->prv_foto_sn_perangkat[$key];
                    }
                    if (isset($file['foto_perangkat'])) {
                    $data_file_foto = $file['foto_perangkat'];
                    $filename_foto = "KOMINFO-foto-" . time() . $key . '.' . $data_file_foto->extension();
                    $path_foto = $data_file_foto->storeAs('public/file_syarat', $filename_foto);
                    $path_foto = str_replace('public/', 'storage/', $path_foto);
                    $updateDaftarPerangkat[$key]['foto_perangkat'] = $path_foto;
                    } else {
                    $updateDaftarPerangkat[$key]['foto_perangkat'] = $req->prv_foto_perangkat[$key];
                    }
                    
                } else {
                    $updateDaftarPerangkat[$key]['foto_perangkat'] = $req->prv_foto_perangkat[$key];
                    $updateDaftarPerangkat[$key]['foto_sn_perangkat'] = $req->prv_foto_sn_perangkat[$key];
                    $updateDaftarPerangkat[$key]['sertifikasi_alat'] = $req->prv_sertifikasi_alat[$key] ?? '';
                }
            }
            
            $updateDaftarPerangkat = [
                'id_trx_izin' => $req->id_izin,
                'id_map_listpersyaratan' => $req->id_maplist_daftar_perangkat,
                'filled_document' => json_encode($updateDaftarPerangkat),
                'nama_file_asli' => null,
                'need_correction' => null,
                // 'correction_note' => '',
                'updated_by' => Auth::user()->id,
                'is_active' => '1'
            ];
            // dd($updateDaftarPerangkat);
            $daftar_perangkat = DB::table('tb_trx_persyaratan')->where('id_map_listpersyaratan', '=', $req->id_maplist_daftar_perangkat)
                ->where('id_trx_izin', '=', $req->id_izin);
            $daftar_perangkat = $daftar_perangkat->update($updateDaftarPerangkat);
        }
        // dd($req->daftar_perangkat_telsus);
        if (isset($req->daftar_perangkat_telsus)) {
            // $updateDaftarPerangkatTelsus = [
            //     'id_trx_izin' => $req->id_izin,
            //     'id_map_listpersyaratan' => $req->id_maplist_daftar_perangkat_telsus,
            //     'filled_document' => json_encode($req->daftar_perangkat_telsus),
            //     'nama_file_asli' => null,
            //     'need_correction' => null,
            //     'correction_note' => '',
            //     'updated_by' => Auth::user()->id,
            //     'is_active' => '1'
            // ];
            // $mtk = DB::table('tb_trx_persyaratan')
            //     ->select('id')
            //     ->where('id_map_listpersyaratan', '=', $req->id_maplist_daftar_perangkat_telsus)
            //     ->where('id_trx_izin', '=', $req->id_izin)
            //     ->update($updateDaftarPerangkatTelsus);
            foreach ($req->daftar_perangkat_telsus as $key => $file) {
            if (isset($req->daftar_perangkat_telsus[$key]['isdeleted_perangkat'])) {
            $updateDaftarPerangkatTelsus[$key]['isdeleted_perangkat'] =
            $req->daftar_perangkat_telsus[$key]['isdeleted_perangkat'];
            }

            $updateDaftarPerangkatTelsus[$key]['lokasi_perangkat'] =
            $req->daftar_perangkat_telsus[$key]['lokasi_perangkat'];
            $updateDaftarPerangkatTelsus[$key]['jenis_perangkat'] =
            $req->daftar_perangkat_telsus[$key]['jenis_perangkat'];
            $updateDaftarPerangkatTelsus[$key]['merk_perangkat'] =
            $req->daftar_perangkat_telsus[$key]['merk_perangkat'];
            // $updateDaftarPerangkatTelsus[$key]['sn_perangkat'] = $req->daftar_perangkat_telsus[$key]['sn_perangkat'];
            $updateDaftarPerangkatTelsus[$key]['tipe_perangkat'] =
            $req->daftar_perangkat_telsus[$key]['tipe_perangkat'];
            $updateDaftarPerangkatTelsus[$key]['buatan_perangkat'] =
            $req->daftar_perangkat_telsus[$key]['buatan_perangkat'];
            if (isset($req->daftar_perangkat_telsus[$key]['sertifikat_perangkat'])) {
            $updateDaftarPerangkatTelsus[$key]['sertifikat_perangkat'] =
            $req->daftar_perangkat_telsus[$key]['sertifikat_perangkat'];
            } else {
            $updateDaftarPerangkatTelsus[$key]['sertifikat_perangkat'] = null;
            }



            if (isset($req->file('daftar_perangkat_telsus')[$key])) {
            if (isset($file['sertifikasi_alat'])) {
            $data_file_foto_sn = $file['sertifikasi_alat'];
            $filename = "KOMINFO-cert" . time() . $key . '.' . $data_file_foto_sn->extension();
            $path = $data_file_foto_sn->storeAs('public/file_syarat', $filename);
            $path = str_replace('public/', 'storage/', $path);
            $updateDaftarPerangkatTelsus[$key]['sertifikasi_alat'] = $path;
            } else {
            $updateDaftarPerangkatTelsus[$key]['sertifikasi_alat'] = null;
            }

            if (isset($file['foto_sn_perangkat'])) {
            $data_file_foto_sn = $file['foto_sn_perangkat'];
            $filename_foto_sn = "KOMINFO-foto-sn-" . time() . $key . '.' . $data_file_foto_sn->extension();
            $path_foto_sn = $data_file_foto_sn->storeAs('public/file_syarat', $filename_foto_sn);
            $path_foto_sn = str_replace('public/', 'storage/', $path_foto_sn);
            $updateDaftarPerangkatTelsus[$key]['foto_sn_perangkat'] = $path_foto_sn;
            } else {
            $updateDaftarPerangkatTelsus[$key]['foto_sn_perangkat'] = $req->prv_foto_sn_perangkat[$key];
            }
            if (isset($file['foto_perangkat'])) {
            $data_file_foto = $file['foto_perangkat'];
            $filename_foto = "KOMINFO-foto-" . time() . $key . '.' . $data_file_foto->extension();
            $path_foto = $data_file_foto->storeAs('public/file_syarat', $filename_foto);
            $path_foto = str_replace('public/', 'storage/', $path_foto);
            $updateDaftarPerangkatTelsus[$key]['foto_perangkat'] = $path_foto;
            } else {
            $updateDaftarPerangkatTelsus[$key]['foto_perangkat'] = $req->prv_foto_perangkat[$key];
            }

            } else {
            $updateDaftarPerangkatTelsus[$key]['foto_perangkat'] = $req->prv_foto_perangkat[$key];
            $updateDaftarPerangkatTelsus[$key]['foto_sn_perangkat'] = $req->prv_foto_sn_perangkat[$key];
            $updateDaftarPerangkatTelsus[$key]['sertifikasi_alat'] = $req->prv_sertifikasi_alat[$key] ?? '';
            }
            }

            $updateDaftarPerangkatTelsus = [
            'id_trx_izin' => $req->id_izin,
            'id_map_listpersyaratan' => $req->id_maplist_daftar_perangkat,
            'filled_document' => json_encode($updateDaftarPerangkatTelsus),
            'nama_file_asli' => null,
            'need_correction' => null,
            // 'correction_note' => '',
            'updated_by' => Auth::user()->id,
            'is_active' => '1'
            ];
            // dd($updateDaftarPerangkat);
            $daftar_perangkat_telsus = DB::table('tb_trx_persyaratan')
            ->select('id', 'filled_document')->where('id_map_listpersyaratan', '=', $req->id_maplist_daftar_perangkat)
            ->where('id_trx_izin', '=', $req->id_izin);
            $daftar_perangkat_telsus = $daftar_perangkat_telsus->update($updateDaftarPerangkatTelsus);
        }
        if (isset($req->daftar_ket_konfigurasiteknis)) {
            $daftar_ket_konfigurasiteknis = [...$req->daftar_ket_konfigurasiteknis];
            // dd($konfigurasiteknis);
            $updateDaftarKetKonfigurasiTeknis = [
                'id_trx_izin' => $req->id_izin,
                'id_map_listpersyaratan' => $req->id_maplist_daftar_ket_konfigurasiteknis,
                'nama_file_asli' => null,
                'need_correction' => null,
                // 'correction_note' => '',
                'updated_by' => Auth::user()->id,
            ];
            $konftek = DB::table('tb_trx_persyaratan')
                ->select('id', 'filled_document')->where('id_map_listpersyaratan', '=', $req->id_maplist_daftar_ket_konfigurasiteknis)
                ->where('id_trx_izin', '=', $req->id_izin);
            $filled_document_current = json_decode($konftek->first()->filled_document, true);
            $newkofig = [];
            // foreach($konfigurasiteknis as $key => $konfig) {
            //     $newkofig[$key] = [...$konfig];
            //     if(is_string($konfig['sertifikasi_alat'])) {
            //         $newkofig[$key]['sertifikasi_alat'] = $filled_document_current[$key]['sertifikasi_alat'];
            //     }
            //     else {
            //         // dump($req->file('konfigurasi_teknis')[1]['sertifikasi_alat']);
            //         $item_file = $konfig['sertifikasi_alat'];
            //         $filename = "KOMINFO-" . time() . $key . '.' . $item_file->extension();
            //         $path = $item_file->storeAs('public/file_syarat', $filename);
            //         $path = str_replace('public/', 'storage/', $path);
            //         $newkofig[$key]['sertifikasi_alat'] = $path;
            //     }
            // }
            $updateDaftarKetKonfigurasiTeknis['filled_document'] = json_encode($newkofig);
            $daftar_ket_konfigurasiteknis = $konftek->update($updateDaftarKetKonfigurasiTeknis);
        }

        // store rolloutplan
        if (isset($req->rolloutplan)) {
            $updateRollOutPlan = [
                'id_trx_izin' => $req->id_izin,
                'id_map_listpersyaratan' => $req->id_maplist_roll_out_plan,
                'filled_document' => json_encode($req->rolloutplan),
                'nama_file_asli' => null,
                'need_correction' => null,
                // 'correction_note' => '',
                'created_by' => Auth::user()->id,
                'is_active' => '1'
            ];
            $rolloutplan = DB::table('tb_trx_persyaratan')
                ->select('id')->where('id_map_listpersyaratan', '=', $req->id_maplist_roll_out_plan)
                ->where('id_trx_izin', '=', $req->id_izin)
                ->update($updateRollOutPlan);
        }

        // store komitmen layanan 5 tahun
        if (isset($req->komitmen_kinerja_layanan_lima_tahun)) {
            $updateKomitmenLayananLimaTahun = [
                'id_trx_izin' => $req->id_izin,
                'id_map_listpersyaratan' => $req->id_maplist_komitmen_kinerja_layanan_lima_tahun,
                'filled_document' => json_encode($req->komitmen_kinerja_layanan_lima_tahun),
                'nama_file_asli' => null,
                'need_correction' => null,
                // 'correction_note' => '',
                'updated_by' => Auth::user()->id,
                'is_active' => '1'
            ];
            $komitmenlayananlimatahun = DB::table('tb_trx_persyaratan')
                ->select('id')->where('id_map_listpersyaratan', '=', $req->id_maplist_komitmen_kinerja_layanan_lima_tahun)
                ->where('id_trx_izin', '=', $req->id_izin)
                ->update($updateKomitmenLayananLimaTahun);
        }

        //notifikasi email
        $izin_persyaratan = Izin::where('id_izin', $req->id_izin)->first();
        $izin_persyaratan = $izin_persyaratan->toArray();
        $nib = Nib::where('nib', $izin_persyaratan['nib'])->first();
        $nibs = $nib->toArray();
        
        $email = new EmailHelper();
        //kirim email subkoordinator
        $evaluator = DB::table('tb_trx_disposisi_evaluator as a')
            ->join('tb_mst_user_bo as b', 'b.id', '=', 'a.id_disposisi_user')
            ->where('a.id_izin', $req->id_izin)
            ->first();
        $jabatan = DB::table('tb_mst_jobposition')->where('id', $evaluator->id_mst_jobposition)->first();
        // dd($evaluator);
        $user['email'] = isset($evaluator->email) ? $evaluator->email : '';
        $user['nama'] = $evaluator->nama;
        $nama2 = $evaluator->nama;
        $email_jenis = 'koreksi';
        $departemen = '';
        $catatan_hasil_evaluasi = '';
        $koreksi_all = '';

        if ($izin) {

            $Izinoss = Izinoss::where('id_izin', '=', $req->id_izin)->first(); //set status checklist telah didisposisi
            // $User = User::where('id_izin','=',$req->id_izin)->first(); //set status checklist telah didisposisi

            $izinToLog = $Izinoss->toArray();

            unset($izinToLog['created_at']);
            unset($izinToLog['updated_at']);
            unset($izinToLog['id']);
            unset($izinToLog['status_checklist']);

            $izinToLog['status_checklist'] = '43';
            $izinToLog['created_by'] = Auth::user()->email;
            $izinToLog['created_name'] = Auth::user()->name;
            // dd($izinToLog);
            $insertIzinLog = Izinlog::create($izinToLog);

            



            //end mengirim email ke evaluator
            $kirim_email2 = $email->kirim_email2($user, $email_jenis, $izin_persyaratan, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, $jabatan);
            DB::commit();
            return redirect()->route('home')->with('success', 'Data Your files has been successfully added');
        }
        // } catch (\Throwable $th) {
        //     DB::rollback();
        //     // throw ValidationException::withMessages(['message' => 'Gagal']);
        //     session()->flash('message', 'Submit Persyaratan Tidak Berhasil.');
        //     return redirect()->route('home')->with('failed', 'Data Your files has been failed');
        // }
        
    }

    // QUERY BY DATE
    public function koreksi_get_query_by_date_jasa(Request $req)
    {
        $izin = Viewizin::where(['nib' => Auth::user()->nib[0]->nib, 'id_master_izin' => '1', 'status_fo' => 'Data Re-Konfirmasi Persyaratan'])->distinct('id_izin')->whereBetween('tgl_izin', [$req->tglAwal, $req->tglAkhir])->distinct('id_izin')->get();
        return response()->json($izin);
    }
    public function koreksi_get_query_by_date_jaringan(Request $req)
    {
        $izin = Viewizin::where(['nib' => Auth::user()->nib[0]->nib, 'id_master_izin' => '2', 'status_fo' => 'Data Re-Konfirmasi Persyaratan'])->distinct('id_izin')->whereBetween('tgl_izin', [$req->tglAwal, $req->tglAkhir])->distinct('id_izin')->get();
        return response()->json($izin);
    }
    // END QUERY BY DATE
}