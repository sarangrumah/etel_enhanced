<?php

namespace App\Http\Controllers\Admin;

use DB;
use Config;
use Session;
use App\Models\Admin\Izin;
use App\Helpers\DateHelper;
use App\Helpers\IzinHelper;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use App\Http\Controllers\Controller;

class SurveiController extends Controller
{

    public function index()
    {

        $opt_answer01 = DB::table('tb_survei_mst_opt')->select('opt_answer', 'opt_answer_desc')->where('opt_answertype', '=', 'quest01')->get();
        
        $survei_unsur = DB::table('tb_survei_unsur')->select('*')->get();

        $survei_list_header = DB::table('tb_survei_header')->select('*')->first();
        $survei_list_Quest01 = DB::table('vw_list_quest01')->select('*')->get();

        $survei_list_Quest01_noniipp = DB::table('vw_list_quest_noniipp')->select('*')->get();
        $survei_list_Quest01_iipp = DB::table('vw_list_quest_iipp')->select('*')->get();
        // $survei_list_Quest01_iipp = DB::table('tb_survei_question')->select('*')->where('type','=','Quest01')->where('is_active','=','1')->where('is_deleted','=','0')->where('jenisopsi_id','=','IIPP')->get();
        $survei_list_Quest02 = DB::table('tb_survei_question')->select('*')->where('type','=','Quest02')->where('is_active','=','1')->where('is_deleted','=','0')->get();
        $survei_list_Quest03 = DB::table('tb_survei_question')->select('*')->where('type','=','Quest03')->where('is_active','=','1')->where('is_deleted','=','0')->get();
        // $survei_list_Quest = DB::table('tb_survei_question')->select('*')->where('is_active','=','1')->where('is_deleted','=','0')->get();
        $survei_list_ans = DB::table('vw_survei_answer_ordered')->select('*')->where('is_deleted','=','0')->get();
        $survei_kategori = DB::table('tb_survei_kategori')->select('*')->get();
        // dd($survei_list_Quest01_noniipp);
        return response()->view('layouts.backend.survey.manage', 
        ['opt_answer01' => $opt_answer01,'survei_unsur'=>$survei_unsur,'survei_list_header'=>$survei_list_header,
        'survei_list_ans'=>$survei_list_ans,
        'survei_list_Quest01_noniipp'=>$survei_list_Quest01_noniipp,
        'survei_list_Quest01'=>$survei_list_Quest01,
        'survei_list_Quest01_iipp'=>$survei_list_Quest01_iipp,
        'survei_list_Quest02'=>$survei_list_Quest02,
        'survei_list_Quest03'=>$survei_list_Quest03,
        'survei_kategori'=>$survei_kategori]);
    }

