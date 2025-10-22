<?php

use App\Models\Nib;
use App\Helpers\DateHelper;
use App\Helpers\UtilPerizinan;
use App\Http\Controllers\Admin\testEmailController as AdminTestEmailController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\SurveiController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\HelpdeskController;
use App\Http\Controllers\InstansiPemerintah;
use App\Http\Controllers\testEmailController;
use App\Http\Controllers\JenisPenomoranController;
use App\Http\Controllers\PermohonanPenomoranController;
/*
|--------------------------------------------------------------------------
| Web Routes Khusus Frontoffice
|--------------------------------------------------------------------------
*/

Auth::routes();

// Route::get('/email-ulo', function () {
//     return view('layouts.frontend.email_ulo.permohonan_diterima');
// });

// Route::get('/registerpt', function (){
//     return view('layouts.frontend.registerpt');
// });
Route::prefix('/landing')->group(function () {
    Route::get('/', [LandingController::class, 'index'])->name('landing.index');
    Route::get('/std', function (){return view('layouts.landing.std-svc');});
    Route::get('/izin/{izin}', [LandingController::class, 'landing_izin'])->name('landing.landing-izin');
    Route::get('/faq', [LandingController::class, 'faq'])->name('landing.faq_menu');
    Route::get('/reqbimtek', [LandingController::class, 'req_bimtek'])->name('landing.bimtek');
    Route::post('/reqbimtekpost', [LandingController::class, 'req_bimtekpost'])->name('landing.bimtekpost');
});



Route::get('/validasi-sk/{id}', [App\Http\Controllers\PemenuhanPersyaratanController::class, 'viewspersyaratan']);
Route::get('/validasi-sk-komit/{id}', [App\Http\Controllers\PemenuhanPersyaratanController::class, 'viewspersyaratan']);
Route::get('/validasisk', function (){
    return view('layouts.landing.informasi', ['title' => 'PERIZINAN JASA TELEKOMUNIKASI', 'content' => ['KBLI', 'Persyaratan', 'Sistem Mekanisme dan Prosedur', 'Jangka Waktu', 'Biaya', 'Produk']]);
});

Route::get('/layanan', [HelpdeskController::class,'create']);
Route::get('/daftarlayanan', [HelpdeskController::class,'index']);
Route::post('/simpanlayanan', [HelpdeskController::class,'save']);
Route::get('/updatelayanan/{id}', [HelpdeskController::class,'update']);
Route::put('/updatelayanan/{id}', [HelpdeskController::class,'savelayanan']);
Route::get('/tutuplayanan/{id}', [HelpdeskController::class,'closed']);

Route::prefix('/export')->group(function () {
    Route::get('/helpdesk', [HelpdeskController::class,'exportexcel']);
});

Route::get('/informasi-jastel', function (){
    return view('layouts.landing.informasi', ['title' => 'PERIZINAN JASA TELEKOMUNIKASI', 'content' => ['KBLI', 'Persyaratan', 'Sistem Mekanisme dan Prosedur', 'Jangka Waktu', 'Biaya', 'Produk']]);
});
Route::get('/informasi-jartel', function (){
    return view('layouts.landing.informasi', ['title' => 'PERIZINAN JARINGAN TELEKOMUNIKASI', 'content' => []]);
});
Route::get('/informasi-telsus', function (){
    return view('layouts.landing.informasi', ['title' =>'PERIZINAN TELEKOMUNIKASI KHUSUS', 'content' => []]);
});
Route::get('/informasi-penomoran', function (){
    return view('layouts.landing.informasi', ['title' =>'PENOMORAN', 'content' => []]);
});
Route::get('/faq', function (){
    return view('layouts.landing.faq', ['title' =>'FAQ', 'content' => ['Permohonan Izin Jasa Telekomunikasi', 'Permohonan Perizinan Jaringan Telekomunikasi', 'Permohonan Perizinan Telekomunikasi Khusus', 'Permohonan Penetapan Penomoran Telekomunikasi', 'Penanganan Pengaduan, saran, dan Masukan ']]);
});
Route::get('/standar-pelayanan', function (){
    return view('layouts.landing.standar-pelayanan', ['title' => 'STANDAR PELAYANAN']);
});
Route::get('/panduan', function (){
    return view('layouts.landing.panduan', ['content' => ['Panduan Permohonan Perizinan Jasa Telekomunikasi', 'Panduan Permohonan Perizinan Jaringan Telekomunikasi', 'Panduan Permohonan Perizinan Telekomunikasi Khusus', 'Panduan Permohonan Penetapan Penomoran']]);
});
// Route::get('/survey/{id}', function (){
//     return view('layouts.survey.index');
// });
Route::get('/survey/{id_izin}', [App\Http\Controllers\SurveyController::class, 'index']);
Route::get('/responder', [App\Http\Controllers\SurveyController::class, 'responder']);
Route::post('/responder', [App\Http\Controllers\SurveyController::class, 'responderSubmit'])->name('responder-submit');
// Route::get('/survey/responder/{id}', function (){
//     return view('layouts.survey.responder');
// });
Route::get('/survey/greet/{id}', function (){
    return view('layouts.survey.greet');
});

