<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Sendmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email_data = array())
    {
        //
        $this->email_data = $email_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email_data = $this->email_data;
        if (isset($email_data['izin']['jenis_perizinan'])) {
            if ($email_data['izin']['jenis_perizinan']=='K03') {
                $subject = 'Permohonan Izin Penomoran Telekomunikasi - ';
            } else {
                $subject = 'Disposisi telah dilakukan untuk izin - ';
            }
            
        } else {
            $subject = 'Disposisi telah dilakukan untuk izin - ';   
        }
        
        if ($email_data['jenis'] == 'disposisi') {
            $view = 'admin.disposisi-mail';
        }else if($email_data['jenis'] == 'disposisi-pj'){
            $view = 'admin.disposisi-mail-pj';
        }else if($email_data['jenis'] == 'evaluasi-evaluator'){
            $view = 'admin.evaluasi-evaluator';
        }else if($email_data['jenis'] == 'evaluasi-evaluator-pj'){
            $view = 'admin.evaluasi-evaluator-pj';
        }else if($email_data['jenis'] == 'evaluasi-subkoordinator'){
            $view = 'admin.evaluasi-subkoordinator';
        }else if($email_data['jenis'] == 'evaluasi-subkoordinator-pj'){
            $view = 'admin.evaluasi-subkoordinator-pj';
        }else if($email_data['jenis'] == 'evaluasi-koordinator'){
            $view = 'admin.evaluasi-koordinator';
        }else if($email_data['jenis'] == 'evaluasi-koordinator-pj'){
            $view = 'admin.evaluasi-koordinator-pj';
        }else if($email_data['jenis'] == 'evaluasi-koordinator-pj-ulo'){
            $view = 'admin.evaluasi-koordinator-pj-ulo';
        }else if($email_data['jenis'] == 'pemenuhan-syarat'){
            $view = 'layouts.frontend.email_persyaratan.pemohon';
        }else if($email_data['jenis'] == 'koordinator-syarat'){
            $view = 'layouts.frontend.email_persyaratan.koordinator';
        }else if($email_data['jenis'] == 'pengajuan-ulo'){
            $view = 'layouts.frontend.email_ulo.permohonan_pj';
        }else if($email_data['jenis'] == 'koordinator-ulo'){
            $view = 'layouts.frontend.email_ulo.permohonan_koordinator';
        }else if($email_data['jenis'] == 'disposisi-ulo'){
            $view = 'admin.disposisi-mail-pj';
        }else if($email_data['jenis'] == 'direktur'){
            $view = 'admin.direktur';
        }else if($email_data['jenis'] == 'direktur-pj'){
            $view = 'admin.direktur-pj';
        }else if($email_data['jenis'] == 'penetapan-sk-ulo'){
            $view = 'admin.penetapan-sk';
        }else if($email_data['jenis'] == 'perpanjangan_ip'){
        $view = 'admin.penetapan-sk';
        }else if($email_data['jenis'] == 'penetapan-sk-penomoran'){
            $view = 'admin.penetapan-sk-penomoran';
        }else if($email_data['jenis'] == 'pencabutan-sk-penomoran'){
            $subject = 'SK Pencabutan Penomoran';
            $view = 'admin.penetapan-sk-penomoran';
        }else if($email_data['jenis'] == 'koreksi-pj'){
            $view = 'admin.koreksi-pj';
        }else if($email_data['jenis'] == 'koreksi'){
            $view = 'admin.koreksi';
        }else if($email_data['jenis'] == 'tolak-pj'){
            $view = 'admin.tolak-pj';
        }else if($email_data['jenis'] == 'tolak-pj-ip'){
        $view = 'admin.tolak-pj-ip';
        }else if($email_data['jenis'] == 'tolak-penomoran-pj'){
            $view = 'admin.tolak-pj-penomoran';
        }else if($email_data['jenis'] == 'evaluasi-register'){
            $view = 'admin.evaluasi-register';
        }else if($email_data['jenis'] == 'evaluasi-register'){
            $view = 'admin.evaluasi-register';
        }else if($email_data['jenis'] == 'perpanjang-izin'){
            $view = 'admin.perpanjang-izin-prinsip';
        }
        else if($email_data['jenis'] == 'evaluasi-koordinator-izinprinsip'){
        $view = 'admin.evaluasi-koordinator-izinprinsip';
        }
        else if($email_data['jenis'] == 'evaluasi-direktur-izinprinsip'){
        $view = 'admin.evaluasi-direktur-izinprinsip';
        }
        else if($email_data['jenis'] == 'kirim-survei'){
            $view = 'admin.kirim-survei';
        }else if($email_data['jenis'] == 'thanks-survei'){
            $view = 'admin.thanks-survei';
        }
        else{
            $view = 'admin.disposisi-mail';
        }

        if($email_data['jenis'] == 'perubahan-tgl-ulo'){
            $view = 'admin.perubahan-tgl-ulo';
            return $this->subject('Pemberitahuan perubahan tanggal pelaksanaan ULO')->view($view,['email_data'=>$email_data]);
        }   
        
        if($email_data['jenis'] == 'bimtek_invitation'){
            $view = 'admin.kirim-bimtek';
            return $this->subject('Pemberitahuan Undangan Bimbingan Teknis')->view($view,['email_data'=>$email_data])->bcc($email_data['bcc']);
        }

        if($email_data['jenis'] == 'evaluasi-register'){
            return $this->subject('Evaluasi Register')->view($view,['email_data'=>$email_data]);
        }else{
            if (isset($email_data['attach']) && $email_data['attach'] != '' &&file_exists(storage_path($email_data['attach']))) {
                if (isset($email_data['attach2']) && $email_data['attach2'] != '' &&file_exists(storage_path($email_data['attach2']))) {
                    if (isset($email_data['attach3']) && $email_data['attach3'] != '' &&file_exists(storage_path($email_data['attach3']))) {
                        return $this->subject($subject.$email_data["izin"]["id_izin"].' ')->view($view,['email_data'=>$email_data])->attach(storage_path($email_data['attach']))->attach(storage_path($email_data['attach2']))->attach(storage_path($email_data['attach3']));
                    }
                    else{
                        return $this->subject($subject.$email_data["izin"]["id_izin"].' ')->view($view,['email_data'=>$email_data])->attach(storage_path($email_data['attach']))->attach(storage_path($email_data['attach2']));
                    }
                }
                else{
                    if (isset($email_data['attach3']) && $email_data['attach3'] != '' &&file_exists(storage_path($email_data['attach3']))) {
                        return $this->subject($subject.$email_data["izin"]["id_izin"].' ')->view($view,['email_data'=>$email_data])->attach(storage_path($email_data['attach']))->attach(storage_path($email_data['attach3']));
                    }
                    else{
                        return $this->subject($subject.$email_data["izin"]["id_izin"].' ')->view($view,['email_data'=>$email_data])->attach(storage_path($email_data['attach']));
                    }
                }
            }
            else{
                if (isset($email_data['attach2']) && $email_data['attach2'] != ''&&file_exists(storage_path($email_data['attach2']))) {
                    if (isset($email_data['attach3']) && $email_data['attach3'] != '' &&file_exists(storage_path($email_data['attach3']))) {
                        return $this->subject($subject.$email_data["izin"]["id_izin"].' ')->view($view,['email_data'=>$email_data])->attach(storage_path($email_data['attach2']))->attach(storage_path($email_data['attach3']));
                    }
                    else{
                        return $this->subject($subject.$email_data["izin"]["id_izin"].' ')->view($view,['email_data'=>$email_data])->attach(storage_path($email_data['attach2']));
                    }
                }
                else{
                    if (isset($email_data['attach3']) && $email_data['attach3'] != '' &&file_exists(storage_path($email_data['attach3']))) {
                        return $this->subject($subject.$email_data["izin"]["id_izin"].' ')->view($view,['email_data'=>$email_data])->attach(storage_path($email_data['attach3']));
                    }
                    else{
                        return $this->subject($subject.$email_data["izin"]["id_izin"].' ')->view($view,['email_data'=>$email_data]);
                    }
                }

            }


            // if (isset($email_data['attach']) && $email_data['attach'] != '' && file_exists(storage_path($email_data['attach']))) {
            //     if (isset($email_data['attach2']) && $email_data['attach2'] != '' && file_exists(storage_path($email_data['attach2']))) {
            //         return $this->subject($subject.$email_data["izin"]["id_izin"].' ')->view($view,['email_data'=>$email_data])->attach(storage_path($email_data['attach']))->attach(storage_path($email_data['attach2']));
            //     }
            //     if (isset($email_data['attach3']) && $email_data['attach3'] != '' && file_exists(storage_path($email_data['attach3']))) {
            //         return $this->subject($subject.$email_data["izin"]["id_izin"].' ')->view($view,['email_data'=>$email_data])->attach(storage_path($email_data['attach']))->attach(storage_path($email_data['attach3']));
            //     }
            //     return $this->subject($subject.$email_data["izin"]["id_izin"].' ')->view($view,['email_data'=>$email_data])->attach(storage_path($email_data['attach']));
            // }else{
            //     return $this->subject($subject.$email_data["izin"]["id_izin"].' ')->view($view,['email_data'=>$email_data]);
            // }
        }
        

    }
}