    public function post(Request $request)
    {
        // dump($request);
        // dd($request->all());


        DB::beginTransaction();
        // try {
            $inf_katapengantar = isset($request['infsurveiinit']) ? $request['infsurveiinit'] : null;
            $infsurveippp = isset($request['infsurveippp']) ? $request['infsurveippp'] : null;
            $infsurveiipp = isset($request['infsurveiipp']) ? $request['infsurveiipp'] : null;
            $header_no_last = DB::table('tb_survei_header')->select('id')->where('is_active','=','1')->where('divisi','=',Session::get('id_departemen'))->first();
            $count_header = DB::table('tb_survei_header')->where('is_active','=','1')->where('divisi','=',Session::get('id_departemen'))->count();
            if ($count_header > 0) {
                
           
                $update_header = DB::table('tb_survei_header')->where('is_active','=','1')->where('divisi','=',Session::get('id_departemen'))->update([
                    'is_active' => 0,
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => Session::get('nama')
                ]);
                $insert_header = DB::table('tb_survei_header')->insert([
                    'divisi' => Session::get('id_departemen'),
                    'infsurveiinit' => $inf_katapengantar,
                    'infsurveippp' => $infsurveippp,
                    'infsurveiipp' => $infsurveiipp,
                    'is_active' => 1,
                    'updated_date' => date('Y-m-d H:i:s'),
                    'created_date' => date('Y-m-d H:i:s'),
                    'updated_by' => Session::get('nama'),
                    'created_by' => Session::get('nama')
                ]);
                
            $header_no = DB::table('tb_survei_header')->select('id')->where('is_active','=','1')->where('divisi','=',Session::get('id_departemen'))->first();
                //  dd($header_no);
            } else{
                $insert_header = DB::table('tb_survei_header')->insert([
                    'divisi' => Session::get('id_departemen'),
                    'infsurveiinit' => $inf_katapengantar,
                    'infsurveippp' => $infsurveippp,
                    'infsurveiipp' => $infsurveiipp,
                    'is_active' => 1,
                    'updated_date' => date('Y-m-d H:i:s'),
                    'created_date' => date('Y-m-d H:i:s'),
                    'updated_by' => Session::get('nama'),
                    'created_by' => Session::get('nama')
                ]);
            $header_no = DB::table('tb_survei_header')->select('id')->where('is_active','=','1')->where('divisi','=',Session::get('id_departemen'))->first();
            }
            
            if ($count_header > 0) {
            // dd($header_no);
            $update_header = DB::table('tb_survei_question')->where('is_active','=','1')->where('header_id','=',$header_no_last->id)->update([
                'is_active' => 0,
                'updated_date' => date('Y-m-d H:i:s'),
                'updated_by' => Session::get('nama')
            ]);}
        
            if (isset($request['Question01'])) {
                $questions = $request['Question01'];
                $ansCat01JenisOpsi = $request['AnsCat01_Quest_hidden_'];

                foreach ($questions as $keyQuest => $questionvalue) {
                    $latest_questno = DB::table('latest_survei_questno')->first();
                    $seq = $request['Question01_Seq'][$keyQuest];
                    $unsur = $request['Question01_Unsur'][$keyQuest];
                    $question = $request['Question01'][$keyQuest];
                    if (isset($request['is_active_QuestCat01'][$keyQuest])) {
                        if ($request['is_active_QuestCat01'][$keyQuest] == 'on') {
                            $isActive = 1;
                        } else {
                            $isActive = 0;
                        }
                    } else {
                        $isActive = 0;
                    }
                    $insert_quest = DB::table('tb_survei_question')->insert([
                        'question_id' => $latest_questno->questno,
                        'header_id' => isset($header_no->id) ? $header_no->id : '0',
                        'type' => 'Quest01',
                        'unsur_id' => $unsur,
                        'seq' => $seq,
                        'question' => $question,
                        'is_active' => $isActive,
                        'is_deleted' => '0',
                        'updated_date' => date('Y-m-d H:i:s'),
                        'created_date' => date('Y-m-d H:i:s'),
                        'updated_by' => Session::get('nama'),
                        'created_by' => Session::get('nama')
                    ]);
                
                    $answers = $ansCat01JenisOpsi[$keyQuest];
                    foreach ($answers as $keyAnswer => $answer) {
                        $jenisOpsi = isset($request['AnsCat01_JenisOpsi_'][$keyQuest][$keyAnswer]) ? $request['AnsCat01_JenisOpsi_'][$keyQuest][$keyAnswer] : null;
                        $opsiPilihan = isset($request['AnsCat01_OpsiPilihan_'][$keyQuest][$keyAnswer]) ? $request['AnsCat01_OpsiPilihan_'][$keyQuest][$keyAnswer] : null;
                        $opsiNilai = isset($request['AnsCat01_Nilai_'][$keyQuest][$keyAnswer]) ? $request['AnsCat01_Nilai_'][$keyQuest][$keyAnswer] : null;;
                        $opsiBobot = isset($request['AnsCat01_Bobot_'][$keyQuest][$keyAnswer]) ? $request['AnsCat01_Bobot_'][$keyQuest][$keyAnswer] : null;;
                        
                        $latest_answerno = DB::table('latest_survei_answerno')->first();
                        // $ansCat01_Flag = $request->input('AnsCat01_Flag_[{{ $AddQuestion01 }}][{{ $innerIteration[$AddQuestion01] }}]');
                        $ansCat01_Flag = $request->input('AnsCat01_Flag_[' . $keyQuest . '][' . $keyAnswer . ']');
                        // dd($ansCat01_Flag);
                        if (isset($request['AnsCat01_Flag_hidden_'][$keyQuest][$keyAnswer])) {
                            if ($request['AnsCat01_Flag_hidden_'][$keyQuest][$keyAnswer] == 'true') {
                                $isFlag = 1;
                            } else {
                                $isFlag = 0;
                            }
                        } else {
                            $isFlag = 0;
                        }
                        $insert_answer = DB::table('tb_survei_answer')->insert([
                            'answer_id' => $latest_answerno->answerno,
                            'question_id' => $latest_questno->questno,
                            'jenisopsi_id' => $jenisOpsi,
                            'answer' => $opsiPilihan,
                            'nilai' => $opsiNilai,
                            'bobot' => $opsiBobot,
                            'is_flag' => $isFlag,
                            'is_deleted' => '0',
                            'updated_date' => date('Y-m-d H:i:s'),
                            'created_date' => date('Y-m-d H:i:s'),
                            'updated_by' => Session::get('nama'),
                            'created_by' => Session::get('nama')
                        ]);
                    }
                }
            }

            if (isset($request['Question02'])) {
                $question_02 = $request['Question02'];
                foreach ($question_02 as $keyQuest => $value) {
                    $latest_questno = DB::table('latest_survei_questno')->first();
                    $seq = $request['Question02_Seq'][$keyQuest];
                    $question = $request['Question02'][$keyQuest];
                    if (isset($request['is_active_QuestCat02'][$keyQuest])) {
                        if ($request['is_active_QuestCat02'][$keyQuest] == 'on') {
                            $isActive = 1;
                        } else {
                            $isActive = 0;
                        }
                    } else {
                        $isActive = 0;
                    }
                    $insert_quest = DB::table('tb_survei_question')->insert([
                        'question_id' => $latest_questno->questno,
                        'header_id' => isset($header_no->id) ? $header_no->id : '0',
                        'type' => 'Quest02',
                        'seq' => $seq,
                        'question' => $question,
                        'is_active' => $isActive,
                        'is_deleted' => '0',
                        'updated_date' => date('Y-m-d H:i:s'),
                        'created_date' => date('Y-m-d H:i:s'),
                        'updated_by' => Session::get('nama'),
                        'created_by' => Session::get('nama')
                    ]);
                }
            }

            if (isset($request['Question03'])) {
                $question_03 = $request['Question03'];
                foreach ($question_03 as $keyQuest => $value) {
                    $latest_questno = DB::table('latest_survei_questno')->first();
                    $seq = $request['Question03_Seq'][$keyQuest];
                    $question = $request['Question03'][$keyQuest];
                    if (isset($request['is_active_QuestCat03'][$keyQuest])) {
                        if ($request['is_active_QuestCat03'][$keyQuest] == 'on') {
                            $isActive = 1;
                        } else {
                            $isActive = 0;
                        }
                    } else {
                        $isActive = 0;
                    }
                    $insert_quest = DB::table('tb_survei_question')->insert([
                        'question_id' => $latest_questno->questno,
                        'header_id' => isset($header_no->id) ? $header_no->id : '0',
                        'type' => 'Quest03',
                        'seq' => $seq,
                        'question' => $question,
                        'is_active' => $isActive,
                        'is_deleted' => '0',
                        'updated_date' => date('Y-m-d H:i:s'),
                        'created_date' => date('Y-m-d H:i:s'),
                        'updated_by' => Session::get('nama'),
                        'created_by' => Session::get('nama')
                    ]);
                }
            }
            DB::commit();
        // } catch (\Throwable $th) {

        //     DB::rollback();
        // }
        $survei_list_header = DB::table('tb_survei_header')->select('*')->where('divisi','=',Session::get('id_departemen'))->first();
        $survei_list_Quest01_noniipp = DB::table('vw_list_quest_noniipp')->select('*')->where('divisi','=',Session::get('id_departemen'))->get();
        $survei_list_Quest01_iipp = DB::table('vw_list_quest_iipp')->select('*')->where('divisi','=',Session::get('id_departemen'))->get();
        // $survei_list_Quest01_iipp = DB::table('tb_survei_question')->select('*')->where('type','=','Quest01')->where('is_active','=','1')->where('is_deleted','=','0')->where('jenisopsi_id','=','IIPP')->get();
        $survei_list_Quest02 = DB::table('tb_survei_question')->leftjoin('tb_survei_header', 'tb_survei_header.id', '=', 'tb_survei_question.header_id')->select('tb_survei_question.*')->where('tb_survei_header.divisi','=',Session::get('id_departemen'))->where('tb_survei_question.type','=','Quest02')->where('tb_survei_question.is_active','=','1')->where('tb_survei_question.is_deleted','=','0')->get();
        $survei_list_Quest03 = DB::table('tb_survei_question')->leftjoin('tb_survei_header', 'tb_survei_header.id', '=', 'tb_survei_question.header_id')->select('tb_survei_question.*')->where('tb_survei_header.divisi','=',Session::get('id_departemen'))->where('tb_survei_question.type','=','Quest03')->where('tb_survei_question.is_active','=','1')->where('tb_survei_question.is_deleted','=','0')->get();
        // $survei_list_Quest = DB::table('tb_survei_question')->select('*')->where('is_active','=','1')->where('is_deleted','=','0')->get();
        $survei_list_ans = DB::table('vw_survei_answer_ordered')->leftjoin('tb_survei_question', 'tb_survei_question.question_id', '=', 'vw_survei_answer_ordered.question_id')->leftjoin('tb_survei_header', 'tb_survei_header.id', '=', 'tb_survei_question.header_id')->select('vw_survei_answer_ordered.*')->where('tb_survei_header.divisi','=',Session::get('id_departemen'))->where('tb_survei_question.is_active','=','1')->where('tb_survei_question.is_deleted','=','0')->where('vw_survei_answer_ordered.is_deleted','=','0')->get();
        $survei_kategori = DB::table('tb_survei_kategori')->select('*')->get();
            // dd($survei_list_Quest01_noniipp);
        return response()->view('layouts.backend.survey.preview', 
        ['survei_list_header'=>$survei_list_header,
        'survei_list_ans'=>$survei_list_ans,
        'survei_list_Quest01_noniipp'=>$survei_list_Quest01_noniipp,
        'survei_list_Quest01_iipp'=>$survei_list_Quest01_iipp,
        'survei_list_Quest02'=>$survei_list_Quest02,
        'survei_list_Quest03'=>$survei_list_Quest03,
        'survei_kategori'=>$survei_kategori]);

        return response()->view('layouts.backend.survey.preview');
    }