Route::get('/survey/form/{survey_id}', [App\Http\Controllers\SurveyController::class, 'form']);
Route::post('/survey/form/{survey_id}', [App\Http\Controllers\SurveyController::class, 'formSubmit'])->name('form-submit');
Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);

Route::get('/download/syarat/lampiran/{id}', [App\Http\Controllers\PemenuhanPersyaratanController::class, 'downloadlampiran']);
Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        
        $utilizin = new UtilPerizinan();
        $date_reformat = new DateHelper();
        $izin = $utilizin->getIzin("ALL");
        // dd($izin);
        $done = $utilizin->getIzin("DONE");
        $proses = $utilizin->getIzin("PROSES");
        $rejected = count($utilizin->getIzin("REJECTED"));
        $user_oss = Auth::user();
        $user_oss_id = $user_oss->oss_id;
        // dd($user_oss);
        $penomoran = DB::table('tb_mst_jenis_kode_akses')
        ->select('*')->get();
        $kblijasa = DB::table('tb_mst_kbli')
        ->select('*')->where('is_jasa',1)->where('is_active',1)->get();
        $kblijaringan = DB::table('tb_mst_kbli')
        ->select('*')->where('is_jaringan',1)->where('is_active',1)->get();
        $kblitelsus = DB::table('tb_mst_kbli')
        ->select('*')->where('id_mst_izin',3)->where('is_active',1)->get();
        $kblitelsusip = DB::table('tb_mst_izinlayanan')
        ->select('*')->where('non_oss',1)->where('non_layanan',0)->where('layanan_penomoran',0)->get();

        $status_pelakuusaha = DB::table('vw_nib_detail')->select('*')
        ->where('oss_id',$user_oss_id)->first();
        
        $kblinomor = DB::table('tb_mst_izinlayanan')
        ->select('*')->where('non_oss','6')->where('is_active','1')->get();
        $kblinomor_pt = DB::table('tb_mst_izinlayanan')
        ->select('*')->whereIn('non_oss',['5','6'])->where('is_active','1')->get();
        // dd($status_pelakuusaha);
        // dd($status_pelakuusaha->jenis_perseroan);
        if (isset($status_pelakuusaha->jenis_perseroan)) {
             if ($status_pelakuusaha->jenis_perseroan==13) {
             $kblinomor = DB::table('tb_mst_izinlayanan')
             ->select('*')->whereIn('id',['42','45'])->where('is_active','1')->get();
             } else {
             $kblinomor = DB::table('tb_mst_izinlayanan')
             ->select('*')->where('non_oss','6')->where('is_active','1')->get();
             }
        }
        // $kblinomor = DB::table('tb_mst_izinlayanan')
        // ->select('*')->where('non_oss','6')->where('is_active','1')->get();
        
       
        
        // $kblinomor_pt = DB::table('tb_mst_izinlayanan')
        // ->select('*')->whereIn('non_oss',['5','6'])->where('is_active','1')->get();
        // dd($izin);   
        // $user_oss = Auth::user();
        // $user_oss_id = $user_oss->oss_id;
        // $status_evaluasi = DB::table('tb_oss_user')->select('*')->where('no_id_user_proses',$user_oss->id)->first();
        $status_evaluasi_all = DB::table('vw_status_pelakuusaha')->select('*')->where('oss_id',$user_oss->oss_id)->first();
        // dd($status_evaluasi);
        $status_evaluasi = isset($status_evaluasi_all->status_evaluasi) ? $status_evaluasi_all->status_evaluasi : 0;
        $status_evaluasi_msg = isset($status_evaluasi_all->status_fe) ? $status_evaluasi_all->status_fe : 'Status verifikasi tidak diketahui';
        // dd($status_evaluasi_all->status_fe);

        $done = count($utilizin->getIzin("DONE"));
        // dd($kblijasa,$kblijaringan);
        $proses = count($utilizin->getIzin("PROSES"));
        return view('layouts.frontend.dashboard', compact('izin', 'done', 'rejected', 
        'proses','date_reformat','penomoran','kblijasa','kblijaringan','kblitelsus','kblitelsusip','kblinomor','kblinomor_pt','status_evaluasi','status_evaluasi_msg'));
    });

    // Route::get('/historyperizinan/{id}', [App\Http\Controllers\PBController::class, 'logFo'])->name('historyperizinan')->middleware('jabatancheck');

   Route::get('/testemail/koordinator/{id}', [testEmailController::class, 'testemail_ketuatim_disposisi_instansi']);
        


    Route::get('/getjenispenomoran/{id}', function($id){
        $jenis_penomoran = DB::table('tb_mst_izinlayanan')->select('*')->where('id_mst_kbli',$id)->get();
        return response()->json($jenis_penomoran);
    });

    Route::get('/home', function () {
        return redirect('/');
    })->name('home');

    Route::get('/pb', [App\Http\Controllers\PBController::class, 'index'])->name('pb');
    // Route::get('/pb/persyaratan/{id_izin}', [App\Http\Controllers\PBController::class, 'persyaratan'])->name('pb_persyaratan');
    // Route::post('/pb/submitpersyaratan', [App\Http\Controllers\PBController::class, 'submitpersyaratan'])->name('pb_submitpersyaratan');

    Route::get('/dashboard', function () {
        // return view('\layouts\backend\dashboard');
        return redirect('/');
    });
    
    Route::get('/dashboard_penomoran', [App\Http\Controllers\PermohonanPenomoranController::class,
    'dashboard_penomoran'])->name('dashboard_penomoran');
    Route::get('/dashboard_penomoran_tetap', [App\Http\Controllers\PermohonanPenomoranController::class, 'dashboard_penetapan'])->name('dashboard_penetapan');
    Route::get('/penomoran-baru', function () {
        return view('\layouts\frontend\penomoran\penomoran-baru');
    });
    // Route::get('/penomoran-baru', [JenisPenomoranController::class, 'index']);

    Route::get('/persyaratan', function () {
        return view('\layouts\frontend\persyaratan');
    });
    Route::get('/ujilaikoperasi', function () {
        return view('\layouts\frontend\ujilaikoperasi');
    });
    Route::get('/registerpj', function () {
        return view('\layouts\frontend\registerpj');
    });
    Route::get('/registerpt', function () {
        return view('\layouts\frontend\registerpt');
    });
    
    Route::get('/survei/detail/{id}', [SurveiController::class, 'index'])->name('survei.detail');
    Route::post('/survei/detail', [SurveiController::class, 'post'])->name('survei.post');
    Route::get('/survei/isi', [SurveiController::class, 'isi'])->name('survei.isi');
    

    Route::get('/izin', [App\Http\Controllers\PBController::class, 'testizin']);
    Route::prefix('/pb')->group(function () {
        // PERMOHONAN
        Route::get('/permohonan/{izin}', [App\Http\Controllers\PBController::class, 'permohonan'])->name('permohonan');
        Route::get('/pemenuhan-persyaratan/{id}', [App\Http\Controllers\PemenuhanPersyaratanController::class, 'formpersyaratan']);
        // Route::get('/pemenuhan-persyaratan/{id}', [App\Http\Controllers\PemenuhanPersyaratanController::class, 'formpersyaratan']);
        Route::get('/view-persyaratan/{id}', [App\Http\Controllers\PemenuhanPersyaratanController::class,
        'viewpersyaratan']);
        Route::post('/submitpersyaratan', [App\Http\Controllers\PemenuhanPersyaratanController::class, 'submitpersyaratan'])->name('pb_submitpersyaratan');
        Route::post('/submitpersyarataniptelsus', [App\Http\Controllers\PemenuhanPersyaratanController::class, 'submitpersyaratanIPtelsus'])->name('pb_submitpersyarataniptelsus');
        Route::get('/submitpersyaratanip', [App\Http\Controllers\PemenuhanPersyaratanController::class, 'submitpersyaratanIP'])->name('pb_submitpersyaratanip');
        Route::post('/submitpersyaratanip', [App\Http\Controllers\PemenuhanPersyaratanController::class, 'submitpersyaratanIP'])->name('pb_submitpersyaratanip');
        
        Route::get('/exnted-izinprinsip/{id}', [App\Http\Controllers\PemenuhanPersyaratanController::class,
        'submitperpanjanganiptelsus']);
        Route::get('/pemenuhan-persyaratan/ip/{id}', [App\Http\Controllers\PemenuhanPersyaratanController::class,
        'submitpersyaratanizintelsus']);
        Route::get('/pemenuhan-persyaratan/ipreturn/{id}', [App\Http\Controllers\PemenuhanPersyaratanController::class,
        'submitpersyaratanizintelsus_return']);
        Route::get('/pemenuhan-persyaratan/ipxtend/{id}', [App\Http\Controllers\PemenuhanPersyaratanController::class,
        'submitpersyaratanizintelsus']);
        // END PERMOHONAN

        // KOREKSI PERSYARATAN
        Route::get('/koreksipersyaratan/{izin}', [App\Http\Controllers\KoreksiPersyaratanController::class, 'index']);
        Route::get('/koreksi-persyaratan/{id}', [App\Http\Controllers\KoreksiPersyaratanController::class, 'formpersyaratan']);
        Route::post('/submitkoreksi', [App\Http\Controllers\KoreksiPersyaratanController::class, 'submitpersyaratan']);

        Route::post('/koreksi_get_by_date_jasa', [App\Http\Controllers\KoreksiPersyaratanController::class, 'koreksi_get_query_by_date_jasa'])->name('koreksi_get_by_date_jasa');
        Route::post('/koreksi_get_by_date_jaringan', [App\Http\Controllers\KoreksiPersyaratanController::class, 'koreksi_get_query_by_date_jaringan'])->name('koreksi_get_by_date_jaringan');
        // END KOREKSI PERSYARATAN

        // PENETAPAN
        Route::get('/penetapan/{izin}', [App\Http\Controllers\PenetapanController::class, 'index']);

        Route::post('/penetapan_get_by_date_jasa', [App\Http\Controllers\PenetapanController::class, 'penetapan_get_query_by_date_jasa'])->name('penetapan_get_by_date_jasa');
        Route::post('/penetapan_get_by_date_jaringan', [App\Http\Controllers\PenetapanController::class, 'penetapan_get_query_by_date_jaringan'])->name('penetapan_get_by_date_jaringan');

        // END PENETAPAN

        // Route::get('/pelacakan/{id}', [App\Http\Controllers\PBController::class, 'pelacakan']);


        // perbaharui data
        Route::get('/updatedata', [App\Http\Controllers\PBController::class, 'updatedata']);

        // LOG FO
        Route::get('/historyperizinan/{id}', [App\Http\Controllers\PBController::class, 'logFo']);
        Route::get('/historyperizinanpenomoran/{id}', [App\Http\Controllers\PBController::class, 'logFoPenomoran']);
        // END LOG FO


        // QUERY BY DATA
        Route::post('/get_by_date', [App\Http\Controllers\PBController::class, 'get_query_by_date'])->name('get_by_date');
        Route::post('/get_by_date_jasa', [App\Http\Controllers\PBController::class, 'get_query_by_date_jasa'])->name('get_by_date_jasa');
        Route::post('/get_by_date_jaringan', [App\Http\Controllers\PBController::class, 'get_query_by_date_jaringan'])->name('get_by_date_jaringan');

        // END QUERY BY DATA

        
        Route::get('/dashboard_penomoran', [App\Http\Controllers\PermohonanPenomoranController::class,
        'dashboard_penomoran'])->name('dashboard_penomoran');
        Route::get('/dashboard_penomoran_tetap', [App\Http\Controllers\PermohonanPenomoranController::class, 'dashboard_penetapan'])->name('dashboard_penetapan');
    

    });

    Route::prefix('/penomoran')->group(function(){
        Route::get('/evaluasi-penomoran/{id}', [App\Http\Controllers\PermohonanPenomoranController::class,
        'evaluasiPenomoran'])->name('penomoran.evaluasipenomoran');
    });
    Route::prefix('/ulo')->group(function () {
        //PERMOHONAN ULO
        Route::get('/permohonan', [App\Http\Controllers\UloController::class, 'permohonan'])->name('ulo.permohonan');
        Route::get('/pengajuan-ulo/{id}', [App\Http\Controllers\UloController::class, 'pengajuan']);
        Route::get('/mandiri-ulo/{id}', [App\Http\Controllers\UloController::class, 'mandiri']);
        Route::post('/submitulo', [App\Http\Controllers\UloController::class, 'submitUlo'])->name('submitulo');
        Route::post('/perpanjangip', [App\Http\Controllers\UloController::class, 'submitperpanjangip'])->name('submitperpanjangip');
        // Route::post('/submitmandiri', [App\Http\Controllers\UloController::class, 'submitMandiri'])->name('submitulo');
        Route::post('/submitmandiri', [App\Http\Controllers\UloController::class, 'submitMandiri'])->name('submitMandiri');
        Route::get('/offday', [App\Http\Controllers\UloController::class, 'offDay'])->name('offday');
        //END PERMOHONAN ULO
        
        // PENEPATAN ULO
        Route::get('/penetapan/{izin}', [App\Http\Controllers\PenetapanController::class, 'indexUlo']);
        // Route::post('/penetapan_get_by_date_jasa', [App\Http\Controllers\PenetapanController::class, 'penetapan_get_query_by_date_jasa'])->name('penetapan_get_by_date_jasa');
        // Route::post('/penetapan_get_by_date_jaringan', [App\Http\Controllers\PenetapanController::class, 'penetapan_get_query_by_date_jaringan'])->name('penetapan_get_by_date_jaringan');
        // END PENETAPAN ULO

    });

    Route::prefix('/pemenuhanpersyaratan/{izin}')->group(function () {
        Route::get('/', [App\Http\Controllers\PemenuhanPersyaratanController::class, 'index']);
    });


    // Route::prefix('/koreksipersyaratan/{izin}')->group(function () {
    //     Route::get('/', [App\Http\Controllers\KoreksiPersyaratanController::class, 'index']);

    // });

    // Route::prefix('/koreksi-persyaratan/{id}')->group(function () {
    //     Route::get('/', [App\Http\Controllers\KoreksiPersyaratanController::class, 'formpersyaratan']);

    // });

    // Route::prefix('/penetapan/{izin}')->group(function () {
    //     Route::get('/', [App\Http\Controllers\PenetapanController::class, 'index']);
    // });
    Route::prefix('/komitmen')->group(function () {
        Route::get('/perubahan/{id_izin}', [App\Http\Controllers\PenyesuaianController::class, 'komitmen']);
        Route::post('/perubahan/{id_izin}', [App\Http\Controllers\PenyesuaianController::class, 'komitmenSubmit']);
        Route::post('/surat', [App\Http\Controllers\PenyesuaianController::class, 'suratSubmit']);
        Route::get('/koreksi-penyesuaian/{id}', [App\Http\Controllers\PenyesuaianController::class, 'formpersyaratan']);
        Route::post('/koreksi-penyesuaian/{id}', [App\Http\Controllers\PenyesuaianController::class, 'formpersyaratanSubmit']);

        Route::get('/penyesuaian/{id_izin}', [App\Http\Controllers\PenyesuaianController::class, 'komitmenPenyesuaian']);
        Route::post('/penyesuaian/{id_izin}', [App\Http\Controllers\PenyesuaianController::class, 'komitmenPenyesuaianSubmit']);
    });
});




