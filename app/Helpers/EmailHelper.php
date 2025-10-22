<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\Admin\Izin;
use App\Models\Admin\Ulo;
use App\Mail\Sendmail;
use Carbon\Carbon;
use App\Helpers\DateHelper;
use App\Helpers\CommonHelper;
use Illuminate\Support\Facades\Mail;

class EmailHelper{
    
	public function kirim_email($penanggungjawab,$email_jenis,$izin,$departemen,$catatan_hasil_evaluasi,$nama2 =
	'',$nib,$is_koreksi = 0,$attachfile = '', $link = '', $attachfile2 = '', $attachfile3 = ''){

        $datenow = Carbon::now();
        $date_format = new DateHelper();
        $date = $date_format->dateday_lang_reformat_long($datenow);

        // dd($izin);
        // dd($penanggungjawab['email_user_proses']);
        if (substr($izin['id_izin'], 0, 3) != 'NEV') {
            $email_data['email'] =
            isset($penanggungjawab['email_user_proses'])?$penanggungjawab['email_user_proses']:'';
            $email_data['nama'] = isset($penanggungjawab['nama_user_proses'])?$penanggungjawab['nama_user_proses']:'';
        } elseif (substr($izin['id_izin'], 0, 3) == 'NEV') {
            $email_data['email'] =
            isset($penanggungjawab['email_user_proses'])?$penanggungjawab['email_user_proses']:'';
            $email_data['nama'] = isset($penanggungjawab['nama_user_proses'])?$penanggungjawab['nama_user_proses']:'';
        } else {
            $email_data['email'] =
            isset($penanggungjawab['email_user_proses'])?$penanggungjawab['email_user_proses']:'';
            $email_data['nama'] = isset($penanggungjawab['nama_user_proses'])?$penanggungjawab['nama_user_proses']:'';
        }
        
        $email_data['nama'] = isset($penanggungjawab['nama_user_proses'])?$penanggungjawab['nama_user_proses']:'';
        $email_data['jenis'] = $email_jenis;
        $email_data['izin'] = $izin;
        $email_data['nib'] = $izin;
        $check_badanhukum = DB::table('vw_jenisbadanhukum')->select('*')->where('nib','=',$email_data['izin']['nib'])->first();
        // dd($email_data['izin']);
        if (isset($check_badanhukum->oss_kode)) {
            if ($check_badanhukum->oss_kode == '02' || $check_badanhukum->oss_kode == '03') {
                if (isset($email_data['izin']['nib'])) {
                    $email_data['izin']['nib'] = NULL;
                }     
            }
        }else{
            $email_data['izin']['nib'] = NULL;
        }

        if (substr($izin['id_izin'], 0, 3) != 'NEV') {
            $email_data['email'] =
            isset($penanggungjawab['email_user_proses'])?$penanggungjawab['email_user_proses']:'';
            $email_data['nama'] = isset($penanggungjawab['nama_user_proses'])?$penanggungjawab['nama_user_proses']:'';
        } elseif (substr($izin['id_izin'], 0, 3) == 'NEV') {
            if (isset($email_data['izin']['email_institusi_ulang'])) {
                $email_data['email'] = 
                isset($email_data['izin']['email_institusi_ulang'])?$email_data['izin']['email_institusi_ulang']:'';
                $email_data['nama'] = 'Admin';
            } else {
                $email_data['email'] = 
                isset($email_data['izin']['email_institusi_ulang'])?$email_data['izin']['email_institusi_ulang']:'';
                $email_data['nama'] = isset($penanggungjawab['nama_user_proses'])?$penanggungjawab['nama_user_proses']:'';
            }
            
        } else {
            $email_data['email'] =
            isset($penanggungjawab['email_user_proses'])?$penanggungjawab['email_user_proses']:'';
            $email_data['nama'] = isset($penanggungjawab['nama_user_proses'])?$penanggungjawab['nama_user_proses']:'';
        }
        
        $email_data['departemen'] = $departemen;
        $email_data['is_koreksi'] = $is_koreksi;
        $email_data['catatan'] = $catatan_hasil_evaluasi;
        $email_data['nama2'] = $nama2;
        $email_data['attach'] = $attachfile;
        $email_data['attach2'] = $attachfile2;
        $email_data['attach3'] = $attachfile3;
        $email_data['link_survey'] = $link;
        // $email_data['tanggal_permohonan'] = isset($izin['updated_at']) ?
        // $date_format->dateday_lang_reformat_long($izin['updated_at']) :
        // $date_format->dateday_lang_reformat_long($izin['updated_date']);
        $email_data['tanggal_permohonan'] = isset($izin['submitted_date']) ?
        $date_format->dateday_lang_reformat_long($izin['submitted_date']) : '' ;
        // $email_data['tanggal_permohonan'] = $date_format->dateday_lang_reformat_long($izin['updated_at']);  
        $email_data['updated_date'] = isset($izin['updated_date']) ? $date_format->dateday_lang_reformat_long($izin['updated_date']) : '' ;
        $email_data['date'] = $date;  
        // dd($departemen);

        $email_data['tgl_permohonan'] = $date_format->dateday_lang_reformat_long($izin['tgl_permohonan']);
        
            // dd($email_data['tgl_permohonan'],$izin['submitted_date'],$izin['tgl_permohonan'],$email_data['tanggal_permohonan']);
        //ulo
        // $tipe_ulo = isset($izin['tipe_ulo']) ? ($izin['tipe_ulo'] == 1 ? 'Uji Petik' : ($izin['tipe_ulo'] == 2 ? 'Penilaian Mandiri' : '')) : '';
        $status_laik = isset($izin['status_laik']) ? ($izin['status_laik'] == 1 ? 'Laik' : 'Tidak Laik') : '';
        // $email_data['tipe_ulo'] = $tipe_ulo;
        $email_data['updated_at_ulo'] = isset($izin['updated_at_ulo']) ? $izin['updated_at_ulo'] : "";
        $email_data['tipe_ulo'] = isset($ulo['tipe_ulo'])?$ulo['tipe_ulo']:'';
        if (isset($izin['tipe_ulo'])) {
            if ($izin['tipe_ulo'] == 1){
                $email_data['tipe_ulo_name'] = 'Uji Petik';
            }elseif($izin['tipe_ulo'] == 2){
                $email_data['tipe_ulo_name'] = 'Penilaian Mandiri';
            }else{
                $email_data['tipe_ulo_name'] = '';
            }
        } else {
            $email_data['tipe_ulo_name'] = '';
        }
        // dd($email_data['tipe_ulo'],$email_data['tipe_ulo_name']);S
        
        // $email_data['tipe_ulo_name'] = isset($ulo['tipe_ulo'])?($izin['tipe_ulo'] == 1 ? 'Uji Petik' : ($izin['tipe_ulo'] == 2 ? 'Penilaian Mandiri' : '')) : '';
        $email_data['status_laik'] = $status_laik;
        $email_data['tgl_pengajuan_ulo'] = isset($izin['tgl_pengajuan_ulo']) ? $date_format->dateday_lang_reformat_long($izin['tgl_pengajuan_ulo']):'';
        $email_data['tgl_submit'] = isset($izin['tgl_submit']) ? $date_format->dateday_lang_reformat_long($izin['tgl_submit']) : '';  
        //end
        
       //penomoran
        $email_data['kode_akses'] =  isset($departemen['kode_akses']) ? $departemen['kode_akses'] : "";
        $email_data['full_kode_akses'] =  isset($departemen['full_kode_akses']) ? $departemen['full_kode_akses'] : "";
        $email_data['nomor_kodeakses'] =  isset($departemen['availno']) ? $departemen['availno'] : "";
        $email_data['prefix'] = isset($departemen['prefix']) ? $departemen['prefix'] : "";
        $email_data['jenis_penomoran'] = isset($departemen['jenis_penomoran']) ? $departemen['jenis_penomoran'] : "";
        $email_data['jenis_permohonan'] = isset($departemen['jenis_permohonan']) ? $departemen['jenis_permohonan'] : "";
        //end
        // dd($email_data);/
        if ($email_data['email'] != '') {
            $kirimemail = \Mail::to($email_data['email'])->send(new \App\Mail\Sendmail($email_data));
        }

	}
    public function kirim_email_tolak($penanggungjawab,$email_jenis,$izin,$departemen,$catatan_hasil_evaluasi,$nama2 =
	'',$nib,$is_koreksi = 0,$attachfile = '', $link = '', $attachfile2 = '', $attachfile3 = '',$catatan_koreksi){

	$datenow = Carbon::now();
	$date_format = new DateHelper();
	$date = $date_format->dateday_lang_reformat_long($datenow);

	// dd($izin);
	// dd($penanggungjawab['email_user_proses']);
	$email_data['email'] = isset($penanggungjawab['email_user_proses'])?$penanggungjawab['email_user_proses']:'';
	$email_data['nama'] = isset($penanggungjawab['nama_user_proses'])?$penanggungjawab['nama_user_proses']:'';
	$email_data['jenis'] = $email_jenis;
	$email_data['izin'] = $izin;
    $email_data['nib'] = $izin;
    
    $check_badanhukum = DB::table('vw_jenisbadanhukum')->select('*')->where('nib','=',$email_data['izin']['nib'])->first();
    // if ($check_badanhukum->oss_kode == '02' || $check_badanhukum->oss_kode == '03') {
    //     if (isset($email_data['izin']['nib'])) {
    //         $email_data['izin']['nib'] = NULL;
    //     }
    // }
    if (isset($check_badanhukum->oss_kode)) {
        if ($check_badanhukum->oss_kode == '02' || $check_badanhukum->oss_kode == '03') {
            if (isset($email_data['izin']['nib'])) {
                $email_data['izin']['nib'] = NULL;
            }     
        }
    }else{
        $email_data['izin']['nib'] = NULL;
    }
	$email_data['departemen'] = $departemen;
	$email_data['is_koreksi'] = $is_koreksi;
	$email_data['catatan'] = $catatan_hasil_evaluasi;
	$email_data['catatan_koreksi'] = $catatan_koreksi;
	$email_data['nama2'] = $nama2;
	$email_data['attach'] = $attachfile;
	$email_data['attach2'] = $attachfile2;
	$email_data['attach3'] = $attachfile3;

	$email_data['link_survey'] = $link;
	// $email_data['tanggal_permohonan'] = isset($izin['updated_at']) ?
	// $date_format->dateday_lang_reformat_long($izin['updated_at']) :
	// $date_format->dateday_lang_reformat_long($izin['updated_date']);
	$email_data['tanggal_permohonan'] = isset($izin['submitted_date']) ?
	$date_format->dateday_lang_reformat_long($izin['submitted_date']) : '' ;
	// $email_data['tanggal_permohonan'] = $date_format->dateday_lang_reformat_long($izin['updated_at']);
	$email_data['updated_date'] = isset($izin['updated_date']) ?
	$date_format->dateday_lang_reformat_long($izin['updated_date']) : '' ;
	$email_data['date'] = $date;
	// dd($departemen);

	$email_data['tgl_permohonan'] = $date_format->dateday_lang_reformat_long($izin['tgl_permohonan']);

	// dd($email_data['tgl_permohonan'],$izin['submitted_date'],$izin['tgl_permohonan'],$email_data['tanggal_permohonan']);
	//ulo
	// $tipe_ulo = isset($izin['tipe_ulo']) ? ($izin['tipe_ulo'] == 1 ? 'Uji Petik' : ($izin['tipe_ulo'] == 2 ? 'PenilaianMandiri' : '')) : '';	
    $status_laik = isset($izin['status_laik']) ? ($izin['status_laik'] == 1 ? 'Laik' : 'Tidak Laik') : '';
	// $email_data['tipe_ulo'] = $tipe_ulo;
	$email_data['updated_at_ulo'] = isset($izin['updated_at_ulo']) ? $izin['updated_at_ulo'] : "";
	$email_data['tipe_ulo'] = isset($ulo['tipe_ulo'])?$ulo['tipe_ulo']:'';
	if (isset($izin['tipe_ulo'])) {
	if ($izin['tipe_ulo'] == 1){
	$email_data['tipe_ulo_name'] = 'Uji Petik';
	}elseif($izin['tipe_ulo'] == 2){
	$email_data['tipe_ulo_name'] = 'Penilaian Mandiri';
	}else{
	$email_data['tipe_ulo_name'] = '';
	}
	} else {
	$email_data['tipe_ulo_name'] = '';
	}
	// dd($email_data['tipe_ulo'],$email_data['tipe_ulo_name']);S

	// $email_data['tipe_ulo_name'] = isset($ulo['tipe_ulo'])?($izin['tipe_ulo'] == 1 ? 'Uji Petik' : ($izin['tipe_ulo'] ==2 ? 'Penilaian Mandiri' : '')) : '';
	$email_data['status_laik'] = $status_laik;
	$email_data['tgl_pengajuan_ulo'] = isset($izin['tgl_pengajuan_ulo']) ?
	$date_format->dateday_lang_reformat_long($izin['tgl_pengajuan_ulo']):'';
	$email_data['tgl_submit'] = isset($izin['tgl_submit']) ? $date_format->dateday_lang_reformat_long($izin['tgl_submit'])
	: '';
	//end

	//penomoran
	$email_data['kode_akses'] = isset($departemen['kode_akses']) ? $departemen['kode_akses'] : "";
	$email_data['full_kode_akses'] = isset($departemen['full_kode_akses']) ? $departemen['full_kode_akses'] : "";
	$email_data['nomor_kodeakses'] = isset($departemen['availno']) ? $departemen['availno'] : "";
	$email_data['prefix'] = isset($departemen['prefix']) ? $departemen['prefix'] : "";
	$email_data['jenis_penomoran'] = isset($departemen['jenis_penomoran']) ? $departemen['jenis_penomoran'] : "";
	$email_data['jenis_permohonan'] = isset($departemen['jenis_permohonan']) ? $departemen['jenis_permohonan'] : "";
	//end
	// dd($email_data);
	if ($email_data['email'] != '') {
	$kirimemail = \Mail::to($email_data['email'])->send(new \App\Mail\Sendmail($email_data));
	}

	}
    
