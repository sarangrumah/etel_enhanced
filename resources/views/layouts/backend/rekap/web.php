<?php

use App\Http\Controllers\Admin;

use App\Http\Controllers\JenisPenomoranController;
use App\Http\Controllers\PermohonanPenomoranController;
use App\Http\Controllers\Api;
// use App\Http\Controllers\Admin\HelpdeskController;
use App\Libraries\Captcha;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes Khusus Backoffice
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Front End
// Route::get('/', function () {
//     // return view('layouts.backend.dashboard');
//     return view('layouts.frontend.dashboard');
// })->middleware('auth');


// ===================================== MIDDLEWARE_ADMIN DISINI ================================
// contoh : ->middleware('admin')
// 
// 
// 

// Auth::routes();

Route::get('/generate', [Captcha::class, 'generate']);

Route::get('/sso', [Api\Ossapi::class, 'SSO'])->name('sso_url');



Route::get('/admin/login', [Admin\LoginController::class, 'showLoginForm'])->name('admin.login.index')->middleware('jabatancheck');
Route::post('/admin/login', [Admin\LoginController::class,
'login'])->name('admin.login')->middleware('jabatancheck')->middleware('throttle:tryattempts');
Route::get('/admin/logout', [Admin\LoginController::class, 'logout'])->name('admin.logout')->middleware('jabatancheck');

