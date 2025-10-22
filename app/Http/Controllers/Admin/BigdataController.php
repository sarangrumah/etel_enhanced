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
use App\Exports\SurveyExport;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Session;
use Config;

class BigdataController extends Controller
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
        $title = "PERMOHONAN PERIZINAN";
        $iframe = "https://e-telekomunikasi.kominfo.go.id/grafana/d/LJOftZKVk/permohonan-perizinan-sla?orgId=1&kiosk";

        return response()->view('admin.bgdt.index', compact('iframe', 'title'));
    }
    public function survey()
    {
        $title = "NILAI DIREKTORAT TELEKOMUNIKASI";
        $iframe = "https://e-telekomunikasi.kominfo.go.id/grafana/d/prsU_QdVz/permohonan-perizinan?orgId=1&kiosk";

        return response()->view('admin.bgdt.index', compact('iframe', 'title'));
    }
    public function surveyJastel()
    {
        $title = "NILAI PELAYANAN PERIZINAN PEMENUHAN JASA TELEKOMUNIKASI";
        $iframe = "https://e-telekomunikasi.kominfo.go.id/grafana/d/prsU_QdVz/survey-ikm-and-iipp-jasa-telekomunikasi?orgId=1&kiosk";

        $quadran = DB::table('vw_graph_quadran')->get();

        return response()->view('admin.bgdt.index', compact('iframe', 'title', 'quadran'));
    }
    public function surveyJartel()
    {
        $title = "NILAI PELAYANAN PERIZINAN PEMENUHAN JARINGAN TELEKOMUNIKASI";
        $iframe = "https://e-telekomunikasi.kominfo.go.id/grafana/d/lWa7rZKVz/survey-ikm-and-iipp-jaringan-telkomunikasi?orgId=1&var-quartal=1&kiosk";

        $quadran = DB::table('vw_graph_quadran')->get();

        return response()->view('admin.bgdt.index', compact('iframe','title', 'quadran'));
    }
    public function surveyTelsus()
    {
        $title = "NILAI PELAYANAN PERIZINAN PEMENUHAN TELEKOMUNIKASI KHUSUS";
        $iframe = "https://e-telekomunikasi.kominfo.go.id/grafana/d/5JJZgGK4z/survey-ikm-and-iipp-telsus?orgId=1&kiosk";

        $quadran = DB::table('vw_graph_quadran')->get();

        return response()->view('admin.bgdt.index', compact('iframe','title', 'quadran'));
    }
    public function surveyPenomoran()
    {
        $title = "NILAI PELAYANAN PERIZINAN PEMENUHAN PENOMORAN";
        $iframe = "https://e-telekomunikasi.kominfo.go.id/grafana/d/Y-N7RMKVz/survey-ikm-and-iipp-penomoran?orgId=1&kiosk";

        $quadran = DB::table('vw_graph_quadran')->get();

        return response()->view('admin.bgdt.index', compact('iframe','title', 'quadran'));
    }
    public function surveyUlo()
    {
        $title = "NILAI PELAYANAN PERIZINAN PEMENUHAN UJI LAIK OPERASI";
        $iframe = "https://e-telekomunikasi.kominfo.go.id/grafana/d/2Dore7F4k/survey-ikm-and-iipp-uji-laik?orgId=1&kiosk";

        $quadran = DB::table('vw_graph_quadran')->get();

        return response()->view('admin.bgdt.index', compact('iframe','title', 'quadran'));
    }

    public function export()
    {
        return Excel::download(new SurveyExport, 'survey.xlsx');
    }
}
