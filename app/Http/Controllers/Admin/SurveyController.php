<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Question;
use App\Models\QuestionMap;
use App\Models\Responder;
use App\Models\Admin\UserSurvey;
use App\Models\Admin\Izin;
use App\Helpers\DateHelper;
use App\Helpers\IzinHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class SurveyController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $survey = Survey::orderBy('id', 'ASC')->get();

        return response()->view('admin.survey.mgmt-surveycampaign', compact('survey'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(request $request)
    {
        $this->_validate($request);
        $requestData = $request->all();

        Survey::create($requestData);

        return redirect('/admin/svmgmt');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $survey = Survey::where('id', $id)->first();

        $question = Question::select('tb_mst_question.*', 'tb_map_question.id as checked')->leftJoin('tb_map_question', function ($join) use ($id){
            $join->on('tb_mst_question.id', '=', 'tb_map_question.id_tb_mst_question');
            $join->on('tb_map_question.id_tb_mst_survey', '=', DB::RAW($id));
        })->orderBy(DB::RAW("-tb_map_question.id"), "DESC")->get();

        return response()->view('admin.survey.mgmt-mapsurveyquestion', compact('id', 'survey', 'question'));
    }

    public function addQuestion($id, request $request)
    {
        $requestData = $request->all();

        try {
            QuestionMap::where('id_tb_mst_survey', $id)->update([
                'order' => null,
                'is_active' => 0
            ]);
            foreach ($requestData['question_id'] as $key => $value) {
                // $qm = new QuestionMap();
                // $qm->id_tb_mst_survey = $id;
                // $qm->id_tb_mst_question = $value;
                // $qm->order = $key;
                // $qm->is_active = 1;
                // $qm->save();

                $flight = QuestionMap::updateOrCreate(
                    ['id_tb_mst_survey' => $id, 'id_tb_mst_question' => $value],
                    ['id_tb_mst_survey' => $id, 'id_tb_mst_question' => $value, 'order' => $key, 'is_active' => 1]
                );
            }

            return redirect('/admin/svmgmt')->with('success', 'Success');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/admin/svmgmt')->with('success', 'Gagal');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Survey::where('id', $id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->all();

        Survey::find($id)->update($requestData);

        return redirect('/admin/svmgmt');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Survey $survey)
    {
        //
    }

    public function list()
    {
        $date_reformat = new DateHelper();
        $limit_db = Config::get('app.admin.limit');

        $izin = Responder::select('tb_mst_responder.*', 'tb_mst_user_survey.is_active as status')->take($limit_db);
        $izin->leftJoin('tb_mst_user_survey', 'tb_mst_responder.id_tb_mst_user_survey', '=', 'tb_mst_user_survey.id');

        $izin = $izin->distinct('tb_mst_responder.id_izin');

        if ($izin->count() > 0) { //handle paginate error division by zero
            $izin = $izin->paginate($limit_db);
        } else {
            $izin = $izin->get();
        }

        $paginate = $izin;
        $izin = $izin->toArray();

        $date_reformat = new DateHelper();

        return view('layouts.backend.survey', ['date_reformat' => $date_reformat, 'izin' => $izin, 'paginate' => $paginate]);
    }

    public function getResponder($id)
    {
        return Responder::where('id_responder', $id)->first();
    }

    public function updateResponder(Request $request, $id)
    {
        $requestData = $request->all();

        $responder = Responder::find($id)->first();

        UserSurvey::find($responder->id_tb_mst_user_survey)->update($requestData);

        return redirect('/admin/responder/list');
    }

    private function _validate($request){

        $request->validate([
            'survey_name'           => 'required|max:150',
            'survey_desc'           => 'required|max:150',
            'period_start'          => 'required|date',
            'period_end'            => 'required|date|after:period_start',
            'expected_result'       => 'required',
            'is_related_izin'       => 'required',
            'is_survey_initiator'   => 'required',
            'is_active'             => 'required',
        ]);
    }

    public function preview($survey_id){
    {

        $question = Survey::select('tb_map_question.id as id_map', 'tb_mst_survey.survey_name', 'tb_mst_survey.survey_desc', 'tb_mst_survey.category', 'tb_mst_survey.category as cat', 'tb_mst_question.*', 'tb_mst_rq.*', 'unsur_name')
        ->leftJoin('tb_map_question', 'tb_mst_survey.id', '=', 'tb_map_question.id_tb_mst_survey')
        ->leftJoin('tb_mst_question', 'tb_map_question.id_tb_mst_question', '=', 'tb_mst_question.id')
        ->leftJoin('tb_mst_rq', function ($join) {
            $join->on('tb_map_question.id', '=', 'tb_mst_rq.id_tb_map_sq')
                ->where('tb_mst_rq.id_izin', '=', Session::get('id_izin'));
        })
        ->leftJoin('tb_mst_unsur', 'tb_mst_question.unsur', '=', 'tb_mst_unsur.id')
        ->where('tb_mst_survey.id', '=', $survey_id)
        // ->where('tb_mst_survey.is_active', '=', 1)
        ->where('tb_map_question.is_active', '=', 1)
        // ->where(function($query){
        //     $query->where('id_izin', '=', Session::get('id_izin'))
        //     ->orWhere('id_izin', '=', null);
        // })
        ->orderBy('tb_map_question.order', 'ASC')
        ->get();

        return view('layouts.backend.form', ['question' => $question]);
    }
    }
}