Route::group(['prefix' => 'admin'], static function () {
    Route::middleware(['admin'])->group(function () {

        Route::get('/', [Admin\AdminDashboardController::class, 'index'])->name('admin.dashboard')->middleware('jabatancheck');
        Route::get('/dashboard', [Admin\AdminDashboardController::class, 'index'])->name('admin.dashboard')->middleware('jabatancheck');

        //helpdesk
        Route::get('/layanan', [Admin\HelpdeskController::class,'create']);
        Route::get('/daftarlayanan', [Admin\HelpdeskController::class,'index']);
        Route::post('/simpanlayanan', [Admin\HelpdeskController::class,'save']);
        Route::get('/updatelayanan/{id}', [Admin\HelpdeskController::class,'update']);
        Route::put('/updatelayanan/{id}', [Admin\HelpdeskController::class,'savelayanan']);
        Route::get('/tutuplayanan/{id}', [Admin\HelpdeskController::class,'closed']);
        Route::get('/evaluasi-penomoran/{id}', [Admin\RekapController::class,
        'evaluasiPenomoran_view'])->name('admin.evaluasipenomoran_view');
        //Verifikator NIB
        Route::get('/evaluasi-registrasi', [Admin\KoordinatorController::class,
        'evaluasiRegistrasi'])->name('admin.verifikatornib.evaluasiregistrasi')->middleware('jabatancheck');
        Route::get('/verifikatornib/evaluasi-registrasi-p/{id}', [Admin\KoordinatorController::class,
        'evaluasiRegistrasiProcess'])->name('admin.verifikatornib.evaluasiregistrasiprocess')->middleware('jabatancheck');
        Route::post('/verifikatornib/evaluasi-registrasi-post/{id}', [Admin\KoordinatorController::class,
        'evaluasiRegistrasiPost'])->name('admin.verifikatornib.evaluasiregistrasipost')->middleware('jabatancheck');

        //ptsp user
        Route::get('/ptsp', [Admin\RekapController::class, 'AllRequest'])->name('admin.ptsp.laporan-request')->middleware('jabatancheck');
        

        //Direktur
        Route::get('/direktur', [Admin\DirekturController::class, 'index'])->name('admin.direktur')->middleware('jabatancheck');
        Route::get('/direktur/sk-ulo', [Admin\DirekturController::class, 'skUlo'])->name('admin.direktur.sk-ulo')->middleware('jabatancheck');
        
        Route::get('/direktur/evaluasi-penomoran/{id}', [Admin\DirekturController::class, 'evaluasiPenomoran'])->name('admin.direktur.evaluasipenomoran')->middleware('jabatancheck');
        Route::get('/direktur/ulo', [Admin\DirekturController::class, 'ulo'])->name('admin.direktur.ulo')->middleware('jabatancheck');
        Route::get('/direktur/penetapan-ulo/{id}/{urut}', [Admin\DirekturController::class, 'penetapanUlo'])->name('admin.direktur.penetapan-ulo')->middleware('jabatancheck');
        Route::get('/direktur/penetapan-ip/{id}', [Admin\DirekturController::class, 'penetapanIP'])->name('admin.direktur.penetapan-ip')->middleware('jabatancheck');
        Route::post('/direktur/penetapanulopost/{id}/{urut}', [Admin\DirekturController::class, 'penetapanUloPost'])->name('admin.direktur.penetapanulopost')->middleware('jabatancheck');
        Route::get('/direktur/kirimsk/{id}', [Admin\DirekturController::class, 'kirimSK'])->name('admin.direktur.kirimSK')->middleware('jabatancheck');
        Route::post('/direktur/penetapanippost/{id}', [Admin\DirekturController::class, 'penetapanIPPost'])->name('admin.direktur.penetapanippost')->middleware('jabatancheck');
        Route::post('/direktur/cabutsk/{id}', [Admin\DirekturController::class, 'cabutSk'])->name('admin.direktur.cabutsk')->middleware('jabatancheck');
        Route::get('/direktur/view-sk-ulo/{id}', [Admin\DirekturController::class, 'lihatSK'])->name('admin.direktur.lihat-sk-ulo')->middleware('jabatancheck');
        Route::get('/direktur/generatepdf/{id}', [Admin\DirekturController::class, 'generatepdf'])->name('admin.direktur.generatepdf')->middleware('jabatancheck');

        Route::get('/direktur/penomoran', [Admin\DirekturController::class, 'penomoran'])->name('admin.direktur.penomoran')->middleware('jabatancheck');
        Route::get('/direktur/penetapan-penomoran/{id}/{idkodeakses}', [Admin\DirekturController::class, 'penetapanPenomoran'])->name('admin.direktur.penetapan-penomoran')->middleware('jabatancheck');
        Route::post('/direktur/penetapanpenomoranpost/{id}/{idkodeakses}', [Admin\DirekturController::class, 'penetapanPenomoranPost'])->name('admin.direktur.penetapanpenomoranpost')->middleware('jabatancheck');
        Route::get('/direktur/sk-penomoran', [Admin\DirekturController::class, 'skPenomoran'])->name('admin.direktur.sk-penomoran')->middleware('jabatancheck');
        Route::get('/direktur/view-sk-penomoran/{id}/{idkodeakses}', [Admin\DirekturController::class, 'lihatSKPenomoran'])->name('admin.direktur.lihat-sk-penomoran')->middleware('jabatancheck');

        Route::get('/direktur/penyesuaian', [Admin\DirekturController::class, 'penyesuaian'])->name('admin.direktur.penyesuaian')->middleware('jabatancheck');
        Route::get('/direktur/penetapan-penyesuaian/{id}', [Admin\DirekturController::class, 'penetapanPenyesuaian'])->name('admin.direktur.penetapan-penyesuaian')->middleware('jabatancheck');
        Route::post('/direktur/penetapanpenyesuaianpost/{id}', [Admin\DirekturController::class, 'penetapanPenyesuaianPost'])->name('admin.direktur.penetapanpenyesuaianpost')->middleware('jabatancheck');

        Route::get('/direktur/pencabutan-penomoran/{id}', [Admin\DirekturController::class,
        'pencabutanPenomoran'])->name('admin.direktur.cabutnomor')->middleware('jabatancheck');
        Route::post('/direktur/evaluasi-pencabutanpenomoranPost/{id}', [Admin\DirekturController::class,
        'pencabutanPenomoranPost'])->name('admin.direktur.evaluasi-pencabutanpenomoranPost')->middleware('jabatancheck');
        
        Route::get('/direktur/cetak/{id}', [Admin\DirekturController::class, 'putFileSKPerubahan'])->middleware('jabatancheck');

        //User Manage
        Route::get('/users', [Admin\UsersController::class, 'index'])->name('admin.user')->middleware('jabatancheck');
        Route::get('/users/add', [Admin\UsersController::class, 'addUsers'])->name('admin.adduser')->middleware('jabatancheck');
        Route::post('/users/add', [Admin\UsersController::class, 'addUsersPost'])->name('admin.adduserpost')->middleware('jabatancheck');
        Route::get('/users/edit/{id}', [Admin\UsersController::class, 'editUsers'])->name('admin.edituser')->middleware('jabatancheck');
        Route::post('/users/edit/{id}', [Admin\UsersController::class, 'editUsersPost'])->name('admin.edituserpost')->middleware('jabatancheck');
        Route::get('/users/delete/{id}', [Admin\UsersController::class, 'deleteUsers'])->name('admin.deleteuser')->middleware('jabatancheck');

        //Faq Manage
        Route::get('/faqs', [Admin\FaqsController::class, 'index'])->name('admin.faq')->middleware('jabatancheck');
        Route::get('/faqs/add', [Admin\FaqsController::class, 'addFaqs'])->name('admin.addfaq')->middleware('jabatancheck');
        Route::post('/faqs/add', [Admin\FaqsController::class, 'addFaqsPost'])->name('admin.addfaqspost')->middleware('jabatancheck');
        Route::get('/faqs/edit/{id}', [Admin\FaqsController::class, 'editFaqs'])->name('admin.editfaq')->middleware('jabatancheck');
        Route::post('/faqs/edit/{id}', [Admin\FaqsController::class, 'editFaqsPost'])->name('admin.editfaqpost')->middleware('jabatancheck');
        // Route::get('/faqs/delete/{id}', [Admin\FaqsController::class, 'deleteUsers'])->name('admin.deleteuser')->middleware('jabatancheck');



        //History Perizinan
        Route::get('/historyperizinan/{id}', [Admin\HistoryPerizinanController::class, 'index'])->name('admin.historyperizinan')->middleware('jabatancheck');
        Route::get('/historyperizinanulo/{id}', [Admin\HistoryPerizinanController::class, 'ulo'])->name('admin.historyperizinanulo')->middleware('jabatancheck');
        
        //Master Holiday

        Route::resource('/masterholiday', 'MasterHolidayController');
        Route::get('/masterholiday/create', [Admin\MasterHolidayController::class, 'create'])->name('admin.masterholiday.create')->middleware('jabatancheck');
        Route::post('/masterholiday/store', [Admin\MasterHolidayController::class, 'store'])->name('admin.masterholiday.store')->middleware('jabatancheck');
        Route::post('/masterholiday/update/{id}', [Admin\MasterHolidayController::class, 'update'])->name('admin.masterholiday.update')->middleware('jabatancheck');
        Route::post('/masterholiday/delete/{id}', [Admin\MasterHolidayController::class, 'delete'])->name('admin.masterholiday.delete')->middleware('jabatancheck');
        Route::get('/masterholiday/edit/{id}', [Admin\MasterHolidayController::class, 'edit'])->name('admin.masterholiday.edit')->middleware('jabatancheck');
        Route::get('/masterholiday', [Admin\MasterHolidayController::class, 'index'])->name('admin.masterholiday')->middleware('jabatancheck');


        //Koordinator Evaluasi Registrasi
        Route::get('/koordinator', [Admin\KoordinatorController::class, 'index'])->name('admin.koordinator')->middleware('jabatancheck');
        Route::get('/koordinator/evaluasi-registrasi', [Admin\KoordinatorController::class, 'evaluasiRegistrasi'])->name('admin.koordinator.evaluasiregistrasi')->middleware('jabatancheck');
        Route::get('/koordinator/evaluasi-registrasi-p/{id}', [Admin\KoordinatorController::class, 'evaluasiRegistrasiProcess'])->name('admin.koordinator.evaluasiregistrasiprocess')->middleware('jabatancheck');
        Route::post('/koordinator/evaluasi-registrasi-post/{id}', [Admin\KoordinatorController::class, 'evaluasiRegistrasiPost'])->name('admin.koordinator.evaluasiregistrasipost')->middleware('jabatancheck');

        Route::get('/koordinator/jasa', [Admin\KoordinatorController::class, 'jasa'])->name('admin.koordinator.jasa')->middleware('jabatancheck'); //list jasa
        Route::get('/koordinator/jaringan', [Admin\KoordinatorController::class, 'jaringan'])->name('admin.koordinator.jaringan')->middleware('jabatancheck'); //list jaringan
        Route::get('/koordinator/telsus', [Admin\KoordinatorController::class, 'telsus'])->name('admin.koordinator.telsus')->middleware('jabatancheck'); //list telsus

        Route::get('/koordinator/evaluasi/{id}', [Admin\KoordinatorController::class, 'evaluasi'])->name('admin.koordinator.evaluasi')->middleware('jabatancheck');
        Route::post('/koordinator/evaluasipost/{id}', [Admin\KoordinatorController::class, 'evaluasiPost'])->name('admin.koordinator.evaluasipost')->middleware('jabatancheck');
        Route::post('/koordinator/evaluasipostpenolakan/{id}', [Admin\KoordinatorController::class, 'evaluasiPostPenolakan'])->name('admin.koordinator.evaluasipost.penolakan')->middleware('jabatancheck');
        Route::get('/koordinator/disposisi-penomoran/{id}', [Admin\KoordinatorController::class, 'disposisiPenomoran'])->name('admin.koordinator.disposisipenomoran')->middleware('jabatancheck');
        Route::get('/koordinator/disposisi/{id}', [Admin\KoordinatorController::class, 'disposisi'])->name('admin.koordinator.disposisi')->middleware('jabatancheck');
        Route::post('/koordinator/disposisiPost/{id}', [Admin\KoordinatorController::class, 'disposisiPost'])->name('admin.koordinator.disposisipost')->middleware('jabatancheck');
        Route::get('/koordinator/evaluasi-penomoran/{id}', [Admin\KoordinatorController::class, 'evaluasiPenomoran'])->name('admin.koordinator.evaluasipenomoran')->middleware('jabatancheck');
        Route::post('/koordinator/getLogIzin/', [Admin\KoordinatorController::class, 'getLogIzin'])->name('admin.koordinator.getlogizin')->middleware('jabatancheck');

        //KOORDINATOR ULO
        Route::get('/koordinator/ulo', [Admin\KoordinatorController::class, 'ulo'])->name('admin.koordinator.ulo')->middleware('jabatancheck');
        Route::get('/koordinator/ulo-jaringan', [Admin\KoordinatorController::class, 'uloJr'])->name('admin.koordinator.ulo-jaringan')->middleware('jabatancheck');
        Route::get('/koordinator/ulo-jasa', [Admin\KoordinatorController::class, 'uloJs'])->name('admin.koordinator.ulo-jasa')->middleware('jabatancheck');
        Route::get('/koordinator/ulo-telsus', [Admin\KoordinatorController::class, 'uloTelsus'])->name('admin.koordinator.ulo-telsus')->middleware('jabatancheck');
        Route::get('/koordinator/disposisi-ulo/{id}/{urut}', [Admin\KoordinatorController::class, 'disposisiUlo'])->name('admin.koordinator.disposisi-ulo')->middleware('jabatancheck');
        Route::post('/koordinator/disposisiUloPost/{id}/{urut}', [Admin\KoordinatorController::class, 'disposisiUloPost'])->name('admin.koordinator.disposisiulopost')->middleware('jabatancheck');
        Route::get('/koordinator/evaluasi-ulo/{id}/{urut}', [Admin\KoordinatorController::class, 'evaluasiUlo'])->name('admin.koordinator.evaluasi-ulo')->middleware('jabatancheck');
        Route::post('/koordinator/evaluasiulopost/{id}/{urut}', [Admin\KoordinatorController::class, 'evaluasiUloPost'])->name('admin.koordinator.evaluasiulopost')->middleware('jabatancheck');
        Route::post('/koordinator/evaluasiulopenolakan/{id}/{urut}', [Admin\KoordinatorController::class, 'evaluasiUloPostPenolakan'])->name('admin.koordinator.evaluasiulo.penolakan')->middleware('jabatancheck');

        //view penomoran
        Route::get('/koordinator/penomoran', [Admin\KoordinatorController::class, 'penomoran'])->name('admin.koordinator.penomoran')->middleware('jabatancheck');
        Route::get('/koordinator/disposisi-penomoran/{id}/{idkodeakses}', [Admin\KoordinatorController::class, 'disposisiPenomoran'])->name('admin.koordinator.disposisipenomoran')->middleware('jabatancheck');
        Route::post('/koordinator/disposisiPenomoranPost/{id}/{idkodeakses}', [Admin\KoordinatorController::class, 'disposisiPenomoranPost'])->name('admin.koordinator.disposisipenomoranpost')->middleware('jabatancheck');
        Route::get('/koordinator/evaluasi-penomoran/{id}/{idkodeakses}', [Admin\KoordinatorController::class, 'evaluasiPenomoran'])->name('admin.koordinator.evaluasipenomoran')->middleware('jabatancheck');
        Route::post('/koordinator/evaluasi-penomoran-post/{id}/{idkodeakses}', [Admin\KoordinatorController::class, 'evaluasiPenomoranPost'])->name('admin.koordinator.evaluasipenomoranpost')->middleware('jabatancheck');
        Route::post('/koordinator/evaluasi-penomoran-post-penolakan/{id}', [Admin\KoordinatorController::class, 'evaluasiPenomoranPenolakanPost'])->name('admin.koordinator.evaluasipenomoran.penolakan')->middleware('jabatancheck');
        // Route::get('/koordinator/penomoranca', [Admin\KoordinatorController::class, 'penomoranca'])->name('admin.koordinator.penomoranca')->middleware('jabatancheck');
        // Route::get('/koordinator/penomoranse', [Admin\KoordinatorController::class, 'penomoranse'])->name('admin.koordinator.penomoranse')->middleware('jabatancheck');
        // Route::get('/koordinator/penomoranpe', [Admin\KoordinatorController::class, 'penomoranpe'])->name('admin.koordinator.penomoranpe')->middleware('jabatancheck');
        // Route::get('/koordinator/penomorantambahan', [Admin\KoordinatorController::class, 'penomorantambahan'])->name('admin.koordinator.penomorantambahan')->middleware('jabatancheck');
        Route::get('/koordinator/semua-penomoran', [Admin\KoordinatorController::class, 'AllPenomoran'])->middleware('jabatancheck');
        // Route::get('/koordinator/semua-penetapan', [Admin\KoordinatorController::class, 'AllPenetapan'])->middleware('jabatancheck');
        Route::get('/koordinator/disposisi-penyesuaian/{id}', [Admin\KoordinatorController::class, 'disposisiPenyesuaian'])->name('admin.koordinator.disposisipenyesuaian')->middleware('jabatancheck');
        Route::post('/koordinator/disposisi-penyesuaian/{id}', [Admin\KoordinatorController::class, 'disposisiPenyesuaianPost'])->name('admin.koordinator.disposisipenyesuaianpost')->middleware('jabatancheck');
        Route::post('/koordinator/evaluasi-penyesuaianpost/{id}', [Admin\KoordinatorController::class, 'evaluasiPenyesuaianPost'])->name('admin.koordinator.evaluasi.penyesuaianpost')->middleware('jabatancheck');
        Route::get('/koordinator/evaluasi-penyesuaian/{id}', [Admin\KoordinatorController::class, 'evaluasiPenyesuaian'])->name('admin.koordinator.evaluasipenyesuaian')->middleware('jabatancheck');
        Route::get('/koordinator/pencabutan-penomoran/{id}', [Admin\KoordinatorController::class,
        'pencabutanPenomoran'])->name('admin.koordinator.cabutnomor')->middleware('jabatancheck');
        Route::post('/koordinator/evaluasi-pencabutanpenomoranPost/{id}', [Admin\KoordinatorController::class,
        'pencabutanPenomoranPost'])->name('admin.koordinator.evaluasi-pencabutanpenomoranPost')->middleware('jabatancheck');
        
        //Subkoordinator
        Route::get('/subkoordinator', [Admin\SubkoordinatorController::class, 'index'])->name('admin.subkoordinator')->middleware('jabatancheck');
        Route::get('/subkoordinator/jasa', [Admin\SubkoordinatorController::class, 'jasa'])->name('admin.subkoordinator.jasa')->middleware('jabatancheck');
        Route::get('/subkoordinator/jaringan', [Admin\SubkoordinatorController::class, 'jaringan'])->name('admin.subkoordinator.jaringan')->middleware('jabatancheck');
        Route::get('/subkoordinator/telsus', [Admin\SubkoordinatorController::class, 'telsus'])->name('admin.subkoordinator.telsus')->middleware('jabatancheck');
        Route::get('/subkoordinator/evaluasi/{id}', [Admin\SubkoordinatorController::class, 'evaluasi'])->name('admin.subkoordinator.evaluasi')->middleware('jabatancheck');
        Route::post('/subkoordinator/evaluasipost/{id}', [Admin\SubkoordinatorController::class, 'evaluasiPost'])->name('admin.subkoordinator.evaluasipost')->middleware('jabatancheck');
        
        Route::post('/subkoordinator/evaluasiregisterpostpenolakan/{id}', [Admin\SubkoordinatorController::class, 'evaluasiPostPenolakan'])->name('admin.subkoordinator.evaluasi.penolakan')->middleware('jabatancheck');
        Route::get('/subkoordinator/ulo-jaringan', [Admin\SubkoordinatorController::class, 'uloJr'])->name('admin.subkoordinator.ulo-jaringan')->middleware('jabatancheck');
        Route::get('/subkoordinator/ulo-jasa', [Admin\SubkoordinatorController::class, 'uloJs'])->name('admin.subkoordinator.ulo-jasa')->middleware('jabatancheck');
        Route::get('/subkoordinator/ulo-telsus', [Admin\SubkoordinatorController::class, 'uloTelsus'])->name('admin.subkoordinator.ulo-telsus')->middleware('jabatancheck');
        Route::get('/subkoordinator/evaluasi-ulo/{id}/{urut}', [Admin\SubkoordinatorController::class, 'evaluasiUlo'])->name('admin.subkoordinator.evaluasi-ulo')->middleware('jabatancheck');
        Route::post('/subkoordinator/evaluasiulopost/{id}/{urut}', [Admin\SubkoordinatorController::class,
        'evaluasiUloPost'])->name('admin.subkoordinator.evaluasiulopost')->middleware('jabatancheck');
        Route::get('/subkoordinator/ulo', [Admin\SubkoordinatorController::class, 'ulo'])->name('admin.subkoordinator.ulo')->middleware('jabatancheck');
        Route::post('/subkoordinator/evaluasiulopenolakan/{id}/{urut}', [Admin\SubkoordinatorController::class, 'evaluasiUloPostPenolakan'])->name('admin.subkoordinator.evaluasiulo.penolakan')->middleware('jabatancheck');
        Route::get('/subkoordinator/penomoran', [Admin\SubkoordinatorController::class, 'penomoran'])->name('admin.subkoordinator.penomoran')->middleware('jabatancheck');
        Route::get('/subkoordinator/evaluasi-penomoran/{id}', [Admin\SubkoordinatorController::class, 'evaluasiPenomoran'])->name('admin.subkoordinator.evaluasi-penomoran')->middleware('jabatancheck');
        Route::post('/subkoordinator/evaluasi-penomoranPost/{id}/{idkodeakses}', [Admin\SubkoordinatorController::class, 'evaluasiPenomoranPost'])->name('admin.subkoordinator.evaluasi-penomoranpost')->middleware('jabatancheck');
        Route::post('/subkoordinator/evaluasi-penomoranpenolakan/{id}', [Admin\SubkoordinatorController::class, 'evaluasiPenomoranPenolakanPost'])->name('admin.subkoordinator.evaluasipenomoran.penolakan')->middleware('jabatancheck');
        Route::post('/subkoordinator/evaluasi-penyesuaianpost/{id}', [Admin\SubkoordinatorController::class, 'evaluasiPenyesuaianPost'])->name('admin.subkoordinator.evaluasi.penyesuaianpost')->middleware('jabatancheck');
        Route::get('/subkoordinator/evaluasi-penyesuaian/{id}', [Admin\SubkoordinatorController::class, 'evaluasiPenyesuaian'])->name('admin.subkoordinator.evaluasipenyesuaian')->middleware('jabatancheck');
        Route::get('/subkoordinator/pencabutan-penomoran/{id}', [Admin\SubkoordinatorController::class,
        'pencabutanPenomoran'])->name('admin.subkoordinator.cabutnomor')->middleware('jabatancheck');
        Route::post('/subkoordinator/evaluasi-pencabutanpenomoranPost/{id}', [Admin\SubkoordinatorController::class,
        'pencabutanPenomoranPost'])->name('admin.subkoordinator.evaluasi-pencabutanpenomoranPost')->middleware('jabatancheck');

        //Evaluator
        Route::get('/evaluator', [Admin\EvaluatorController::class, 'index'])->name('admin.evaluator')->middleware('jabatancheck');
        Route::get('/evaluator/jasa', [Admin\EvaluatorController::class, 'jasa'])->name('admin.evaluator.jasa')->middleware('jabatancheck');
        Route::get('/evaluator/jaringan', [Admin\EvaluatorController::class, 'jaringan'])->name('admin.evaluator.jaringan')->middleware('jabatancheck');
        Route::get('/evaluator/telsus', [Admin\EvaluatorController::class, 'telsus'])->name('admin.evaluator.telsus')->middleware('jabatancheck');
        Route::get('/evaluator/evaluasi/{id}', [Admin\EvaluatorController::class, 'evaluasi'])->name('admin.evaluator.evaluasi')->middleware('jabatancheck');
        Route::post('/evaluator/evaluasipost/{id}', [Admin\EvaluatorController::class, 'evaluasiPost'])->name('admin.evaluator.evaluasipost')->middleware('jabatancheck');
        Route::get('/evaluator/evaluasi-penomoran/{id}', [Admin\EvaluatorController::class, 'evaluasiPenomoran'])->name('admin.evaluator.evaluasipe')->middleware('jabatancheck');
        Route::get('/evaluator/pencabutan-penomoran/{id}', [Admin\EvaluatorController::class,
        'pencabutanPenomoran'])->name('admin.evaluator.cabutnomor')->middleware('jabatancheck');
        Route::get('/evaluator/ulo-jaringan', [Admin\EvaluatorController::class, 'uloJr'])->name('admin.evaluator.ulo-jaringan')->middleware('jabatancheck');
        Route::get('/evaluator/ulo-jasa', [Admin\EvaluatorController::class, 'uloJs'])->name('admin.evaluator.ulo-jasa')->middleware('jabatancheck');
        Route::get('/evaluator/ulo-telsus', [Admin\EvaluatorController::class, 'uloTelsus'])->name('admin.evaluator.ulo-telsus')->middleware('jabatancheck');
        Route::get('/evaluator/evaluasi-ulo/{id}/{urut}', [Admin\EvaluatorController::class, 'evaluasiUlo'])->name('admin.evaluator.evaluasi-ulo')->middleware('jabatancheck');
        Route::get('/evaluator/tanggal-evaluasi-ulo/{id}/{urut}', [Admin\EvaluatorController::class, 'tanggalEvaluasiUlo'])->name('admin.evaluator.tanggal-evaluasi-ulo')->middleware('jabatancheck');
        Route::get('/evaluator/kirim-survey/{id}', [Admin\EvaluatorController::class, 'sendSurvey'])->name('admin.evaluator.kirim-survey')->middleware('jabatancheck');
        
        Route::post('/evaluator/hasilevaluasiulopost/{id}/{urut}', [Admin\EvaluatorController::class, 'saveHasilEvaluasiUlo'])->name('admin.evaluator.hasilevaluasiulopost')->middleware('jabatancheck');
        Route::post('/evaluator/evaluasiulopost/{id}/{urut}', [Admin\EvaluatorController::class, 'evaluasiUloPost'])->name('admin.evaluator.evaluasiulopost')->middleware('jabatancheck');
        Route::post('/evaluator/kirimulo/{id}/{urut}', [Admin\EvaluatorController::class, 'kirimemail'])->name('admin.evaluator.kirimemail')->middleware('jabatancheck');
        Route::post('/evaluator/tglevaluasiulopost/{id}/{urut}', [Admin\EvaluatorController::class, 'tglevaluasiUloPost'])->name('admin.evaluator.tglevaluasiulopost')->middleware('jabatancheck');
        Route::get('/evaluator/ulo', [Admin\EvaluatorController::class, 'ulo'])->name('admin.evaluator.ulo')->middleware('jabatancheck');

        Route::get('/evaluator/penomoran', [Admin\EvaluatorController::class, 'penomoran'])->name('admin.evaluator.penomoran')->middleware('jabatancheck');
        Route::get('/evaluator/evaluasi-penomoran/{id}/{idkodeakses}', [Admin\EvaluatorController::class, 'evaluasiPenomoran'])->name('admin.evaluator.evaluasi-penomoran')->middleware('jabatancheck');
        Route::post('/evaluator/evaluasi-penomoranPost/{id}/{idkodeakses}', [Admin\EvaluatorController::class, 
        'evaluasiPenomoranPost'])->name('admin.evaluator.evaluasi-penomoran-post')->middleware('jabatancheck');
        Route::post('/evaluator/evaluasi-pencabutanpenomoranPost/{id}', [Admin\EvaluatorController::class,
        'savepencabutanpenomoran'])->name('admin.evaluator.evaluasi-pencabutanpenomoranPost')->middleware('jabatancheck');
        Route::post('/evaluator/evaluasi-penomoranSave/{id}/{idkodeakses}', [Admin\EvaluatorController::class,
        'evaluasiPenomoranSave'])->name('admin.evaluator.evaluasi-penomoran-save')->middleware('jabatancheck');
        
        Route::post('/izin/evaluasi-registerpost/{id}', [Admin\EvaluatorController::class, 'evaluasiRegisterPost'])->name('admin.evaluator.evaluasiregisterpost');

        Route::get('/evaluator/evaluasi-penyesuaian/{id}', [Admin\EvaluatorController::class, 'evaluasiPenyesuaian'])->name('admin.evaluator.evaluasi.penyesuaian')->middleware('jabatancheck');
        Route::post('/evaluator/evaluasi-penyesuaianpost/{id}', [Admin\EvaluatorController::class, 'evaluasiPenyesuaianPost'])->name('admin.evaluator.evaluasi.penyesuaianpost')->middleware('jabatancheck');
        Route::get('/evaluator/evaluasi-penyesuaian/{id}', [Admin\EvaluatorController::class, 'evaluasiPenyesuaian'])->name('admin.evaluator.evaluasi.penyesuaian')->middleware('jabatancheck');
        Route::post('/update-bloknomor',[Admin\EvaluatorController::class,
        'updatebloknomor'])->middleware('jabatancheck');
        Route::post('/update-kodeakses',[Admin\EvaluatorController::class,
        'updatekodeakses'])->middleware('jabatancheck');
        Route::post('/disactivated-kodeakses',[Admin\EvaluatorController::class,
        'disactivatedkodeakses'])->middleware('jabatancheck');
        Route::post('/updateskinfo-kodeakses',[Admin\EvaluatorController::class,
        'updateskinfokodeakses'])->middleware('jabatancheck');
        Route::post('/updateskpencabutan-kodeakses',[Admin\EvaluatorController::class,
        'updateskpencabutankodeakses'])->middleware('jabatancheck');
        Route::get('/sk/draft/{id}/{urut}', [Admin\SkController::class,
        'draft'])->name('admin.sk.draft')->middleware('jabatancheck');
        Route::get('/sk/draftkomitmen/{id}', [Admin\SkController::class, 'draftPenetapanKomitmen'])->name('admin.sk.draftkomitmen')->middleware('jabatancheck');
        Route::get('/sk/cetakSKUlo/{id}/{urut}', [Admin\SkController::class, 'cetakSKUlo'])->name('admin.sk.cetakSKUlo')->middleware('jabatancheck');
        Route::get('/sk/cetakKomitmen/{id}', [Admin\SkController::class, 'cetakPenetapanKomitmen'])->name('admin.sk.cetakKomitmen')->middleware('jabatancheck');
        Route::get('/sk/draft-penomoran/{id}/{idkodeakses}', [Admin\SkController::class, 'draftPenomoran'])->name('admin.sk.draftpenomoran')->middleware('jabatancheck');
        Route::get('/sk/cetak-penomoran/{id}/{idkodeakses}', [Admin\SkController::class, 'cetakPenomoran'])->name('admin.sk.cetakpenomoran')->middleware('jabatancheck');
        Route::get('/sk/draft-penomoran-pencabutan/{id}', [Admin\SkController::class,
        'draftPenomoranPencabutan'])->name('admin.sk.draftpenomoranpencabutan')->middleware('jabatancheck');
        Route::get('/sk/draft-penomoran-pdf/{id}/{idkodeakses}', [Admin\SkController::class,
        'draftPenomoran'])->name('admin.sk.draftpenomoran-pdf')->middleware('jabatancheck');
        Route::get('/sk/draft-izin-prinsip-telsus/{id}', [Admin\SkController::class, 'draftIzinPrinsip'])->name('admin.sk.draftIzinPrinsip')->middleware('jabatancheck');
        Route::get('/sk/draft-izin-penyelenggaraan-telsus/{id}', [Admin\SkController::class, 'draftIzinPenyelenggaraan'])->name('admin.sk.draftIzinPenyelenggaraan')->middleware('jabatancheck');
        Route::get('/sk/draft-pencabutan-izin-penyelenggaraan-telsus/{id}', [Admin\SkController::class, 'draftIzinPencabutan'])->name('admin.sk.draftIzinPencabutan')->middleware('jabatancheck');
        Route::get('/sk/draft-perpanjangan-izin-penyelenggaraan-telsus/{id}', [Admin\SkController::class, 'draftIzinPerpanjangan'])->name('admin.sk.draftIzinPerpanjangan')->middleware('jabatancheck');
        
        
        Route::get('/pencabutan-penomoran', [Admin\PencabutanPenomoranController::class, 'index'])->name('admin.pencabutan-penomoran')->middleware('jabatancheck');
        Route::get('/pencabutan/{id}/{id_kodeakses}', [Admin\PencabutanPenomoranController::class, 'pencabutan'])->name('admin.pencabutan-penomoran-proses')->middleware('jabatancheck');
        Route::post('/pencabutanpost/{id}/{id_kodeakses}', [Admin\PencabutanPenomoranController::class, 'pencabutanPost'])->name('admin.pencabutanpost')->middleware('jabatancheck');
        Route::get('/history-penomoran', [Admin\PencabutanPenomoranController::class, 'historyPenomoran'])->name('admin.history-penomoran')->middleware('jabatancheck');
        Route::post('/rilispenomoranpost', [Admin\PencabutanPenomoranController::class, 'rilisPenomoranPost'])->name('admin.rilisPenomoranPost')->middleware('jabatancheck');

        Route::get('/semua-penomoran', [Admin\RekapController::class, 'AllPenomoran'])->name('admin.semua-penomoran')->middleware('jabatancheck');
        Route::get('/semua-penetapan', [Admin\RekapController::class, 'AllPenetapan'])->name('admin.semua-penetapan')->middleware('jabatancheck');
        Route::get('/penetapan-sklo', [Admin\RekapController::class, 'pentapanSKLO'])->name('admin.pentapan-sklo')->middleware('jabatancheck');
        Route::get('/laporan-log', [Admin\RekapController::class, 'AllLog'])->name('admin.laporan-log')->middleware('jabatancheck');
        Route::get('/laporan-register', [Admin\RekapController::class,
        'AllRegister'])->name('admin.laporan-register')->middleware('jabatancheck');
        Route::get('/rekapalokasi', [Admin\RekapController::class,
        'RekapAlokasi'])->name('admin.rekapalokasi')->middleware('jabatancheck');
        Route::get('/laporan-requestkbli', [Admin\RekapController::class, 'AllRequestKBLI'])->name('admin.laporan-requestkbli')->middleware('jabatancheck');
        Route::get('/laporan-disposisi', [Admin\RekapController::class, 'AllDisposisi'])->name('admin.laporan-disposisi')->middleware('jabatancheck');
        Route::get('/laporan-request', [Admin\RekapController::class, 'AllRequest'])->name('admin.laporan-request')->middleware('jabatancheck');
        Route::get('/view/{id}/{urut}', [Admin\RekapController::class, 'evaluasi'])->name('admin.view')->middleware('jabatancheck');
        Route::get('/updatenomor/{id}', [Admin\RekapController::class, 'UpdateNomor'])->name('admin.updatenomor')->middleware('jabatancheck');
        Route::post('/updatenomorpost', [Admin\RekapController::class, 'UpdateNomorPost'])->name('admin.updatenomorpost')->middleware('jabatancheck');
        Route::get('/rekappelakuusaha', [Admin\RekapController::class, 'RekapPelakuUsaha'])->name('admin.rekappelakuusaha')->middleware('jabatancheck');
        Route::get('/detailpelakuusaha/{id}', [Admin\RekapController::class, 'DetailPelakuUsaha'])->name('admin.detailpelakuusaha')->middleware('jabatancheck');

        
        
        Route::get('/svmgmt/create', [Admin\SurveyController::class, 'create'])->name('admin.svmgmt.create')->middleware('jabatancheck');
        Route::post('/svmgmt/store', [Admin\SurveyController::class, 'store'])->name('admin.svmgmt.store')->middleware('jabatancheck');
        Route::post('/svmgmt/update/{id}', [Admin\SurveyController::class, 'update'])->name('admin.svmgmt.update')->middleware('jabatancheck');
        Route::post('/svmgmt/delete/{id}', [Admin\SurveyController::class, 'delete'])->name('admin.svmgmt.delete')->middleware('jabatancheck');
        Route::get('/svmgmt/{id}/edit', [Admin\SurveyController::class, 'edit'])->name('admin.svmgmt.edit')->middleware('jabatancheck');
        Route::get('/svmgmt', [Admin\SurveyController::class, 'index'])->name('admin.svmgmt')->middleware('jabatancheck');
        Route::get('/svmgmt/{id}', [Admin\SurveyController::class, 'show'])->name('admin.svmgmt.show')->middleware('jabatancheck');
        Route::get('/svmgmt/preview/{id}', [Admin\SurveyController::class, 'preview'])->name('admin.svmgmt.preview')->middleware('jabatancheck');
        Route::post('/svmgmt/add-question/{id}', [Admin\SurveyController::class, 'addQuestion'])->name('admin.svmgmt.add-question');
        Route::get('/survey/dashboard', function () {
            return view('admin.survey.dashboard');
        });
        Route::get('/responder/list', [Admin\SurveyController::class, 'list'])->name('admin.responder.list');
        Route::get('/responder/view/{id}/{jenis}/{cat}', [Admin\SurveyController::class, 'viewResponder'])->name('admin.responder.view-responder');
        Route::get('/responder/{id}/edit', [Admin\SurveyController::class, 'getResponder'])->name('admin.responder.edit');
        Route::post('/responder/update/{id}', [Admin\SurveyController::class, 'updateResponder'])->name('admin.responder.update');

        Route::get('/qsmgmt/create', [Admin\QuestionController::class, 'create'])->name('admin.qsmgmt.create')->middleware('jabatancheck');
        Route::post('/qsmgmt/store', [Admin\QuestionController::class, 'store'])->name('admin.qsmgmt.store')->middleware('jabatancheck');
        Route::post('/qsmgmt/update/{id}', [Admin\QuestionController::class, 'update'])->name('admin.qsmgmt.update')->middleware('jabatancheck');
        Route::delete('/qsmgmt/delete/{id}', [Admin\QuestionController::class, 'destroy'])->name('admin.qsmgmt.delete')->middleware('jabatancheck');
        Route::get('/qsmgmt/edit/{id}', [Admin\QuestionController::class, 'edit'])->name('admin.qsmgmt.edit')->middleware('jabatancheck');
        Route::get('/qsmgmt', [Admin\QuestionController::class, 'index'])->name('admin.qsmgmt')->middleware('jabatancheck');
        Route::get('/qsmgmt/{id}', [Admin\QuestionController::class, 'show'])->name('admin.qsmgmt.show')->middleware('jabatancheck');

        Route::get('/bigdata/perizinan', [Admin\BigdataController::class, 'index'])->middleware('jabatancheck');
        Route::get('/bigdata/survey', [Admin\BigdataController::class, 'survey'])->middleware('jabatancheck');
        Route::get('/bigdata/survey-jastel', [Admin\BigdataController::class, 'surveyJastel'])->middleware('jabatancheck');
        Route::get('/bigdata/survey-jartel', [Admin\BigdataController::class, 'surveyJartel'])->middleware('jabatancheck');
        Route::get('/bigdata/survey-telsus', [Admin\BigdataController::class, 'surveyTelsus'])->middleware('jabatancheck');
        Route::get('/bigdata/survey-penomoran', [Admin\BigdataController::class, 'surveyPenomoran'])->middleware('jabatancheck');
        Route::get('/bigdata/survey-ulo', [Admin\BigdataController::class, 'surveyUlo'])->middleware('jabatancheck');
        
        Route::get('/bgdt-download', [Admin\BigdataController::class, 'export'])->middleware('jabatancheck');

        Route::get('/survei/manage', [Admin\SurveiController::class, 'index'])->middleware('jabatancheck');
        Route::post('/survei/manage', [Admin\SurveiController::class, 'post'])->name('admin.survei.post')->middleware('jabatancheck');
        Route::get('/survei/respond', [Admin\SurveiController::class, 'respond_list'])->name('admin.survei.respond_list')->middleware('jabatancheck');
        Route::get('/survei/result', [Admin\SurveiController::class, 'result_survei'])->name('admin.survei.result_survei')->middleware('jabatancheck');
        Route::get('/survei/preview', [Admin\SurveiController::class, 'preview'])->name('admin.survei.preview')->middleware('jabatancheck');
        Route::get('/survei/result/{id}', [Admin\SurveiController::class, 'result'])->name('admin.survei.result')->middleware('jabatancheck');

        Route::get('/download-data_respond_survei',  [Admin\ExcelController::class, 'data_respond_survei'])->name('download.data_respond_survei');
        Route::get('/download-data_respond_summary',  [Admin\ExcelController::class, 'data_respond_summary'])->name('download.data_respond_summary');
        Route::get('/download-data_alokasi_penomoran',  [Admin\ExcelController::class, 'data_alokasi_penomoran'])->name('download.data_alokasi_penomoran');
        Route::get('/download-req_penomoran',  [Admin\ExcelController::class, 'req_penomoran'])->name('download.req_penomoran');


    });
});


