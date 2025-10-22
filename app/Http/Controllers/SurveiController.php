<?php

namespace App\Http\Controllers;

use DB;
use Config;
use Session;
use App\Helpers\DateHelper;
use App\Helpers\IzinHelper;
use App\Helpers\EmailHelper;
use App\Models\Viewizin;;
use Illuminate\Http\Request;
use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SurveiController extends Controller{

    public function index($id)
    {
        $date_reformat = new DateHelper();
        $izin = Viewizin::where('id_izin','=',$id)->first();
        // dd($izin);
        $survei_list_header = DB::table('tb_survei_header')->select('*')->first();
        $survei_list_Quest01_noniipp = DB::table('vw_list_quest_noniipp')->select('*')->get();
        $survei_list_Quest01_iipp = DB::table('vw_list_quest_iipp')->select('*')->get();
        // $survei_list_Quest01_iipp = DB::table('tb_survei_question')->select('*')->where('type','=','Quest01')->where('is_active','=','1')->where('is_deleted','=','0')->where('jenisopsi_id','=','IIPP')->get();
        $survei_list_Quest02 = DB::table('tb_survei_question')->select('*')->where('type','=','Quest02')->where('is_active','=','1')->where('is_deleted','=','0')->get();
        $survei_list_Quest03 = DB::table('tb_survei_question')->select('*')->where('type','=','Quest03')->where('is_active','=','1')->where('is_deleted','=','0')->get();
        // $survei_list_Quest = DB::table('tb_survei_question')->select('*')->where('is_active','=','1')->where('is_deleted','=','0')->get();
        $survei_list_ans = DB::table('tb_survei_answer')->select('*')->where('is_deleted','=','0')->get();
        $survei_kategori = DB::table('tb_survei_kategori')->select('*')->get();
        return response()->view('layouts.frontend.survey.preview', 
        ['izin'=>$izin, 'date_reformat' => $date_reformat,
        'survei_list_header'=>$survei_list_header,
        'survei_list_ans'=>$survei_list_ans,
        'survei_list_Quest01_noniipp'=>$survei_list_Quest01_noniipp,
        'survei_list_Quest01_iipp'=>$survei_list_Quest01_iipp,
        'survei_list_Quest02'=>$survei_list_Quest02,
        'survei_list_Quest03'=>$survei_list_Quest03,
        'survei_kategori'=>$survei_kategori]);
    }

    public function post( Request $request)
    {
        // dd($request);
        $common = new CommonHelper();
        $email = new EmailHelper();
        $izin = Viewizin::where('id_izin','=',$request['id_izin'])->first();
            $penanggungjawab = array();
            $penanggungjawab = $common->get_pj_nib($izin->nib);
            $path = 'app/public/sk_penomoran/sk-penomoran-' . str_replace('storage/sk_penomoran/sk-penomoran-', '', $izin->file_sk_penomoran);
        // dd($path,$penanggungjawab);

        // try {
        DB::beginTransaction();
        $latest_respondno = DB::table('latest_survei_respondno')->first();
        $insert_responheader = DB::table('tb_survei_respond_header')->insert([
                'id_respond' => $latest_respondno->respondno,
                'id_trx_izin' => isset($request['id_izin']) ? $request['id_izin'] : null,
                'tgl_izin' => isset($request['tgl_izin']) ? $request['tgl_izin'] : null,
                'age' => isset($request['responder_age']) ? $request['responder_age'] : null,
                'gender' => isset($request['cr-i-l']) ? $request['cr-i-l'] : null,
                'study' => isset($request['cr_pendidikan']) ? $request['cr_pendidikan'] : null,
                'submitted_date' => date('Y-m-d H:i:s'),
                'is_deleted' => 0,
                'updated_date' => date('Y-m-d H:i:s'),
                'created_date' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->name,
                'created_by' => Auth::user()->name
            ]);
        
        // insert IKMK
        $respond_ikmk = $request['answer_quest01_IKMK'];
        foreach ($respond_ikmk as $key_ikmk => $value_ikmk) {
            $insert_responddetail_ikmk = DB::table('tb_survei_respond_detail')->insert([
                'question_id' => $key_ikmk,
                'id_respond' => $latest_respondno->respondno,
                'answer' => $value_ikmk,
                'is_deleted' => 0,
                'updated_date' => date('Y-m-d H:i:s'),
                'created_date' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->name,
                'created_by' => Auth::user()->name
            ]);
        }
        // insert IKMH
        $respond_ikmh = $request['answer_quest01_IKMH'];
        foreach ($respond_ikmh as $key_ikmh => $value_ikmh) {
            $insert_responddetail_ikmk = DB::table('tb_survei_respond_detail')->insert([
                'question_id' => $key_ikmh,
                'id_respond' => $latest_respondno->respondno,
                'answer' => $value_ikmh,
                'is_deleted' => 0,
                'updated_date' => date('Y-m-d H:i:s'),
                'created_date' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->name,
                'created_by' => Auth::user()->name
            ]);
        }
        // insert IIPP
        $respond_iipp = $request['answer_quest01_IIPP'];
        foreach ($respond_iipp as $key_iipp => $value_iipp) {
            $insert_responddetail_iipp = DB::table('tb_survei_respond_detail')->insert([
                'question_id' => $key_iipp,
                'id_respond' => $latest_respondno->respondno,
                'answer' => $value_iipp,
                'is_deleted' => 0,
                'updated_date' => date('Y-m-d H:i:s'),
                'created_date' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->name,
                'created_by' => Auth::user()->name
            ]);
        }
        
        // insert testimoni
        $respond_testimoni = $request['answer_quest03_respond'];
            foreach ($respond_testimoni as $testimonikey => $testimonivalue) {
                $insert_responddetail_testimoni = DB::table('tb_survei_respond_detail')->insert([
                    'question_id' => $testimonikey,
                    'id_respond' => $latest_respondno->respondno,
                    'answer' => $testimonivalue,
                    'is_deleted' => 0,
                    'updated_date' => date('Y-m-d H:i:s'),
                    'created_date' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->name,
                    'created_by' => Auth::user()->name
                ]);
            }


        
        // insert Quest02
        $respond_quest02 = $request['answer_quest02'];
        $respond_quest02_answer = $request['answer_quest02_respond'];
        
            foreach ($respond_quest02 as $key => $categories) {

                foreach ($categories as $categoryeKey => $category) {
                    
                    // Access corresponding responses
                    $responses = $respond_quest02_answer[$key];
                    foreach ($responses as $responseKey => $responseValue) {
                        
                    if ($categoryeKey == $responseKey) {
                        $insert_responddetail_quest02 = DB::table('tb_survei_respond_detail')->insert([
                                'question_id' => $key,
                                'id_respond' => $latest_respondno->respondno,
                                'answer_id' => $category,
                                'answer' => $responseValue,
                                'is_deleted' => 0,
                                'updated_date' => date('Y-m-d H:i:s'),
                                'created_date' => date('Y-m-d H:i:s'),
                                'updated_by' => Auth::user()->name,
                                'created_by' => Auth::user()->name
                            ]);
                    }
                        
                    }
                
                }
            }

            DB::table('tb_oss_trx_izin')
                ->where(['id_izin' => $request['id_izin']])
                ->update(
                    ['status_checklist' => '50', 'updated_at' => date('Y-m-d H:i:s')]
                );
            DB::commit();

            
            $izin = Viewizin::where('id_izin','=',$request['id_izin'])->first();
            $izin = $izin->toArray();
            $penanggungjawab = array();
            $penanggungjawab = $common->get_pj_nib($izin['nib']);
            $evaluator = DB::table('tb_trx_disposisi_evaluator_penomoran as a')
            ->join('tb_mst_user_bo as b', 'b.id', '=', 'a.id_disposisi_user')
            ->where('a.id_izin', $request['id_izin'])
            ->first();
        // $email_jenis = 'penetapan-sk-penomoran';
        $nama2 = $evaluator->nama;
            $path = 'app/public/sk_penomoran/sk-penomoran-' . str_replace('storage/sk_penomoran/sk-penomoran-', '', $izin['file_sk_penomoran']);
            // $izin = $izin->toArray();
            $email_jenis = 'thanks-survei';
            $kirim_email = $email->kirim_email(
                $penanggungjawab,
                $email_jenis,
                $izin,
                '',
                '',
                $nama2,
                '',
                '',
                $path,
                '',
                '',
                ''
            );
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     throw ValidationException::withMessages(['message' => 'Gagal']);
        // }
        // $survei_list_header = DB::table('tb_survei_header')->select('*')->first();
        // $survei_list_Quest01_noniipp = DB::table('vw_list_quest_noniipp')->select('*')->get();
        // $survei_list_Quest01_iipp = DB::table('vw_list_quest_iipp')->select('*')->get();
        // // $survei_list_Quest01_iipp = DB::table('tb_survei_question')->select('*')->where('type','=','Quest01')->where('is_active','=','1')->where('is_deleted','=','0')->where('jenisopsi_id','=','IIPP')->get();
        // $survei_list_Quest02 = DB::table('tb_survei_question')->select('*')->where('type','=','Quest02')->where('is_active','=','1')->where('is_deleted','=','0')->get();
        // $survei_list_Quest03 = DB::table('tb_survei_question')->select('*')->where('type','=','Quest03')->where('is_active','=','1')->where('is_deleted','=','0')->get();
        // // $survei_list_Quest = DB::table('tb_survei_question')->select('*')->where('is_active','=','1')->where('is_deleted','=','0')->get();
        // $survei_list_ans = DB::table('tb_survei_answer')->select('*')->where('is_deleted','=','0')->get();
        // $survei_kategori = DB::table('tb_survei_kategori')->select('*')->get();
        $izin = Viewizin::where('nib','=',Auth::user()->nib[0]->nib)->where('status_checklist','=','95')->get();
        return response()->view('layouts.frontend.survey.dashboard_survei',['izin'=>$izin]);
    }

    public function isi()
    {
        
        $date_reformat = new DateHelper();
        $izin = Viewizin::where('nib','=',Auth::user()->nib[0]->nib)->where('status_checklist','=','95')->get();
        // $izin = $izin->toArray();
        // dd($izin);
        return response()->view('layouts.frontend.survey.dashboard_survei',['izin'=>$izin,'date_reformat'=>$date_reformat]);
    }

    public function result_survei()
    {
        
        return response()->view('layouts.backend.survey.result_survei');
    }

    public function preview()
    {
        
        return response()->view('layouts.backend.survey.preview');
    }
}