    public function kirim_email2($user,$email_jenis,$izin,$departemen,$catatan_hasil_evaluasi,$nama2 = '',$nib,$is_koreksi = 0,$jabatan){
        // dd($izin);
        $datenow = Carbon::now();
        $date_format = new DateHelper();
        $date = $date_format->dateday_lang_reformat_long($datenow);
        // dd($nama2);
		$email_data['email'] = isset($user['email'])?$user['email']:'';
        // dd($email_data['email']);
        $email_data['nama'] = isset($user['nama'])?$user['nama']:'';
        $email_data['jenis'] = $email_jenis;
        $email_data['izin'] = $izin;
        $email_data['nib'] = $izin;
        $check_badanhukum = DB::table('vw_jenisbadanhukum')->select('*')->where('nib','=',$email_data['izin']['nib'])->first();
        // dd($check_badanhukum,$email_data['izin']);
        if(isset($check_badanhukum)){
            if ($check_badanhukum->oss_kode == '02' || $check_badanhukum->oss_kode == '03') {
                if (isset($email_data['izin']['nib'])) {
                    $email_data['izin']['nib'] = NULL;
                }
            }
        }else{
            $email_data['izin']['nib'] = NULL;
        }
        
        $email_data['departemen'] = $departemen;
        $email_data['is_koreksi'] = $is_koreksi;
        $email_data['catatan'] = $catatan_hasil_evaluasi;
        $email_data['nama2'] = $nama2;
        $email_data['tanggal_permohonan'] = isset($izin['submitted_date']) ?
        $date_format->dateday_lang_reformat_long($izin['submitted_date']) : '' ;
        $email_data['updated_date'] = isset($izin['updated_date']) ? $date_format->dateday_lang_reformat_long($izin['updated_date']) : '' ;
        $email_data['date'] = $date;
        $email_data['jabatan'] = $jabatan->desc;

        //ulo
        $tipe_ulo = isset($izin['tipe_ulo']) ? ($izin['tipe_ulo'] == 1 ? 'Uji Petik' : ($izin['tipe_ulo'] == 2 ? 'Penilaian Mandiri' : '')) : '';
        $status_laik = isset($izin['status_laik']) ? ($izin['status_laik'] == 1 ? 'Laik' : 'Tidak Laik') : '';
        $email_data['tipe_ulo'] = $tipe_ulo;
        $email_data['status_laik'] = $status_laik;
        $email_data['tgl_pengajuan_ulo'] = isset($izin['tgl_pengajuan_ulo']) ? $date_format->dateday_lang_reformat_long($izin['tgl_pengajuan_ulo']):'';
        $email_data['tgl_submit'] = isset($izin['tgl_submit']) ? $date_format->dateday_lang_reformat_long($izin['updated_at']) : '';  
        //end

        //penomoran
        $email_data['kode_akses'] =  isset($departemen['kode_akses']) ? $departemen['kode_akses'] : "";
        $email_data['full_kode_akses'] =  isset($departemen['full_kode_akses']) ? $departemen['full_kode_akses'] : "";
        $email_data['nomor_kodeakses'] =  isset($departemen['availno']) ? $departemen['availno'] : "";
        $email_data['prefix'] = isset($departemen['prefix']) ? $departemen['prefix'] : "";
        $email_data['jenis_penomoran'] = isset($departemen['jenis_penomoran']) ? $departemen['jenis_penomoran'] : "";
        $email_data['jenis_permohonan'] = isset($departemen['jenis_permohonan']) ? $departemen['jenis_permohonan'] : "";
        // $email_data['nama2'] = isset(Auth::user()->nama) ? Auth::user()->nama : "";
        $email_data['updated_at_ulo'] = isset($izin['updated_at_ulo']) ? $izin['updated_at_ulo'] : "";
        if (isset($izin['tipe_ulo'])) {
            if ($izin['tipe_ulo'] == 1){
                $email_data['tipe_ulo_name'] = 'Uji Petik';
            }elseif($izin['tipe_ulo'] == 2){
                $email_data['tipe_ulo_name'] = 'Penilaian Mandiri';
            }else{
                $email_data['tipe_ulo_name'] = '';
            }
        } else {
            $email_data['tipe_ulo_name'] = '';
        }
        //end
        $email_data['tgl_permohonan'] = $date_format->dateday_lang_reformat_long($izin['tgl_permohonan']);
        // dd($email_data);
        if ($email_data['email'] != '') {
            // dd($email_data);
            $kirimemail = \Mail::to($email_data['email'])->send(new \App\Mail\Sendmail($email_data));
        }

	}
    public function kirim_email2_test($user,$email_jenis,$izin,$departemen,$catatan_hasil_evaluasi,$nama2 = '',$nib,$is_koreksi = 0,$jabatan){
        // dd($izin);
        $datenow = Carbon::now();
        $date_format = new DateHelper();
        $date = $date_format->dateday_lang_reformat_long($datenow);
        // dd($nama2);
		$email_data['email'] = 'am.ademaryadi@gmail.com';
        // dd($email_data['email']);
        $email_data['nama'] = isset($user['nama'])?$user['nama']:'';
        $email_data['jenis'] = $email_jenis;
        $email_data['izin'] = $izin;
        $email_data['nib'] = $izin;
        $check_badanhukum = DB::table('vw_jenisbadanhukum')->select('*')->where('nib','=',$email_data['izin']['nib'])->first();
        
        if (isset($check_badanhukum->oss_kode)) {
            if ($check_badanhukum->oss_kode == '02' || $check_badanhukum->oss_kode == '03') {
                if (isset($email_data['izin']['nib'])) {
                    $email_data['izin']['nib'] = NULL;
                }     
            }
        }else{
            $email_data['izin']['nib'] = NULL;
        }
        
        $email_data['departemen'] = $departemen;
        $email_data['is_koreksi'] = $is_koreksi;
        $email_data['catatan'] = $catatan_hasil_evaluasi;
        $email_data['nama2'] = $nama2;
        $email_data['tanggal_permohonan'] = isset($izin['submitted_date']) ?
        $date_format->dateday_lang_reformat_long($izin['submitted_date']) : '' ;
        $email_data['updated_date'] = isset($izin['updated_date']) ? $date_format->dateday_lang_reformat_long($izin['updated_date']) : '' ;
        $email_data['date'] = $date;
        $email_data['jabatan'] = $jabatan->desc;

        //ulo
        $tipe_ulo = isset($izin['tipe_ulo']) ? ($izin['tipe_ulo'] == 1 ? 'Uji Petik' : ($izin['tipe_ulo'] == 2 ? 'Penilaian Mandiri' : '')) : '';
        $status_laik = isset($izin['status_laik']) ? ($izin['status_laik'] == 1 ? 'Laik' : 'Tidak Laik') : '';
        $email_data['tipe_ulo'] = $tipe_ulo;
        $email_data['status_laik'] = $status_laik;
        $email_data['tgl_pengajuan_ulo'] = isset($izin['tgl_pengajuan_ulo']) ? $date_format->dateday_lang_reformat_long($izin['tgl_pengajuan_ulo']):'';
        $email_data['tgl_submit'] = isset($izin['tgl_submit']) ? $date_format->dateday_lang_reformat_long($izin['updated_at']) : '';  
        //end

        //penomoran
        $email_data['kode_akses'] =  isset($departemen['kode_akses']) ? $departemen['kode_akses'] : "";
        $email_data['full_kode_akses'] =  isset($departemen['full_kode_akses']) ? $departemen['full_kode_akses'] : "";
        $email_data['nomor_kodeakses'] =  isset($departemen['availno']) ? $departemen['availno'] : "";
        $email_data['prefix'] = isset($departemen['prefix']) ? $departemen['prefix'] : "";
        $email_data['jenis_penomoran'] = isset($departemen['jenis_penomoran']) ? $departemen['jenis_penomoran'] : "";
        $email_data['jenis_permohonan'] = isset($departemen['jenis_permohonan']) ? $departemen['jenis_permohonan'] : "";
        // $email_data['nama2'] = isset(Auth::user()->nama) ? Auth::user()->nama : "";
        $email_data['updated_at_ulo'] = isset($izin['updated_at_ulo']) ? $izin['updated_at_ulo'] : "";
        if (isset($izin['tipe_ulo'])) {
            if ($izin['tipe_ulo'] == 1){
                $email_data['tipe_ulo_name'] = 'Uji Petik';
            }elseif($izin['tipe_ulo'] == 2){
                $email_data['tipe_ulo_name'] = 'Penilaian Mandiri';
            }else{
                $email_data['tipe_ulo_name'] = '';
            }
        } else {
            $email_data['tipe_ulo_name'] = '';
        }
        //end
        $email_data['tgl_permohonan'] = $date_format->dateday_lang_reformat_long($izin['tgl_permohonan']);
        // dd($email_data);
        if ($email_data['email'] != '') {
            // dd($email_data);
            $kirimemail = \Mail::to($email_data['email'])->send(new \App\Mail\Sendmail($email_data));
        }

	}