//Route::get('/dashboard', function () {
//    // return view('\layouts\backend\dashboard');
//    return view('\layouts\frontend\dashboard');
//})->middleware('auth');
// Route::get('/penomoran-baru', function () {
//     return view('\layouts\frontend\penomoran\penomoran-baru');
// });
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
// End - Front End

Route::get('/rekap-sklo',[App\Http\Controllers\RekapController::class, 'index'])->name('rekap-sklo');


Route::get('/mainpn/{nib}', [PermohonanPenomoranController::class, 'index']);
Route::get('/penomoran', function () {
    return view('layouts.frontend.penomoran.main_penomoran');
});

// Route::get('/penomoran-baru', [JenisPenomoranController::class, function(){
//     return view('layouts.frontend.penomoran.penomoran-baru');
// } ]);

// Route::get('/penomoran-ta', function () {
//     return view('layouts.frontend.penomoran.penomoran-tambahan');
// });

// Route::get('/penomoran-se', function () {
//     return view('layouts.frontend.penomoran.penomoran-se');
// });

// Route::get('/penomoran-pe', function () {
//     return view('layouts.frontend.penomoran.penomoran-pe');
// });

// Route::get('/penomoran-ca', function () {
//     return view('layouts.frontend.penomoran.penomoran-ca');
// });

Route::get('/jnsnmr/{jenisnomor_id}', [JenisPenomoranController::class, 'jnsnomor']);

// End - Front End - Penomoran
// Back End - Penomoran

Route::get('/evaluator-penomoran', function () {
    return view('\layouts\backend\dashboard-evaluator-penomoran');
});
Route::get('/penomoran-ca', function () {
    return view('\layouts\frontend\penomoran\penomoran-ca');
});


// End - Back End - Penomoran