    public function respond_list()
    {

        $list_header = DB::table('vw_survei_respond__header')->get();

        return response()->view('layouts.backend.survey.respond_survei',['list_header'=>$list_header]);
    }

    public function result_survei()
    {
        
        $list_summary = DB::table('vw_survei_result_summary')->get();
        return response()->view('layouts.backend.survey.result_survei',['list_summary'=>$list_summary]);
    }

    public function result_survei_detail($period_month, $period_year, Request $req)
    {
        
        $list_summary = DB::table('vw_survei_result_summary_all')
        ->where('period_month','=',$period_month)
        ->where('period_year','=',$period_year)
        ->first();
        $list_summary_ikm = DB::table('vw_survei_respond__detail_ikm_all')
        ->where('period_month','=',$period_month)
        ->where('period_year','=',$period_year)
        ->get();
        $list_summary_iipp = DB::table('vw_survei_respond__detail_iipp_all')
        ->where('period_month','=',$period_month)
        ->where('period_year','=',$period_year)
        ->get();
        $list_summary_quest02 = DB::table('vw_survei_respond__detail__quest02_all')
        ->where('period_month','=',$period_month)
        ->where('period_year','=',$period_year)
        ->where('type','=','Quest02')
        ->get();
        $list_summary_quest03 = DB::table('vw_survei_respond__detail__quest03_all')
        ->where('period_month','=',$period_month)
        ->where('period_year','=',$period_year)
        ->where('type','=','Quest03')
        ->get();
        // dd($list_summary);
        return response()->view('layouts.backend.survey.result_survei_detail',['list_summary'=>$list_summary, 'list_summary_ikm'=>$list_summary_ikm, 'list_summary_iipp'=>$list_summary_iipp, 'list_summary_quest02'=>$list_summary_quest02, 'list_summary_quest03'=>$list_summary_quest03]);
    }

