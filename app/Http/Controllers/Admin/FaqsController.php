<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Config;
use App\Models\Admin\Faqs;
use App\Models\Admin\JobPosition;
use Session;
use Redirect;
use Illuminate\Validation\ValidationException;
use DB;

class FaqsController extends Controller
{
    //

    public function index(){
        $limit_db = Config::get('app.admin.limit');

        $faqs = Faqs::select('*')->take($limit_db);
        // $paginate = array();
        if ($faqs->count() > 0) { //handle paginate error division by zero
            $faqs = $faqs->paginate($limit_db);
        }else{
            $faqs = $faqs->get();
        }
        $paginate = $faqs;
        $faqs = $faqs->toArray();
        // dd($faqs);   

        return view('layouts.backend.faqs.faqs',['faqs'=>$faqs,'paginate'=>$paginate]);
    }

    public function addFaqs(){
        $faq_type  = DB::table('tb_mst_faq_type')->select('id','short_desc','desc')->where('is_active','=','1')->get();
        $faq_category  = DB::table('tb_mst_faq_category')->select('id','short_desc','desc')->where('is_active','=','1')->get();
        // dd($faq_type,$faq_category);
        return view('layouts.backend.faqs.faqs-add',['faq_type'=>$faq_type,'faq_category'=>$faq_category]);
    }

    public function addFaqsPost(Request $request){

        $data = $request->all();

        // dd($data);

            DB::beginTransaction();
            if (isset($data['faq_document'])){
                $pathdoc = '';
                $FAQDoc = $data['faq_document'];
                $filename = "FAQtemplate" . time() . '.' . $FAQDoc->extension();
                $pathdoc = $FAQDoc->storeAs('public/lampiran/', $filename);
                $pathdoc = str_replace('public/', 'storage/', $pathdoc);            
            } else {
                $pathdoc = '';
            }
            
            try {
                $faq = Faqs::create([
                    'type'=>$data['faq_types'],
                    'category'=>$data['faq_category'],
                    'question'=>$data['faq_question'],
                    'answer'=>$data['faq_answer'],
                    'download_link'=>$pathdoc,
                    'is_active'=>$data['faq_status'],
                    'created_by'=>Session::get('id_user'),
                    'created_date'=>date('Y-m-d H:i:s'),
                    'updated_by'=>Session::get('id_user'),
                    'updated_date'=>date('Y-m-d H:i:s')
                ]);

                DB::commit();
                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Berhasil Menyimpan Data"
                ]);

            } catch (\Exception $e) {
                DB::rollback();
                // Session::flash("flash_notification", [
                //     "level"=>"error",
                //     "message"=>"Gagal Menyimpan Data"
                // ]);

                throw ValidationException::withMessages(['message' => 'Gagal Menyimpan Data']);
            }
            return Redirect::back();       
    }

    public function editFaqs($id){
        $faqs = Faqs::find($id)->toArray();
        $faq_type  = DB::table('tb_mst_faq_type')->select('id','short_desc','desc')->where('is_active','=','1')->get();
        $faq_category  = DB::table('tb_mst_faq_category')->select('id','short_desc','desc')->where('is_active','=','1')->get();
        // dd($faqs);
        return view('layouts.backend.faqs.faqs-edit',['faqs'=>$faqs,'faq_type'=>$faq_type,'faq_category'=>$faq_category]);
    }

    public function editFaqsPost($id , Request $request){

        DB::beginTransaction();

        try {
            $post = $request->all();

            
            if (isset($post['download_link'])){
                $pathdoc = '';
                $FAQDoc = $post['download_link'];
                $filename = "FAQtemplate" . time() . '.' . $FAQDoc->extension();
                $pathdoc = $FAQDoc->storeAs('public/lampiran', $filename);
                $pathdoc = str_replace('public/', 'storage/', $pathdoc);            
            } else {
                $pathdoc = '';
            }

            // dd($post);
            $faqs = Faqs::find($id);
            // // $user->update($request->all());
            $faqs->type = $post['faq_types'];
            $faqs->category = $post['faq_category'];
            $faqs->is_active = $post['faq_status'];
            $faqs->question = $post['faq_question'];
            $faqs->answer = $post['faq_answer'];
            $faqs->download_link = $pathdoc;
            // if ($post['password'] != '') {
            //     $user->password = bcrypt($post['password']);
            // }
            $faqs->save();
            DB::commit();
            Session::flash("flash_notification", [ 
                "level"=>"success",
                "message"=>"Berhasil Menyimpan Data"
            ]);
            session()->flash('message', 'Berhasil Menyimpan Data');

        } catch (\Exception $e) {
            DB::rollback();
            Session::flash("flash_notification", [
                "level"=>"error",
                "message"=>"Gagal Menyimpan Data"
            ]);

            throw ValidationException::withMessages(['message' => 'Gagal']);
        }

        return Redirect::back();
    }

    public function deleteUsers($id , Request $request){
        if ($id == Auth::guard('admin')->user()->id) {
            return Redirect::back();
        }

        DB::beginTransaction();

        try {
            $user = User::find($id);
            $user->delete();

            DB::commit();
            Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Data berhasil dihapus"
            ]);
        }catch (\Exception $e) {
            DB::rollback();
            Session::flash("flash_notification", [
                "level"=>"error",
                "message"=>"Data Gagal Dihapus"
            ]);

            throw ValidationException::withMessages(['message' => 'Gagal']);
        }
        return Redirect::back();
    }
}