    public function kirim_email_perubahan_tgl($id_izin, $email_data, $ulo, $tgl_before){
        $datenow = Carbon::now();
        $date_format = new DateHelper();
        $common = new CommonHelper();
        $tgl_before_formatted = date('Y-m-d',strtotime($email_data['tgl_pelaksanaan_ulo']));
        $date = $date_format->dateday_lang_reformat_long($datenow);
        $data_izin = array();
        
        // dd($date_format->dateday_lang_reformat_long($ulo['tgl_submit']));
        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($ulo['nib']);
        // dd($penanggungjawab);
       
		$email_data['email'] = isset($penanggungjawab['email_user_proses'])?$penanggungjawab['email_user_proses']:'';
        $email_data['nama'] = isset($penanggungjawab['nama_user_proses'])?$penanggungjawab['nama_user_proses']:'';
        $email_data['id_izin'] = isset($ulo['id_izin'])?$ulo['id_izin']:'';
        $email_data['tanggal_permohonan'] = $date_format->dateday_lang_reformat_long($ulo['tgl_submit']); 
        $email_data['tgl_permohonan'] = $date_format->dateday_lang_reformat_long($ulo['tgl_submit']); 
        $email_data['nama_perseroan'] = isset($ulo['nama_perseroan'])?$ulo['nama_perseroan']:'';

        $email_data['nib'] = isset($ulo['jenis_layanan'])?$ulo['nib']:'';
        $email_data['jenis_izin'] = isset($ulo['jenis_izin'])?$ulo['jenis_izin']:'';
        $email_data['full_kbli'] = isset($ulo['full_kbli'])?$ulo['full_kbli']:'';
        $email_data['jenis_layanan_html'] = isset($ulo['jenis_layanan_html'])?$ulo['jenis_layanan_html']:'';
        $email_data['jenis'] = 'perubahan-tgl-ulo';
        $email_data['tipe_ulo'] = isset($ulo['tipe_ulo'])?$ulo['tipe_ulo']:'';
        // $email_data['departemen'] = $departemen;
        // $email_data['nama2'] = $nama2; 
        $email_data['updated_date'] = isset($ulo['tgl_pengajuan_ulo']) ? $date_format->dateday_lang_reformat_long($ulo['tgl_pengajuan_ulo']) : '' ;
        $email_data['date'] = $date; 
        $email_data['tgl_before_formatted'] = $date_format->dateday_lang_reformat_long($tgl_before_formatted);
        // dd($departemen);

        // dd($email_data);
        //ulo
        //end
        
        if ($email_data['email'] != '') {
            $kirimemail = \Mail::to($email_data['email'])->send(new \App\Mail\Sendmail($email_data));
        }
        
    }

    public function kirim_email_invitation($meetingdetail,$bcc, $formattedStartDateTime, $formattedEndDateTime){
        $datenow = Carbon::now();
        $date_format = new DateHelper();
        $common = new CommonHelper();
            $email_data['meeting_id'] = $meetingdetail['meeting_id'];
            $email_data['meeting_subject'] = $meetingdetail['meeting_subject'];
            $email_data['meeting_link'] = $meetingdetail['meeting_link'];
            $email_data['meeting_passcode'] = $meetingdetail['meeting_passcode'];
            $email_data['meeting_date_start'] = $date_format->date_lang_reformat_long_with_time($formattedStartDateTime);
            $email_data['meeting_date_end'] = $date_format->date_lang_reformat_long_with_time($formattedEndDateTime);
            $email_data['bcc'] = $bcc;
            $email_data['jenis'] = 'bimtek_invitation';
            $email_data['email'] = 'e-telekomunikasi@kominfo.go.id';
        if ($email_data['meeting_id'] != '') {
            $kirimemail = \Mail::to($email_data['email'])->send(new \App\Mail\Sendmail($email_data));
        }
        
    }
}