    public function preview()
    {
        
        $survei_list_header = DB::table('tb_survei_header')->select('*')->where('divisi','=',Session::get('id_departemen'))->first();
        $survei_list_Quest01_noniipp = DB::table('vw_list_quest_noniipp')->select('*')->where('divisi','=',Session::get('id_departemen'))->get();
        $survei_list_Quest01_iipp = DB::table('vw_list_quest_iipp')->select('*')->where('divisi','=',Session::get('id_departemen'))->get();
        // $survei_list_Quest01_iipp = DB::table('tb_survei_question')->select('*')->where('type','=','Quest01')->where('is_active','=','1')->where('is_deleted','=','0')->where('jenisopsi_id','=','IIPP')->get();
        $survei_list_Quest02 = DB::table('tb_survei_question')->leftjoin('tb_survei_header', 'tb_survei_header.id', '=', 'tb_survei_question.header_id')->select('tb_survei_question.*')->where('tb_survei_header.divisi','=',Session::get('id_departemen'))->where('tb_survei_question.type','=','Quest02')->where('tb_survei_question.is_active','=','1')->where('tb_survei_question.is_deleted','=','0')->get();
        $survei_list_Quest03 = DB::table('tb_survei_question')->leftjoin('tb_survei_header', 'tb_survei_header.id', '=', 'tb_survei_question.header_id')->select('tb_survei_question.*')->where('tb_survei_header.divisi','=',Session::get('id_departemen'))->where('tb_survei_question.type','=','Quest03')->where('tb_survei_question.is_active','=','1')->where('tb_survei_question.is_deleted','=','0')->get();
        // $survei_list_Quest = DB::table('tb_survei_question')->select('*')->where('is_active','=','1')->where('is_deleted','=','0')->get();
        $survei_list_ans = DB::table('vw_survei_answer_ordered')->leftjoin('tb_survei_question', 'tb_survei_question.question_id', '=', 'vw_survei_answer_ordered.question_id')->leftjoin('tb_survei_header', 'tb_survei_header.id', '=', 'tb_survei_question.header_id')->select('vw_survei_answer_ordered.*')->where('tb_survei_header.divisi','=',Session::get('id_departemen'))->where('tb_survei_question.is_active','=','1')->where('tb_survei_question.is_deleted','=','0')->where('vw_survei_answer_ordered.is_deleted','=','0')->get();
        $survei_kategori = DB::table('tb_survei_kategori')->select('*')->get();
        // dd($survei_list_Quest01_noniipp, Session::get('id_departemen'));
        return response()->view('layouts.backend.survey.preview', 
        ['survei_list_header'=>$survei_list_header,
        'survei_list_ans'=>$survei_list_ans,
        'survei_list_Quest01_noniipp'=>$survei_list_Quest01_noniipp,
        'survei_list_Quest01_iipp'=>$survei_list_Quest01_iipp,
        'survei_list_Quest02'=>$survei_list_Quest02,
        'survei_list_Quest03'=>$survei_list_Quest03,
        'survei_kategori'=>$survei_kategori]);
    }

