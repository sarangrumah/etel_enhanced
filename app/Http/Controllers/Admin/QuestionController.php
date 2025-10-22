<?php

namespace App\Http\Controllers\Admin;

use Redirect;
use Session;
use App\Models\Question;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $question = Question::all();
        
        return response()->view('admin.survey.mgmt-question', compact('question'));
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
    public function store(Request $request)
    {
        $this->_validate($request);
        $requestData = $request->all();
        $requestData['created_by'] = Session::get('id_user');

        Question::create($requestData);

        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Question::where('id', $id)->delete();

        return Redirect::back()->with('success', 'deleted');
    }

    private function _validate($request)
    {
        $request->validate([
            'question_name'           => 'required',
            'question_desc'           => 'required',
            'id_tb_mst_question_type' => 'required',
            // 'question_text_1'         => 'required',
            'expected_result'         => 'required',
            'min_result'              => 'required',
            'max_result'              => 'required',
        ]);
    }
}
