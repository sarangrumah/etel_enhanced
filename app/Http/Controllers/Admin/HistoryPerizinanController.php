<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\User;
use App\Models\Admin\Izinlog;
use App\Models\Admin\Ulolog;
use App\Models\Admin\Ulo;
use App\Models\Admin\Penomoranlog;

use App\Helpers\IzinHelper;
use App\Helpers\CommonHelper;
use App\Helpers\DateHelper;
use App\Models\Admin\Historyperizinan;
use App\Models\Admin\TabelKodeAkses;
use App\Models\Admin\TabelMasterJenisKodeAkses;
use Illuminate\Validation\ValidationException;

use Session;
use Redirect;
use Auth;
use Config;
use DB;
use Str;

class HistoryPerizinanController extends Controller
{
    
    function __construct()
    {
    $this->middleware('admin');
    }

    public function index($id_izin){
        $date_reformat = new DateHelper();

        $limit_db = Config::get('app.admin.limit');
        
        $historyizin = Historyperizinan::select('*')->where('id_izin','=',$id_izin)->orderBy('created_at')->get();
        if (empty($historyizin)) {
            return abort(404);
        }
        $historyizin = $historyizin->toArray();
        
        $itemkodestatus = TabelKodeAkses::get()->pluck('id_mst_jeniskodeakses','id');
        $itemnamakodestatus = TabelMasterJenisKodeAkses::get()->pluck('full_name','id');

        $history = Ulolog::select('*')->join('vw_list_izin','tb_trx_ulo_log.id_izin','=','vw_list_izin.id_izin')->where('tb_trx_ulo_log.id_izin','=',$id_izin)->with('KodeIzin')->orderBy('created_date')->get();
        if (empty($history)) {
            return abort(404);
        }

        $history = $history->toArray();

        return view('layouts.backend.historyperizinan.dashboard',['date_reformat'=> $date_reformat,'history'=>$history,'historyizin'=>$historyizin,'itemkodestatus'=>$itemkodestatus,'itemnamakodestatus'=>$itemnamakodestatus]);
        
    }

    public function edit($id)
    {
       $datahistoryizin = Historyperizinan::where('id',$id)->firstOrFail();
       return view('layouts.backend.historyperizinan.edit',compact('datahistoryizin'));
    }

    public function update($id)
    {
       return redirect('/historyperizinan')->withErrors(['response' => $message]);
    }

    public function ulo($id_izin){
        $limit_db = Config::get('app.admin.limit');
        
        $historyizin = Historyperizinan::select('*')->where('id_izin','=',$id_izin)->orderBy('created_at')->get();
        if (empty($historyizin)) {
            return abort(404);
        }
        $historyizin = $historyizin->toArray();
        
        $itemkodestatus = TabelKodeAkses::get()->pluck('id_mst_jeniskodeakses','id');
        $itemnamakodestatus = TabelMasterJenisKodeAkses::get()->pluck('full_name','id');

        $history = Ulolog::select('*')->join('vw_list_izin','tb_trx_ulo_log.id_izin','=','vw_list_izin.id_izin')->where('tb_trx_ulo_log.id_izin','=',$id_izin)->with('KodeIzin')->orderBy('created_date')->get();
        if (empty($history)) {
            return abort(404);
        }

        $history = $history->toArray();

        // dd($history);
        
        return view('layouts.backend.historyperizinan.dashboard-ulo',['history'=>$history, 'historyizin'=> $historyizin]);
    }

}
