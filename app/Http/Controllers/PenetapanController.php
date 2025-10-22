<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\TrxUlo;
use App\Models\MstIzin;
use App\Models\Izin_oss;
use App\Helpers\DateHelper;
use Illuminate\Http\Request;
use App\Models\Admin\Izinoss;
use App\Models\MstIzinSyarat;
use App\Helpers\UtilPerizinan;
use App\Models\TrxPemenuhanSyarat;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PenetapanController extends Controller
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

    public function index(Request $req){
        $utilizin = new UtilPerizinan();
        $date_reformat = new DateHelper();
        $izin = $utilizin->getIzinpenetapan(strtoupper($req->izin), 'where');
        $kategori = MstIzin::where('name', strtoupper($req->izin))->first();
        $tipe = $req->izin;

        return view('penetapan.index', compact('tipe','izin','kategori','date_reformat'));
    }
    

    public function downloadlampiran(Request $req)
    {
        $datasyarat = MstIzinSyarat::find($req->id);
        // dd($datasyarat->file_lampiran);
        return response()->download(storage_path('app/lampiran/' . $datasyarat->file_lampiran));
    }

    // QUERY BY DATE
    public function penetapan_get_query_by_date_jasa(Request $req){
        $izin = Viewizin::where(['nib' => Auth::user()->nib[0]->nib , 'id_master_izin' => '1','status_fo' => 'Disetujui'])->distinct('id_izin')->whereBetween('tgl_izin', [$req->tglAwal, $req->tglAkhir])->distinct('id_izin')->get();
        return response()->json($izin);
    }
    public function penetapan_get_query_by_date_jaringan(Request $req){
        $izin = Viewizin::where(['nib' => Auth::user()->nib[0]->nib , 'id_master_izin' => '2','status_fo' => 'Disetujui'])->distinct('id_izin')->whereBetween('tgl_izin', [$req->tglAwal, $req->tglAkhir])->distinct('id_izin')->get();
        return response()->json($izin);
    }
    // END QUERY BY DATE

    //Penetapan ULO 
    public function indexUlo(Request $req){
        $utilizin = new UtilPerizinan();
        
        $izin = DB::table('vw_list_izin as a')
        ->select('a.id_izin as id_izin','a.jenis_izin as jenis_izin', 'a.full_kbli as full_kbli', 'a.jenis_layanan as jenis_layanan', 'a.tgl_izin as tgl_izin', 'a.status_fo as status_fo','a.status_checklist','b.status_ulo as status_ulo','a.nama_master_izin as jenis_izin','b.tgl_pengajuan_ulo as tgl_pengajuan','b.surat_permohonan_ulo_asli as surat_permohonan_ulo_asli','b.tgl_submit as tgl_submit','c.name_status_fo')
        ->leftjoin('tb_trx_ulo as b', 'b.id_izin', 'a.id_izin')
        ->join('tb_oss_mst_kodestatusizin as c', 'c.oss_kode', 'b.status_ulo')
        ->get();

        $izin = $izin->toArray();

        // dd($izin);  

        $kategori = MstIzin::where('name', strtoupper($req->izin))->first();
        $tipe = $req->izin;
        // dd($izin);

        return view('penetapan.indexulo', compact('tipe','izin', 'kategori'));
    }
    //End Penetapan

}
