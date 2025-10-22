<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Config;
use App\Models\Admin\User;
use App\Models\Admin\JobPosition;
use Session;
use Redirect;
use Illuminate\Validation\ValidationException;
use DB;

class UsersController extends Controller
{
    //

    public function index(){
        $limit_db = Config::get('app.admin.limit');

        $users = User::select('*')->take($limit_db);
        // $paginate = array();
        if ($users->count() > 0) { //handle paginate error division by zero
            $users = $users->paginate($limit_db);
        }else{
            $users = $users->get();
        }
        $paginate = $users;
        $users = $users->toArray();

        return view('layouts.backend.user.users',['users'=>$users,'paginate'=>$paginate]);
    }

    public function addUsers(){
        $jobposition  = Jobposition::all()->toArray();
        
        return view('layouts.backend.user.users-add',['jobposition'=>$jobposition]);
    }

    public function addUsersPost(Request $request){

        $validator = $this->validate($request, [
                'nama' => 'required|unique:tb_mst_user_bo'
                ,'email' => 'required|unique:tb_mst_user_bo'
                ,'username' => 'required|unique:tb_mst_user_bo'
                ,'password' => 'required'
                ,'password_confirmation' => 'required|same:password'
                ]);

        if (!$validator){
            return Redirect::back()->withInput()->withErrors($validator);
        }else{
            $data = $request->all();

            DB::beginTransaction();

            try {
                $user = User::create([
                    'nama'=>$data['nama'],
                    'email'=>$data['email'],
                    'username'=>$data['username'],
                    'id_mst_jobposition'=>$data['jobposition'],
                    'is_active'=>1,
                    'created_by'=>Session::get('id_user'),
                    'password'=>bcrypt($data['password'])
                ]);

                DB::commit();
                Session::flash("flash_notification", [
                    "level"=>"success",
                    "message"=>"Berhasil Menyimpan Data"
                ]);

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
    }

    public function editUsers($id){
        $user = User::find($id)->toArray();
        $jobposition  = Jobposition::all()->toArray();
        return view('layouts.backend.user.users-edit',['user'=>$user,'jobposition'=>$jobposition]);
    }

    public function editUsersPost($id , Request $request){
        $validator = $this->validate($request, [
                'nama' => 'required'
                ,'email' => 'required|unique:tb_mst_user_bo,id'
                ,'username' => 'required|unique:tb_mst_user_bo,id'
                ,'password_confirmation' => 'same:password'
        ]);

        DB::beginTransaction();

        try {
            $post = $request->all();
            $user = User::find($id);
            // $user->update($request->all());
            $user->nama = $post['nama'];
            $user->email = $post['email'];
            $user->id_mst_jobposition = $post['jobposition'];
            $user->username = $post['username'];
            if ($post['password'] != '') {
                $user->password = bcrypt($post['password']);
            }
            $user->save();
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
