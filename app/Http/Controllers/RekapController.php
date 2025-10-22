<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\User;
use App\Models\Admin\JobPosition;
use App\Models\Admin\Izin;
use App\Models\Admin\Nib;
use App\Models\Admin\Disposisi;
use App\Models\Admin\Izinoss;
use App\Models\Admin\Izinlog;
use App\Models\Admin\Catatankoordinator;
use App\Models\Admin\Penanggungjawab;
use App\Models\Admin\Ulo;
use App\Models\Admin\Ulolog;
use App\Models\Admin\Disposisiulo;
use App\Models\Admin\Penomoran;
use App\Helpers\IzinHelper;
use App\Helpers\CommonHelper;
use App\Helpers\EmailHelper;
use App\Helpers\LogHelper;
use App\Helpers\DateHelper;
use Illuminate\Validation\ValidationException;
use Session;
use Redirect;
use Auth;
use Config;
use DB;
use Str;

class RekapController extends Controller
{
    public function index(){
        $date_reformat = new DateHelper();
        $limit_db = Config::get('app.admin.limit');
        
        $id_departemen_user = Session::get('id_departemen');
        // if ($id_departemen_user != 1) {
        //     return abort(404);
        // }
        // $izin = Izin::select('*')->where('status_checklist','=',20)->take($limit_db);
        $izin = Izin::select('*')->take($limit_db);
        $izin = $izin->where(function($q) {
            $q->whereIn('status_checklist',[90,50]);
        });
    
        $izin = $izin->where('id_master_izin','=',$id_departemen_user)->distinct('id_izin');
    
        //getcountiizin 
        $countdisposisi = IzinHelper::countIzin(20,$id_departemen_user);
        $countpersetujuan = IzinHelper::countIzin(903,$id_departemen_user);
    
        if ($izin->count() > 0) { //handle paginate error division by zero
            $izin = $izin->paginate($limit_db);
        }else{
            $izin = $izin->get();
        }
    
        $paginate = $izin;
        $izin = $izin->toArray();
        
        // dd($izin);
        $jenis_izin = 'Izin Penyelenggaraan Jasa Telekomunikasi';
        $date_reformat = new DateHelper();
    
        return view('layouts.backend.rekap.rekap_sklo',['date_reformat'=>$date_reformat,'izin'=>$izin,'paginate'=>$paginate,'countdisposisi'=>$countdisposisi,'countpersetujuan'=>$countpersetujuan,'jenis_izin'=>$jenis_izin]);
    }
    
}