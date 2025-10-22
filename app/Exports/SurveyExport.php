<?php

namespace App\Exports;

use App\Models\Question;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class SurveyExport implements FromView
{
    public function view(): View
    {
        $survey = DB::select("call fx_survey()");
        $question = Question::pluck('question_name', 'id')->toArray();
        $filtered = array();
        for ($i=0; $i < count($survey); $i++) {
            foreach ($survey[$i] as $key => $value) {
                if (str_starts_with($key, 'idq_')) {
                    $filtered[] = $key;
                }
            }
        }
        
        return view('exports.survey', [
            'survey' => $survey,
            'filtered' => $filtered,
            'question' => $question
        ]);
    }
}
