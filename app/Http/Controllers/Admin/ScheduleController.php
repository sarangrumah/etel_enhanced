<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Agenda;
use DB;
use Config;
use Session;
use App\Helpers\DateHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\ULOSchedule;

class ScheduleController extends Controller
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
    public function show()
    {
        // $events = DB::table('tb_mst_uloschedule')->get();
        // $eventsjs = json( $events);
        return response()->view('layouts.backend.evaluator.ulo-schedule');
    }

    public function manageschedule()
    {
        $date_reformat = new DateHelper();
        $limit_db = Config::get('app.admin.limit');
        $events = ULOSchedule::where('is_active','=','1')->get();

        // dd($events);
        // $eventsjs = json( $events);
        // if ($events->count() > 0) { //handle paginate error division by zero
        //     $events = $events->paginate($limit_db);
        // } else {
        //     $events = $events;
        // }
        // $paginate = $events;
        $events = $events->toArray();
        // dd($events);
        return response()->view('layouts.backend.evaluator.ulo-schedule-mgt',['date_reformat' => $date_reformat,'events'=>$events]);
    }

    public function getschedule(Request $request)
    {
        // Fetch events from the database
        // $events = DB::table('vw_uloschedule')->get(); // Adjust this as needed (you might want to format data)
        
        // return response()->json($events);

        $month = $request->query('month');
        $year = $request->query('year');

        // Fetch events from the database
        // Adjust the query to filter results based on month and year
        $events = DB::table('vw_uloschedule')
            ->whereMonth('start', $month) // Replace 'date_column' with your actual date column name
            ->whereYear('start', $year)   // Again, replace 'date_column' as needed
            ->get();
        // dd($events);

        return response()->json($events);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'nullable|date|after:start',
            'locate' => 'required|string|max:255',
        ]);

        Agenda::create($request->all());

        return redirect()->back()->with('message', 'Agenda berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'nullable|date|after:start',
            'locate' => 'required|string|max:255',
        ]);

        $event = Agenda::find($id);
        if ($event) {
            $event->update($request->all());
            return redirect()->back()->with('message', 'Agenda berhasil diubah.');
        }

        return redirect()->back()->with('message', 'Agenda tidak ditemukan.');
    }

    public function destroy($id)
    {
        $event = Agenda::find($id);
        if ($event) {
            // Set is_active to 0 instead of deleting the record
            $event->is_active = 0;
            $event->save();

            return redirect()->back()->with('message', 'Agenda berhasil dinonaktifkan.');
        }

        return redirect()->back()->with('message', 'Agenda tidak ditemukan.');
    }
}
