<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Survey;
use App\Models\Responder;
use App\Models\ResponderQuestion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SurveyController extends Controller
{
    public function index($id_izin, request $request)
    {
        $user = DB::table('tb_mst_user_survey')->where('id_izin', '=', $id_izin)->where('code', '=', $request->query('code'))->first();
        if($user){
            session(['id_izin' => $id_izin]);
            session(['jenis_perizinan' => $user->jenis_perizinan]);
            return view('layouts.survey.index');
        }
        return abort(404);
    }

    public function responder(){
        if(Session::get('id_izin')){
            $responder = Responder::where('id_izin', Session::get('id_izin'))->where('is_active', '1')->first();
            if($responder){
                $survey = DB::table('tb_mst_survey')->where('is_active', '=', 1)->where('category', '=', 1)->where('jenis_perizinan', '=', Session::get('jenis_perizinan'))->first();
                return redirect('survey/form/'. $survey->id);
            }
            $survey = DB::table('tb_mst_survey')->where('is_active', '=', 1)->where('category', '=', 1)->where('jenis_perizinan', '=', Session::get('jenis_perizinan'))->first();
            return view('layouts.survey.responder', ['id_izin' => Session::get('id_izin'), 'id_survey' => $survey->id ?? 0]);
        }
        return abort(404);
    }

    public function responderSubmit(request $request)
    {
        $requestData = $request->all();
        if ($file = $request->file('file_uploaded')) {
            $filename = "SURVEYOR-" . time() . '.' . $file->extension();
            $path = $file->storeAs('public/file_surveyor', $filename);
            $name = $file->getClientOriginalName();
            $path = str_replace('public/', 'storage/', $path);
            $requestData['file_uploaded'] = $path;
        }
        // dd($requestData);
        // $requestData['id_tb_mst_izinlayanan'] = json_encode($requestData['id_tb_mst_izinlayanan']);
        $requestData['id_izin'] = Session::get('id_izin');
        $requestData['is_active'] = 1;

        $user_survey = DB::table('tb_mst_user_survey')->where('id_izin', '=', Session::get('id_izin'))->first();
        $requestData['id_tb_mst_user_survey'] = $user_survey->id;

        Responder::create($requestData);

        // $survey = DB::table('tb_mst_survey')->where('is_active', '=', 1)->where('category', '=', 1)->where('jenis_perizinan', '=', Session::get('jenis_perizinan'))->first();

        return redirect(url('/survey/form', 1));
    }

    public function form($survey_cat)
    {
        $survey = DB::table('tb_mst_survey')->where('is_active', '=', 1)->where('category', '!=', $survey_cat)->where('jenis_perizinan', '=', Session::get('jenis_perizinan'))->first();

        $question = Survey::select('tb_map_question.id as id_map', 'tb_mst_survey.survey_name', 'tb_mst_survey.survey_desc', 'tb_mst_survey.category as cat', 'tb_mst_question.*', 'tb_mst_rq.*', 'unsur_name')
                    ->leftJoin('tb_map_question', 'tb_mst_survey.id', '=', 'tb_map_question.id_tb_mst_survey')
                    ->leftJoin('tb_mst_question', 'tb_map_question.id_tb_mst_question', '=', 'tb_mst_question.id')
                    ->leftJoin('tb_mst_rq', function ($join) {
                        $join->on('tb_map_question.id', '=', 'tb_mst_rq.id_tb_map_sq')
                            ->where('tb_mst_rq.id_izin', '=', Session::get('id_izin'));
                    })
                    ->leftJoin('tb_mst_unsur', 'tb_mst_question.unsur', '=', 'tb_mst_unsur.id')
                    ->where('tb_mst_survey.category', '=', $survey_cat)
                    ->where('tb_mst_survey.is_active', '=', 1)
                    ->where('tb_map_question.is_active', '=', 1)
                    // ->where(function($query){
                    //     $query->where('id_izin', '=', Session::get('id_izin'))
                    //     ->orWhere('id_izin', '=', null);
                    // })
                    ->orderBy('tb_map_question.order', 'ASC')
                    ->get();
        // var_dump($question);die;
        return view('layouts.survey.form', ['question' => $question, 'id_survey' => $survey->category ?? 0]);
    }

    public function formSubmit($id, request $request)
    {
        $requestData = $request->all();
        try {
            $responder = DB::table('tb_mst_responder')->where('id_izin', Session::get('id_izin'))->where('is_active', '1')->first();
            if (isset($requestData['q'])) {
                foreach ($requestData['q'] as $key => $value) {
                    $rq = ResponderQuestion::firstOrCreate(
                        ['id_izin' => Session::get('id_izin'), 'id_tb_map_sq' => $key]
                    );
                    $rq->id_tb_map_sq = $key;
                    $rq->id_izin = Session::get('id_izin');
                    $rq->id_tb_mst_responder = $responder->id_responder;
                    $rq->survey_answer = isset($requestData['pertanyaan']) ? $requestData['pertanyaan'][$key] : null;
                    $rq->survey_result = $value;
                    $rq->is_saved = 1;
                    $rq->is_active = 1;
                    $rq->save();
                }
            }

            $survey = DB::table('tb_mst_survey')->where('is_active', '=', 1)->where('category', '=', $id+1)->where('jenis_perizinan', '=', Session::get('jenis_perizinan'))->first();
            if ($survey) {
                return redirect(url('/survey/form', $survey->category));
            }

            DB::table('tb_mst_responder')->where('id_izin', Session::get('id_izin'))->update(array(
                'is_active' => 0
            ));

            return redirect(url('/survey/greet', 0));
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
