<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\User;


use App\Helpers\IzinHelper;
use App\Helpers\CommonHelper;
use App\Models\Admin\MasterHoliday;

use Illuminate\Validation\ValidationException;

use Session;
use Redirect;
use Auth;
use Config;
use DB;
use Str;

class MasterHolidayController extends Controller
{
    
      function __construct()
      {
        $this->middleware('admin');
      }

      public function index(){
          $limit_db = Config::get('app.admin.limit');
          
          $masterholiday = MasterHoliday::select('*')->where(['is_active' => 1 ])->take($limit_db);
          $masterholiday = $masterholiday->paginate($limit_db);
          $paginate = $masterholiday;
          $masterholiday = $masterholiday->toArray();
          
          return view('layouts.backend.masterholiday.dashboard',['masterholiday'=>$masterholiday,'paginate'=>$paginate]);
          
      }


    
      public function edit($id)
      {


        $dataholiday = MasterHoliday::where('id',$id)->firstOrFail();
        return view('layouts.backend.masterholiday.edit',compact('dataholiday'));


      }


        public function create()
      {


      
        return view('layouts.backend.masterholiday.create');


      }


        public function store(Request $request)
      {
        // dd($request);
        $input['off_day'] = $request->input("off_day"); 
        $input['is_active'] = (bool)$request->input("is_active"); 
        $input['kategori'] = $request->input("id_kategori"); 
        $input['desc'] = $request->input("desc"); 
        $input['desc'] = $request->input("desc"); 
        $input['created_by'] = Session::get('nama'); 


          MasterHoliday::create($input);
          $message="Data Hari Libur Berhasil Disimpan";

          return redirect('/admin/masterholiday')->with('message', $message);
      }

      public function update(Request $request,$id)
      {

        $input = MasterHoliday::where('id',$id)->first();

        
        $input['off_day'] = $request->input("off_day"); 
        $input['is_active'] = (bool)$request->input("is_active"); 
        $input['kategori'] = $request->input("id_kategori"); 
        $input['desc'] = $request->input("desc"); 
        $input['updated_by'] = Session::get('nama'); 


          $input->update();
          $message="Data Hari Libur Berhasil Diupdate";



      
          // $limit_db = Config::get('app.admin.limit');
          
          // $masterholiday = MasterHoliday::select('*')->take($limit_db);
          // $masterholiday = $masterholiday->paginate($limit_db);
          // $paginate = $masterholiday;
          // $masterholiday = $masterholiday->toArray();
          
          // return view('layouts.backend.masterholiday.dashboard',['masterholiday'=>$masterholiday,'message'=>$message,'paginate'=>$paginate]);
          return redirect('/admin/masterholiday')->with('message', $message);



      }

      public function delete($id)
      {

        $input = MasterHoliday::where('id',$id)->first();

        
        $input['is_active'] = 0 ;


          $input->update();
          $message="Data Hari Libur Berhasil Hapus";



      
          // $limit_db = Config::get('app.admin.limit');
          
          // $masterholiday = MasterHoliday::select('*')->take($limit_db);
          // $masterholiday = $masterholiday->paginate($limit_db);
          // $paginate = $masterholiday;
          // $masterholiday = $masterholiday->toArray();
          
          // return view('layouts.backend.masterholiday.dashboard',['masterholiday'=>$masterholiday,'message'=>$message,'paginate'=>$paginate]);
          return redirect('/admin/masterholiday')->with('message', $message);

      }


        public function destroy($id)
      {
          
          $delete =  MasterHoliday::destroy($id);
      }



    

}
