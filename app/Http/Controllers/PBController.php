<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Helpers\UtilPerizinan;
use App\Models\Proyek;
use Illuminate\Http\Request;
use App\Models\Izin_oss;
use App\Models\Nib;
use App\Models\MstIzin;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Osshub;
use App\Models\MstIzinLayanan;
use App\Models\Admin\TabelKodeAkses;
use App\Models\Admin\TabelMasterJenisKodeAkses;
use App\Models\Admin\Izinoss;
use App\Models\Admin\Historyperizinan;
use App\Models\Viewizin;
use App\Models\Admin\Ulolog;
use App\Models\Admin\Penomoranlog;
use DB;


use Illuminate\Support\Facades\Redirect;
use PDO;
use Throwable;

// use Session;
use Config;
// use DB;
// use Str;
class PBController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return redirect('dashboard');
    }


    public function persyaratan(Request $req)
    {
        $id_izin = $req->id_izin;
        return view('pb.persyaratan', compact('id_izin'));
    }

    public function submitpersyaratan(Request $req)
    {
        $izin = Izin_oss::where('id_izin', $req->id_izin)
            ->update(['status_checklist' => '10']);
        if ($izin) {
            return redirect('/pb')->with('message', 'Data telah disubmit');
        }
    }

    

    public function testizin()
    {
        $utilizin = new UtilPerizinan();
        $izin = $utilizin->getIzin();
        dd(Auth::user()->nib);
    }

    public function permohonan(Request $req)
    {
        $utilizin = new UtilPerizinan();
        $izin = $utilizin->getIzin(strtoupper($req->izin));
        $kategori = MstIzin::where('name', strtoupper($req->izin))->first();
        $tipe = $req->izin;
        $date_reformat = new DateHelper();
        $kblijasa = DB::table('tb_mst_kbli')
        ->select('*')->where('id_mst_izin',1)->get();
        $kblijaringan = DB::table('tb_mst_kbli')
        ->select('*')->where('id_mst_izin',2)->get();
        $penomoran = DB::table('tb_mst_jenis_kode_akses')
        ->select('*')->get();
        $kblitelsus = DB::table('tb_mst_kbli')
        ->select('*')->where('id_mst_izin',3)->get();
        $kblitelsusip = DB::table('tb_mst_kbli')
        ->select('*')->where('id_mst_izin',5)->get();
        $kblinomor = DB::table('tb_mst_kbli')
        ->select('*')->whereIn('name',['61100','61200','61300','61912'])->get();
        $user = Auth::user();
        $user_oss_id = $user->oss_id;
        $status_evaluasi = DB::table('tb_oss_user')->select('*')->where('no_id_user_proses',$user->id)->first();
        $status_evaluasi = isset($status_evaluasi->status_evaluasi) ? $status_evaluasi->status_evaluasi : 0;
        // dd($kblitelsus);

        return view('pb.index', compact('izin', 'kategori','tipe', 'date_reformat','user', 'status_evaluasi', 'kblijasa', 'kblijaringan', 'kblitelsus', 'kblitelsusip', 'kblinomor'));
        // dd(Auth::user()->nib);
    }

    public function updatedata()
    {
        try {
            
            $osshub = new Osshub();
            $nib = $osshub->updatenib(Auth::user()->nib[0]->nib);
            $oss_id = $nib->responinqueryNIB->dataNIB->oss_id;
            $izinchecklist = $nib->responinqueryNIB->dataNIB->data_checklist;
            // print_r($izinchecklist);
            // die();
            $izin = MstIzinLayanan::select('kode_izin')->get()->toArray();
            $izindifilter = array_column($izin, 'kode_izin');

            $data = array_values(array_filter($izinchecklist, function ($i) use ($izindifilter, $oss_id){
                if (in_array($i->kd_izin, $izindifilter)) {
                    unset($i->data_persyaratan);
                    $i->oss_id = $oss_id;
                    return $i;
                } else {
                    return null;
                }
            }));
            $upsertizin = array();
            foreach($data as $i){
                array_push($upsertizin, (array) $i);
            }
            // dd($upsertizin);
            $upsert = Izinoss::upsert($upsertizin, ['id_izin']);
            if($upsert){
                session()->flash('message', 'Data sudah diperbaharui' );
                return Redirect::back();
            }else{
                session()->flash('message', 'Tidak ada data yg diperbaharui' );
                return Redirect::back();
            }
        } catch (Throwable $er) {
            session()->flash('message', 'Gagal Menghubungi OSS Hub' );
            return Redirect::back();
        }
    }

    function logFo($id_izin){
        // dd($id_izin);
        $limit_db = Config::get('app.admin.limit');
        
        $historyizin = Historyperizinan::select('*')->where('id_izin','=',$id_izin)->orderBy('created_at')->get();
        if (empty($historyizin)) {
            return abort(404);
        }
        $historyizin = $historyizin->toArray();
        
        $itemkodestatus = TabelKodeAkses::get()->pluck('id_mst_jeniskodeakses','id');
        $itemnamakodestatus = TabelMasterJenisKodeAkses::get()->pluck('full_name','id');

        $utilizin = new UtilPerizinan();
        $izin2 = array();
        $izin2 = $utilizin->getizinBtidIzin(strtoupper($id_izin));

        $history = Ulolog::select('*')->join('vw_list_izin','tb_trx_ulo_log.id_izin','=','vw_list_izin.id_izin')->where('tb_trx_ulo_log.id_izin','=',$id_izin)->with('KodeIzin')->orderBy('created_date')->get();
        if (empty($history)) {
            return abort(404);
        }

        // $penomoranlog = Penomoranlog::where('id_izin','=',$id_izin)->where('id_kode_akses','=',$id_kodeakses)->with('KodeIzin')->get()->toArray();

        $history = $history->toArray();

        $date_reformat = new DateHelper();

        // dd($history);   

        return view('layouts.frontend.historyperizinan.dashboard',['history'=>$history,'izin2'=>$izin2,'historyizin'=>$historyizin,'itemkodestatus'=>$itemkodestatus,'itemnamakodestatus'=>$itemnamakodestatus, 'date_reformat' => $date_reformat]);
        
    }

    // QUERY BY DATE
    public function get_query_by_date(Request $req){
        $izin = Viewizin::where(['nib' => Auth::user()->nib[0]->nib])->distinct('id_izin')->whereBetween('tgl_izin', [$req->tglAwal, $req->tglAkhir])->distinct('id_izin')->get();
        // dd($izin);
        return response()->json($izin);
    }
    public function get_query_by_date_jasa(Request $req){
        $izin = Viewizin::where(['nib' => Auth::user()->nib[0]->nib , 'id_master_izin' => '1','status_checklist' => '00' ])->distinct('id_izin')->whereBetween('tgl_izin', [$req->tglAwal, $req->tglAkhir])->distinct('id_izin')->get();
        return response()->json($izin);
    }
    public function get_query_by_date_jaringan(Request $req){
        $izin = Viewizin::where(['nib' => Auth::user()->nib[0]->nib , 'id_master_izin' => '1','status_checklist' => '00' ])->distinct('id_izin')->whereBetween('tgl_izin', [$req->tglAwal, $req->tglAkhir])->distinct('id_izin')->get();
        return response()->json($izin);
    }
    public function downloadperangkat($id, Request $req){

        $izin = Viewizin::select('vw_list_izin.*','vw_ba_sk.dok_ba','vw_ba_sk.dok_skulo','vw_ba_sk.no_sklo','vw_ba_sk.tgl_sklo' )
        ->leftjoin('vw_ba_sk','vw_ba_sk.id_izin','vw_list_izin.id_izin')
        ->where(['vw_list_izin.id_izin' => $id, 'vw_list_izin.id_master_izin' => '1', 'vw_list_izin.status_fo' => 'Disetujui', 'vw_list_izin.jenis_perizinan' => '02'])->distinct('vw_list_izin.id_izin')->first();
        

        $no_sklo = $izin->no_sklo;
        // $tgl_sklo = $request->input('tgl_sklo');
        // $dok_skulo = $request->file('dok_skulo')->store('public/uploads');
        // $dok_ba = $request->file('dok_ba')->store('public/uploads');
        dd($no_sklo);

        return response()->json($izin);
    }
    // END QUERY BY DATE
}