// Front End - Penomoran
Route::prefix('/penomoran')->group(function(){
    Route::get('/', [PermohonanPenomoranController::class, 'index']);
    Route::post('/getjenisnomor', [PermohonanPenomoranController::class, 'getjenispenomoran']);
    Route::post('/getnomor', [PermohonanPenomoranController::class, 'getnomor']);
    Route::post('/savepenomoranbaru', [PermohonanPenomoranController::class, 'savepenomoranbaru']);
    Route::post('/savepenomoranpenambahan', [PermohonanPenomoranController::class, 'savepenomoranpenambahan']);
    Route::post('/savepenyesuaian', [PermohonanPenomoranController::class, 'savepenyesuaian']);
    Route::post('/savepengembalian', [PermohonanPenomoranController::class, 'savepengembalian']);
    Route::get('/penyesuaian/{id_proyek}/{id_izin}/{id_trx}', [PermohonanPenomoranController::class, 'penyesuaian']);
    Route::get('/pengembalian/{id_proyek}/{id_izin}/{id_trx}', [PermohonanPenomoranController::class, 'pengembalian']);
    Route::post('/getKodeWeilayah', [PermohonanPenomoranController::class, 'getKodeWeilayah']);



});

Route::get('/penomoran-baru', [PermohonanPenomoranController::class, 'index']);
// Route::get('/pra-penomoran/{id_proyek}', [PermohonanPenomoranController::class, 'pra_detail']);
Route::get('/penomoran/{id_proyek}/{id_izin}', [PermohonanPenomoranController::class, 'detail']);
// Route::post('/penomoran/baru', [PermohonanPenomoranController::class, 'baru']);
// Route::get('/penomoran/{id_izin}', [PermohonanPenomoranController::class, 'barunpt']);
// Route::post('/penomoran/baru', [PermohonanPenomoranController::class, 'baru_rev']);
Route::get('/penomoran/baru', [PermohonanPenomoranController::class, 'baru_rev']);
Route::get('/penomoran/barunpt', [PermohonanPenomoranController::class, 'barunpt_rev']);
Route::get('/penomoran/add', [PermohonanPenomoranController::class, 'add_rev']);
Route::get('/penomoran/addnpt', [PermohonanPenomoranController::class, 'addnpt_rev']);
Route::get('/penomoran/pengembalian', [PermohonanPenomoranController::class, 'remove_rev']);
Route::get('/penomoran/pengembaliannpt', [PermohonanPenomoranController::class, 'removenpt_rev']);
Route::get('/penomoran/penyesuaian', [PermohonanPenomoranController::class, 'revise_rev']);
Route::get('/penomoran/penyesuaiannpt', [PermohonanPenomoranController::class, 'revisenpt_rev']);
Route::get('/penomoran/penambahan/{id_proyek}/{id_izin}', [PermohonanPenomoranController::class, 'penambahan']);
Route::get('/penomoran/pengajuan/{id_proyek}/{id_izin}', [PermohonanPenomoranController::class, 'listpengajuan']);
Route::get('/log-penomoran/{id_izin}', [PermohonanPenomoranController::class, 'logPenomoran']);