    public function result($id)
    {
        $date_reformat = new DateHelper();
        $izin = Izin::select('vw_list_izin.*', 'tb_survei_respond_header.age', 'tb_survei_respond_header.gender', 'tb_survei_respond_header.study')->join('tb_survei_respond_header', 'tb_survei_respond_header.id_trx_izin', '=', 'vw_list_izin.id_izin')->where('tb_survei_respond_header.id_respond','=',$id)->first();
        $survei_list_header = DB::table('tb_survei_header')->select('*')->where('divisi','=',Session::get('id_departemen'))->first();
        $survei_list_Quest01_noniipp = DB::table('vw_list_quest_noniipp_w_ans')->select('*')->where('id_respond','=',$id)->get();
        $survei_list_Quest01_iipp = DB::table('vw_list_quest_iipp_w_ans')->select('*')->where('id_respond','=',$id)->get();
        // $survei_list_Quest02 = DB::table('tb_survei_question')->leftjoin('tb_survei_header', 'tb_survei_header.id', '=', 'tb_survei_question.header_id')->select('tb_survei_question.*')->where('tb_survei_header.divisi','=',Session::get('id_departemen'))->where('tb_survei_question.type','=','Quest02')->where('tb_survei_question.is_active','=','1')->where('tb_survei_question.is_deleted','=','0')->get();
        // $survei_list_Quest03 = DB::table('tb_survei_question')->leftjoin('tb_survei_header', 'tb_survei_header.id', '=', 'tb_survei_question.header_id')->select('tb_survei_question.*')->where('tb_survei_header.divisi','=',Session::get('id_departemen'))->where('tb_survei_question.type','=','Quest03')->where('tb_survei_question.is_active','=','1')->where('tb_survei_question.is_deleted','=','0')->get();
        // $survei_list_ans = DB::table('vw_survei_answer_ordered_w_ans')->leftjoin('tb_survei_question', 'tb_survei_question.question_id', '=', 'vw_survei_answer_ordered.question_id')->leftjoin('tb_survei_header', 'tb_survei_header.id', '=', 'tb_survei_question.header_id')->select('vw_survei_answer_ordered.*')->where('tb_survei_header.divisi','=',Session::get('id_departemen'))->where('tb_survei_question.is_active','=','1')->where('tb_survei_question.is_deleted','=','0')->where('vw_survei_answer_ordered.is_deleted','=','0')->get();
        
        $survei_list_ans = DB::table('vw_survei_answer_ordered_w_ans')->where('id_respond','=',$id)->get();
        $survei_kategori = DB::table('tb_survei_kategori')->select('*')->get();
        $survei_list_Quest02 = DB::table('tb_survei_respond_detail')
                ->leftjoin('tb_survei_question', 'tb_survei_respond_detail.question_id', '=', 'tb_survei_question.question_id')
                ->select('tb_survei_question.*','tb_survei_respond_detail.answer_id','tb_survei_respond_detail.answer')->where('tb_survei_respond_detail.id_respond','=',$id)
                ->where('tb_survei_question.type','=','Quest02')
                ->where('tb_survei_question.is_deleted','=','0')->get();
        $survei_list_Quest03 = DB::table('tb_survei_respond_detail')
                ->leftjoin('tb_survei_question', 'tb_survei_respond_detail.question_id', '=', 'tb_survei_question.question_id')
                ->select('tb_survei_question.*','tb_survei_respond_detail.answer_id','tb_survei_respond_detail.answer')->where('tb_survei_respond_detail.id_respond','=',$id)
                ->where('tb_survei_question.type','=','Quest03')
                ->where('tb_survei_question.is_deleted','=','0')->get();
        // dd($survei_list_Quest01_noniipp, Session::get('id_departemen'));
        return response()->view('layouts.backend.survey.preview_ans', 
        ['survei_list_header'=>$survei_list_header, 'date_reformat' => $date_reformat,
            'survei_list_ans'=>$survei_list_ans,
            'survei_list_Quest01_noniipp'=>$survei_list_Quest01_noniipp,
            'survei_list_Quest01_iipp'=>$survei_list_Quest01_iipp,
            'survei_list_Quest02'=>$survei_list_Quest02,
            'survei_list_Quest03'=>$survei_list_Quest03,
            'survei_kategori'=>$survei_kategori,
            'izin'=>$izin
        ]);   
    }

