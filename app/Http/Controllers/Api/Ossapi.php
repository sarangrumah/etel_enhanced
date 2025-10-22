<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Osshub;
use App\Models\Proyek;
use App\Helpers\UtilPerizinan;
use App\Models\Admin\Izinlog;
use App\Models\ApiLog;
use App\Models\Izin_oss;
use App\Models\Nib;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Auth;

class Ossapi extends Controller
{

    private $utilPerizinan;


    function __construct()
    {
        $this->util = new UtilPerizinan();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function receiveNIB(Request $req)
    {
        $respon = [
            'kode' => '200',
            'message' => "Data berhasil disimpan",
        ];
        $dataNIB = $req->dataNIB;
        $data['data_checklist'] = $dataNIB['data_checklist'];
        $data['data_proyek'] = $dataNIB['data_proyek'];

        // filter data izin di data_checklist yg sesuai dengan id_izin
        $data['data_checklist'] = array_filter($dataNIB['data_checklist'], function ($var) use ($dataNIB) {
            return ($var['id_izin'] == $dataNIB['id_izin']);
        });
        foreach ($data['data_checklist'] as $item) {
            $data['data_checklist'] = $item;
        }
        // end filter data izin yg sesuai dengan id_izin

        $data['id_proyek'] = $data['data_checklist']['id_proyek'];

        // filter data proyek sesuai id_proyek dari hasil filter datahcecklist
        $data['data_proyek'] = array_filter($dataNIB['data_proyek'], function ($var) use ($data) {
            return ($var['id_proyek'] == $data['id_proyek']);
        });
        foreach ($data['data_proyek'] as $item) {
            $data['data_proyek'] = $item;
        }
        // end filter data proyek
        // return json_encode($data);

        // Mulai Proses Insert
        try {
            // wait sebelum baca ini pastikan ngopi dulu ya biar ga panik ... 
            DB::beginTransaction();


            // proses data izin dulu ya bre takut nya dah pernah dikirim OSS
            $izin = Izin_oss::where('id_izin', $data['data_checklist']['id_izin'])->first();
            if ($izin) {
                if ($dataNIB['tipe_dokumen'] == '5') {
                    // do update
                    $izin->oss_id = $dataNIB['oss_id'];
                    $izin->kd_izin = $data['data_checklist']['kd_izin'];
                    $izin->kd_daerah = $data['data_checklist']['kd_daerah'];
                    $izin->nama_izin = $data['data_checklist']['nama_izin'];
                    $izin->id_bidang_spesifik = $data['data_checklist']['id_bidang_spesifik'];
                    $izin->bidang_spesifik = $data['data_checklist']['bidang_spesifik'];
                    $izin->id_kewenangan = $data['data_checklist']['id_kewenangan'];
                    $izin->parameter_kewenangan = $data['data_checklist']['parameter_kewenangan'];
                    $izin->kewenangan = $data['data_checklist']['kewenangan'];
                    $izin->flag_checklist = $data['data_checklist']['flag_checklist'];
                    $izin->status_checklist = $data['data_checklist']['00'];
                    $izin->status = $data['data_checklist']['00'];
                    $izin->jenis_izin = isset($data['data_checklist']['jenis_izin']) ? $data['data_checklist']['jenis_izin'] : (isset($izin->jenis_izin) ? $izin->jenis_izin : '');
                    $izin->save();
                } else {
                    $respon = [
                        'kode' => '406',
                        'message' => "Data sudah pernah diterima " . $izin->created,
                    ];
                    return response()->json(json_encode($respon), 406);
                }
            } else {
                //apapun tipe dok nya insert bae ajalah;
                $izin = new Izin_oss();
                $izin->oss_id = $dataNIB['oss_id'];
                $izin->id_proyek = $data['data_proyek']['id_proyek'];
                $izin->id_izin = $dataNIB['id_izin'];
                $izin->jenis_izin = isset($data['data_checklist']['jenis_izin']) ? $data['data_checklist']['jenis_izin'] : (isset($izin->jenis_izin) ? $izin->jenis_izin : '');
                $izin->kd_izin = $data['data_checklist']['kd_izin'];
                $izin->kd_daerah = $data['data_checklist']['kd_daerah'];
                $izin->nama_izin = $data['data_checklist']['nama_izin'];
                $izin->id_bidang_spesifik = $data['data_checklist']['id_bidang_spesifik'];
                $izin->bidang_spesifik = $data['data_checklist']['bidang_spesifik'];
                $izin->id_kewenangan = $data['data_checklist']['id_kewenangan'];
                $izin->parameter_kewenangan = $data['data_checklist']['parameter_kewenangan'];
                $izin->kewenangan = $data['data_checklist']['kewenangan'];
                $izin->flag_checklist = $data['data_checklist']['flag_checklist'];
                $izin->status_checklist = '00';
                $izin->status = '00';
                $izin->save();
            }
            // end proses data izin


            // ===CEK DULU NIB nya udah ada di db belum
            $nib = Nib::where('oss_id', $dataNIB['oss_id'])->first();
            if ($nib) {
                //jika ada nib do update
                $nib->tgl_terbit_nib = $dataNIB['tgl_terbit_nib'];
                $nib->tgl_perubahan_nib = $dataNIB['tgl_perubahan_nib'];
                $nib->oss_id = $dataNIB['oss_id'];
                $nib->jenis_pelaku_usaha = $dataNIB['jenis_pelaku_usaha'];
                $nib->nama_perseroan = $dataNIB['nama_perseroan'];
                $nib->nama_singkatan = $dataNIB['nama_singkatan'];
                $nib->jenis_perseroan = $dataNIB['jenis_perseroan'];
                $nib->status_perseroan = $dataNIB['status_perseroan'];
                $nib->alamat_perseroan = $dataNIB['alamat_perseroan'];
                $nib->rt_rw_perseroan = $dataNIB['rt_rw_perseroan'];
                $nib->kelurahan_perseroan = $dataNIB['kelurahan_perseroan'];
                $nib->perseroan_daerah_id = $dataNIB['perseroan_daerah_id'];
                $nib->kode_pos_perseroan = $dataNIB['kode_pos_perseroan'];
                $nib->nomor_telpon_perseroan = $dataNIB['nomor_telpon_perseroan'];
                $nib->email_perusahaan = $dataNIB['email_perusahaan'];
                $nib->no_pengesahan = $dataNIB['no_pengesahan'];
                $nib->tgl_pengesahan = $dataNIB['tgl_pengesahan'];
                $nib->status_nib = $dataNIB['status_nib'];
                $nib->tgl_pengajuan_nib = $dataNIB['tgl_pengajuan_nib'];
                // $nib->id_bidang_spesifik = $dataNIB['id_bidang_spesifik'];
                // $nib->bidang_spesifik = $dataNIB['bidang_spesifik'];
                $nib = $nib->save();
            } else {
                //jika tidak ada nib do insert
                $nib = Nib::create([
                    "nib" => $dataNIB['nib'],
                    "tgl_pengajuan_nib" => $dataNIB['tgl_pengajuan_nib'],
                    "tgl_terbit_nib" => $dataNIB['tgl_terbit_nib'],
                    "tgl_perubahan_nib" => $dataNIB['tgl_perubahan_nib'],
                    "oss_id" => $dataNIB['oss_id'],
                    "jenis_pelaku_usaha" => $dataNIB['jenis_pelaku_usaha'],
                    "nama_perseroan" => $dataNIB['nama_perseroan'],
                    "nama_singkatan" => $dataNIB['nama_singkatan'],
                    "jenis_perseroan" => $dataNIB['jenis_perseroan'],
                    "status_perseroan" => $dataNIB['status_perseroan'],
                    "alamat_perseroan" => $dataNIB['alamat_perseroan'],
                    "rt_rw_perseroan" => $dataNIB['rt_rw_perseroan'],
                    "kelurahan_perseroan" => $dataNIB['kelurahan_perseroan'],
                    "perseroan_daerah_id" => $dataNIB['perseroan_daerah_id'],
                    "kode_pos_perseroan" => $dataNIB['kode_pos_perseroan'],
                    "nomor_telpon_perseroan" => $dataNIB['nomor_telpon_perseroan'],
                    "email_perusahaan" => $dataNIB['email_perusahaan'],
                    "no_pengesahan" => $dataNIB['no_pengesahan'],
                    "tgl_pengesahan" => $dataNIB['tgl_pengesahan'],
                    "status_nib" => $dataNIB['status_nib'],
                    // "id_bidang_spesifik" => $dataNIB['id_bidang_spesifik'],
                    // "bidang_spesifik" => $dataNIB['bidang_spesifik'],
                ]);
            }
            // END PROSES NIB;

            // PROSES INSERT PROYEK BRO
            $proyek = Proyek::where('id_proyek', $data['id_proyek'])->first();

            if ($proyek) {
                //kalo ada proyek nya 
                $proyek->oss_id = $dataNIB['oss_id'];
                $proyek->id_proyek = $data['id_proyek'];
                $proyek->nomor_proyek = "-";
                $proyek->kbli = $data['data_proyek']['kbli'];
                $proyek->uraian = $data['data_proyek']['uraian_usaha'];
                $proyek->uraian = $data['data_proyek']['id_bidang_spesifik'];
                $proyek->uraian = $data['data_proyek']['bidang_spesifik'];
                $proyek->save();
            } else {
                // kalo ga ada proyek nya
                $proyek = Proyek::create([
                    "oss_id" => $dataNIB['oss_id'],
                    "id_proyek" => $data['id_proyek'],
                    "nomor_proyek" => "-",
                    "kbli" => $data['data_proyek']['kbli'],
                    "uraian" => $data['data_proyek']['uraian_usaha'],
                    "id_bidang_spesifik" => $data['data_proyek']['id_bidang_spesifik'],
                    "bidang_spesifik" => $data['data_proyek']['bidang_spesifik']
                ]);
            }
            // ENd proses data proyek
            // PROSES LOG
            // prose LOG disini

            $log = ApiLog::create([
                'state' => 'receive',
                'service' => '/receiveNIB',
                'param' => json_encode($dataNIB),
                'respon' => json_encode($respon)
            ]);
            // end log
            DB::commit();
            return response()->json($respon);
        } catch (\Throwable $th) {
            DB::rollBack();
            $respon = [
                'kode' => '500',
                'message' => $th->getMessage(),
            ];
            $log = ApiLog::create([
                'state' => 'receive',
                'service' => '/receiveNIB',
                'param' => json_encode($dataNIB),
                'respon' => json_encode($respon)
            ]);
            return response()->json(json_encode($respon), 500);
        }
    }

    public function receiveFileDS(Request $req)
    {
    }

    public function SSO(Request $req)
    {
        $ref = $req->query('ref');
        
        if ($ref) {
            $osshub = new Osshub();
            $valet = $osshub->fetchValet($ref);
            $valet = isset($valet->data) ? $valet->data->user : [];

            if (isset($valet->data_nib[0])) {
                //check NIB exist
                $CekNibTable = Nib::where(['nib' => $valet->data_nib[0]])->get();
                if ($CekNibTable->count() > 0) {
                    //get user by email 
                    $user = User::firstWhere('email', $valet->email);
                    if ($user) {
                        Auth::login($user);
                    } else {
                        //UPDATE EMAIL
                        return true;
                    }
                }
                return redirect('/register')->with('valet', $valet);
            }
        }

        return redirect('/login');
    }

    public function validateToken(Request $req)
    {
        return json_encode($req->all());
    }

    // call set remote credential
    public function connecthub()
    {
        $hub = new Osshub;
        return $hub->connect_to_osshub();
    }
}