// INSTANSII PEMERINTAH
Route::prefix('/ip')->group(function(){
    Route::get('/', function () {
        return redirect('/');
    })->name('ip');
    Route::get('/registerpt', [InstansiPemerintah::class, 'registerpt'])->name('registerpt');
    Route::post('/registerpt', [InstansiPemerintah::class, 'registerptPost'])->name('postregisterpt');

    Route::get('/registerpj', [InstansiPemerintah::class, 'registerpj'])->name('registerpj');
    Route::post('/registerpj', [InstansiPemerintah::class, 'registerpjPost'])->name('registerpjPost');
    
    // API ALAMAT
    Route::post('/getKabupaten', [InstansiPemerintah::class, 'getKabupaten'])->name('getKabupaten');
    Route::post('/getKecamatan', [InstansiPemerintah::class, 'getKecamatan'])->name('getKecamatan');
    Route::post('/getKelurahan', [InstansiPemerintah::class, 'getKelurahan'])->name('getKelurahan');

    Route::get('/updateemail', [InstansiPemerintah::class, 'updateemail'])->name('updateemail');
    Route::get('/updatenib', [InstansiPemerintah::class, 'updatenib'])->name('updatenib');
    Route::post('/updateippost', [InstansiPemerintah::class, 'updateemailnibpost'])->name('updateemailnibpost');
}); 



Route::get('/penomoran-ta', function () {
    return view('\layouts\frontend\penomoran\penomoran-tambahan');
});

Route::get('/penomoran-se', function () {
    return view('layouts.frontend.penomoran.penomoran-se');
});

Route::get('/penomoran-pe', function () {
    return view('layouts.frontend.penomoran.penomoran-pe');
});
Route::get('/jnsnmr/{jenisnomor_id}', [JenisPenomoranController::class, 'jnsnomor']);


Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
    return redirect('/');
});
// End - Front End - Penomoran