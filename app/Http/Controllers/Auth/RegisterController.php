<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;
use App\Helpers\Osshub;
use App\Models\Izin_oss;
use App\Models\Nib;
use App\Models\Proyek;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // dd($data);
        return Validator::make($data, [
            'jenis_pu' => ['required'],
            // 'nib' => ['required', 'min:13', 'max:13'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data = [])
    {
        // dd($data);
        $cekTableNib = $this->cekNibTable($data['nib'], $data['name_pt']);

        // dd($cekTableNib,$data);
        if ($cekTableNib) {
            // DB::beginTransaction();
            // dd($data['jenis_pu']);
            // try {
            if ($data['jenis_pu'] === 'PTB') {
                // $nib = $this->ceknib($data['nib']);
                // if (!$nib) {
                // throw ValidationException::withMessages(['nib' => 'Nib Tidak ditemukan']);
                // }

                // $nib = $nib->dataNIB;
                // $proyek = $nib->data_proyek;
                // $izin = $nib->data_checklist;

                // $cekTableNib = $this->cekNibTable($nib);

                // if ($cekTableNib) {
                // $insertnib = $this->insertNIB($nib);
                // $insertproyek = $this->insertProyek($proyek, $nib->oss_id);
                // }

                // $temp_id_izin = '';
                // foreach ($izin as $iz) {
                // if ($temp_id_izin != $iz->id_izin) {
                // unset($iz->data_persyaratan);
                // $iz->oss_id = $nib->oss_id;
                // Izin_oss::create((array) $iz);
                // }
                // $temp_id_izin = $iz->id_izin;
                // }

                $maxId = User::latest()->where('oss_id', 'LIKE', '%PTB%')->get()->count();
                // dd($maxId);
                if ($maxId > 0) {
                    // $maxId = preg_replace('/[^1-9]/', '', $maxId->oss_id);
                    // $maxId = 'IP-' . str_pad($maxId + 1, 5, "0", STR_PAD_LEFT);
                    $maxId = 'PTB-' . date('Ymd') . sprintf("%04s", $maxId + 1);
                } else {
                    $maxId = 'PTB-' . date('Ymd') . sprintf("%04s", 1);
                }

                $nib = new Nib();
                $nib->oss_id = $maxId;
                $nib->status_nib = '02';
                $nib->status_badan_hukum = '01';
                $nib->nib = $data['nib'];
                // $nib->nama_perseroan = $data['nib'];
                $nib->save();

                Session::put('message', 'Registrasi Berhasil. Silakan akses akun Anda dan lakukan Kelengkapan Data');
            } elseif ($data['jenis_pu'] === 'PTP') {

                $maxId = User::latest()->where('oss_id', 'LIKE', '%PTP%')->get()->count();
                // dd($maxId);
                if ($maxId > 0) {
                    // $maxId = preg_replace('/[^1-9]/', '', $maxId->oss_id);
                    // $maxId = 'IP-' . str_pad($maxId + 1, 5, "0", STR_PAD_LEFT);
                    $maxId = 'PTP-' . date('Ymd') . sprintf("%04s", $maxId + 1);
                } else {
                    $maxId = 'PTP-' . date('Ymd') . sprintf("%04s", 1);
                }

                $nib = new Nib();
                $nib->oss_id = $maxId;
                $nib->status_nib = '02';
                $nib->status_badan_hukum = '04';
                $nib->nib = $data['nib'];
                // $nib->nama_perseroan = $data['nib'];
                $nib->save();

                Session::put('message', 'Registrasi Berhasil. Silakan akses akun Anda dan lakukan Kelengkapan Data');
            } elseif ($data['jenis_pu'] === 'TKB') {

                $maxId = User::latest()->where('oss_id', 'LIKE', '%TKB%')->get()->count();
                // dd($maxId);
                if ($maxId > 0) {
                    // $maxId = preg_replace('/[^1-9]/', '', $maxId->oss_id);
                    // $maxId = 'IP-' . str_pad($maxId + 1, 5, "0", STR_PAD_LEFT);
                    $maxId = 'TKB-' . date('Ymd') . sprintf("%04s", $maxId + 1);
                } else {
                    $maxId = 'TKB-' . date('Ymd') . sprintf("%04s", 1);
                }

                $nib = new Nib();
                $nib->oss_id = $maxId;
                $nib->status_nib = '02';
                $nib->status_badan_hukum = '05';
                $nib->nib = $data['nib'];
                // $nib->nama_perseroan = $data['nib'];
                $nib->save();

                Session::put('message', 'Registrasi Berhasil. Silakan akses akun Anda dan lakukan Kelengkapan Data');
            } elseif ($data['jenis_pu'] === 'TKI') {

                $maxId = User::latest()->where('oss_id', 'LIKE', '%TKI%')->get()->count();
                // dd($maxId);
                if ($maxId > 0) {
                    // $maxId = preg_replace('/[^1-9]/', '', $maxId->oss_id);
                    // $maxId = 'IP-' . str_pad($maxId + 1, 5, "0", STR_PAD_LEFT);
                    $maxId = 'TKI-' . date('Ymd') . sprintf("%04s", $maxId + 1);
                } else {
                    $maxId = 'TKI-' . date('Ymd') . sprintf("%04s", 1);
                }

                $nib = new Nib();
                $nib->oss_id = $maxId;
                $nib->status_nib = '02';
                $nib->status_badan_hukum = '02';
                $nib->nib = $data['name_pt'];
                // $nib->nama_perseroan = $data['nib'];
                $nib->save();

                Session::put('message', 'Registrasi Berhasil. Silakan akses akun Anda dan lakukan Kelengkapan Data');
            } elseif ($data['jenis_pu'] === 'NPT') {

                $maxId = User::latest()->where('oss_id', 'LIKE', '%NPT%')->get()->count();
                // dd($maxId);
                if ($maxId > 0) {
                    // $maxId = preg_replace('/[^1-9]/', '', $maxId->oss_id);
                    // $maxId = 'IP-' . str_pad($maxId + 1, 5, "0", STR_PAD_LEFT);
                    $maxId = 'NPT-' . date('Ymd') . sprintf("%04s", $maxId + 1);
                } else {
                    $maxId = 'NPT-' . date('Ymd') . sprintf("%04s", 1);
                }

                $nib = new Nib();
                $nib->oss_id = $maxId;
                $nib->status_nib = '02';
                $nib->status_badan_hukum = '03';
                $nib->nib = $data['name_pt'];
                // $nib->nama_perseroan = $data['nib'];

                $nib->save();

                Session::put('message', 'Registrasi Berhasil. Silakan akses akun Anda dan lakukan Kelengkapan Data');
            }

            $users = User::create([
                'oss_id' => $maxId,
                'jenis_pu' => $data['jenis_pu'],
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            // DB::commit();

            // $izin_status = [
            // "nib" => $nib->nib,
            // "id_produk" => $nib->id_produk,
            // "id_proyek" => $nib->id_proyek,
            // "oss_id" => $nib->oss_id,
            // "id_izin" => $nib->id_izin,
            // "kd_izin" => $nib->kd_izin,
            // "kd_instansi" => '',
            // "kd_status" => '20',
            // "tgl_status" => date('Y-m-d h:i:s'),
            // "nip_status" => '',
            // "nama_status" => '',
            // "keterangan" => '',
            // "data_pnbp" => [
            // "kd_akun" => '',
            // "kd_penerimaan" => '',
            // "kd_billing" => '',
            // "tgl_billing" => '',
            // "tgl_expire" => '',
            // "nominal" => '',
            // "url_dokumen" => ''
            // ]
            // ];

            return $users;
            // } catch (\Exception $e) {
            // // DB::rollback();
            // // dd($e);
            // throw ValidationException::withMessages(['nib' => 'Gagal mendaftarkan users']);
            // }
        } else {
            $message = 'Mohon maaf proses registrasi tidak berhasil dilakukan, NIB / Nama Perusahaan / Instansi telah terdaftar';
            session(['message' => 'Mohon maaf proses registrasi tidak berhasil dilakukan, NIB / Nama Perusahaan / Instansi telah terdaftar']);
            // redirect()->route('login')->with('message', 'Mohon maaf proses registrasi tidak berhasil dilakukan, NIB / Nama Perusahaan / Instansi telah terdaftar');
            return view('auth.login', compact('message'));
        }
    }

    function ceknib($nib)
    {
        $osshub = new Osshub();
        // $datanib = $osshub->inqueryNIB('8120108952445');
        $datanib = $osshub->inqueryNIB($nib);
        if (isset($datanib->responinqueryNIB)) {
            return $datanib->responinqueryNIB;
        } else {
            return false;
        }
    }

    function cekNibTable($nib, $name_pt)
    {
        if (isset($nib)) {

            $CekNibTable = Nib::where(['nib' => $nib])->get();
            if ($CekNibTable->count() > 0) {
                return false;
            } else {
                return true;
            }
        }else{

            $CekNibTable = Nib::where(['nama_perseroan' => $name_pt])->get();
            if ($CekNibTable->count() > 0) {
                return false;
            } else {
                return true;
            }

        }
    }

    function insertNIB($nibdata)
    {
        // BUAT KONDISI CEK NIB
        $nib = new Nib();
        $nib->nib = $nibdata->nib;
        $nib->tgl_pengajuan_nib = $nibdata->tgl_pengajuan_nib;
        $nib->tgl_terbit_nib = $nibdata->tgl_terbit_nib;
        $nib->tgl_perubahan_nib = $nibdata->tgl_perubahan_nib;
        $nib->oss_id = $nibdata->oss_id;
        $nib->jenis_pelaku_usaha = $nibdata->jenis_pelaku_usaha;
        $nib->status_badan_hukum = $nibdata->status_badan_hukum;
        $nib->npwp_perseroan = $nibdata->npwp_perseroan;
        $nib->nama_perseroan = $nibdata->nama_perseroan;
        $nib->nama_singkatan = $nibdata->nama_singkatan;
        $nib->jenis_perseroan = $nibdata->jenis_perseroan;
        $nib->status_perseroan = $nibdata->status_perseroan;
        $nib->alamat_perseroan = $nibdata->alamat_perseroan;
        $nib->kelurahan_perseroan = $nibdata->kelurahan_perseroan;
        $nib->perseroan_daerah_id = $nibdata->perseroan_daerah_id;
        $nib->kode_pos_perseroan = $nibdata->kode_pos_perseroan;
        $nib->nomor_telpon_perseroan = $nibdata->nomor_telpon_perseroan;
        $nib->email_perusahaan = $nibdata->email_perusahaan;
        $nib->flag_umk = $nibdata->flag_umk;
        $nib->no_pengesahan = $nibdata->no_pengesahan;
        $nib->tgl_pengesahan = $nibdata->tgl_pengesahan;
        $nib->status_nib = $nibdata->status_nib;
        // $nib->id_bidang_spesifik = $nibdata->id_bidang_spesifik;
        // $nib->bidang_spesifik = $nibdata->bidang_spesifik;
        return $nib->save();
    }

    function insertProyek($proyek, $oss_id)
    {
        foreach ($proyek as $pr) {
            $dbproyek = new Proyek();
            $dbproyek->oss_id = $oss_id;
            $dbproyek->id_proyek = $pr->id_proyek;
            $dbproyek->nomor_proyek = $pr->nomor_proyek;
            $dbproyek->kbli = $pr->kbli;
            $dbproyek->uraian = $pr->uraian_usaha;
            // $dbproyek->id_bidang_spesifik = $pr->id_bidang_spesifik;
            // $dbproyek->bidang_spesifik = $pr->bidang_spesifik;
            $dbproyek->save();
        }
        return true;
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        // $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect('/');
    }
}