    public function result_new($id)
    {
        // dd($id);
        $date_reformat = new DateHelper();
        $list_header = DB::table('vw_survei_respon__header_add')->where('vw_survei_respon__header_add.id_respond','=',$id)->first();
        $list_ans_ikm = DB::table('vw_survei_respond__detail_ikm')->where('vw_survei_respond__detail_ikm.id_respond','=',$id)->get();
        $list_ans_iipp = DB::table('vw_survei_respond__detail_iipp')->where('vw_survei_respond__detail_iipp.id_respond','=',$id)->get();
        // dd($list_header);
        $izin = Izin::select('vw_list_izin.*', 'tb_survei_respond_header.age', 'tb_survei_respond_header.gender', 'tb_survei_respond_header.study')->join('tb_survei_respond_header', 'tb_survei_respond_header.id_trx_izin', '=', 'vw_list_izin.id_izin')->where('tb_survei_respond_header.id_respond','=',$id)->first();
        $survei_list_header = DB::table('tb_survei_header')->select('*')->where('divisi','=',Session::get('id_departemen'))->first();
        $survei_list_Quest01_noniipp = DB::table('vw_list_quest_noniipp_w_ans')->select('*')->where('id_respond','=',$id)->get();
        $survei_list_Quest01_iipp = DB::table('vw_list_quest_iipp_w_ans')->select('*')->where('id_respond','=',$id)->get();
        // $survei_list_Quest02 = DB::table('tb_survei_question')->leftjoin('tb_survei_header', 'tb_survei_header.id', '=', 'tb_survei_question.header_id')->select('tb_survei_question.*')->where('tb_survei_header.divisi','=',Session::get('id_departemen'))->where('tb_survei_question.type','=','Quest02')->where('tb_survei_question.is_active','=','1')->where('tb_survei_question.is_deleted','=','0')->get();
        // $survei_list_Quest03 = DB::table('tb_survei_question')->leftjoin('tb_survei_header', 'tb_survei_header.id', '=', 'tb_survei_question.header_id')->select('tb_survei_question.*')->where('tb_survei_header.divisi','=',Session::get('id_departemen'))->where('tb_survei_question.type','=','Quest03')->where('tb_survei_question.is_active','=','1')->where('tb_survei_question.is_deleted','=','0')->get();
        // $survei_list_ans = DB::table('vw_survei_answer_ordered_w_ans')->leftjoin('tb_survei_question', 'tb_survei_question.question_id', '=', 'vw_survei_answer_ordered.question_id')->leftjoin('tb_survei_header', 'tb_survei_header.id', '=', 'tb_survei_question.header_id')->select('vw_survei_answer_ordered.*')->where('tb_survei_header.divisi','=',Session::get('id_departemen'))->where('tb_survei_question.is_active','=','1')->where('tb_survei_question.is_deleted','=','0')->where('vw_survei_answer_ordered.is_deleted','=','0')->get();
        
        $survei_list_ans = DB::table('vw_survei_answer_ordered_w_ans')->where('id_respond','=',$id)->get();
        $survei_kategori = DB::table('tb_survei_kategori')->select('*')->get();
        $survei_list_Quest02 = DB::table('tb_survei_respond_detail')
                ->leftjoin('tb_survei_question', 'tb_survei_respond_detail.question_id', '=', 'tb_survei_question.question_id')
                ->select('tb_survei_question.*','tb_survei_respond_detail.answer_id','tb_survei_respond_detail.answer')->where('tb_survei_respond_detail.id_respond','=',$id)
                ->where('tb_survei_question.type','=','Quest02')
                ->where('tb_survei_question.is_deleted','=','0')->get();
        $survei_list_Quest03 = DB::table('tb_survei_respond_detail')
                ->leftjoin('tb_survei_question', 'tb_survei_respond_detail.question_id', '=', 'tb_survei_question.question_id')
                ->select('tb_survei_question.*','tb_survei_respond_detail.answer_id','tb_survei_respond_detail.answer')->where('tb_survei_respond_detail.id_respond','=',$id)
                ->where('tb_survei_question.type','=','Quest03')
                ->where('tb_survei_question.is_deleted','=','0')->get();
        // dd($survei_list_Quest01_noniipp, Session::get('id_departemen'));
        return response()->view('layouts.backend.survey.preview_ans_new', 
        ['survei_list_header'=>$survei_list_header, 'date_reformat' => $date_reformat,
            'survei_list_ans'=>$survei_list_ans,
            'survei_list_Quest01_noniipp'=>$survei_list_Quest01_noniipp,
            'survei_list_Quest01_iipp'=>$survei_list_Quest01_iipp,
            'survei_list_Quest02'=>$survei_list_Quest02,
            'survei_list_Quest03'=>$survei_list_Quest03,
            'survei_kategori'=>$survei_kategori,
            'izin'=>$izin,
            'list_header'=>$list_header,
            'list_ans_ikm'=>$list_ans_ikm,
            'list_ans_iipp'=>$list_ans_iipp,
        ]);   
    }
}
