<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Helpdesk;
use App\Models\vw_Helpdesk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;

class HelpdeskController extends Controller
{
    public function index()
    {
        // dd(Auth::user()->email);
        $hld = Helpdesk::all();
        $hld_count = $hld->count();
        $vwhld_open = vw_Helpdesk::where('status','Open')->get();
        $vwhld_open_count = $vwhld_open->count();
        $vwhld_wia = vw_Helpdesk::where('status','WIA')->get();
        $vwhld_wia_count = $vwhld_wia->count();
        $vwhld_done = vw_Helpdesk::where('status','Closed')->get();
        $vwhld_done_count = $vwhld_done->count();
        $vwhld_cancelled = vw_Helpdesk::where('status','Cancelled')->get();
        $vwhld_cancelled_count = $vwhld_cancelled->count();
        
        return view('layouts.backend.helpdesk.index', compact(['hld','vwhld_open', 'vwhld_wia', 'vwhld_done',
        'vwhld_cancelled', 'hld_count', 'vwhld_open_count', 'vwhld_wia_count', 'vwhld_done_count',
        'vwhld_cancelled_count']));
    }

    public function create()
    {
        return view('layouts.frontend.helpdesk');
    }

    public function save(Request $request)
    {
        // dd($request);
        // $path1 = '';
        if($file1 = $request->file('lampiran_layanan'))
        {
        $filename1 = "LampiranLayanan-".time().'.'.$file1->extension();
        $path1 = $file1->storeAs('public/helpdesk', $filename1);
        $name1 = $file1->getClientOriginalName();
        $path1 = str_replace('public/', 'storage/', $path1);
        // dd($filename1);
        $filepath = "storage/helpdesk/".$file1->getClientOriginalName();
        // $request->merge(['lampiran_layanan' => $filepath, 'lampiran_layanan' => $filepath ]);
        }else{
            $path1 = '';
            $filename1 = '';
            $request->merge(['lampiran_layanan' => '' ]);
        }
        $request->merge([
            'status' => 'Open',
            'filename' => $filename1,
            'lampiran_layanan_path' => $path1,
            'last_updated_date' => date('Y-m-d H:i:s'),
            'created_date' => date('Y-m-d H:i:s'),
            'updated_date' => date('Y-m-d H:i:s')
        ]);
        // dd($request->all());
        Helpdesk::create($request->except(['_token']));
        return redirect('/admin/daftarlayanan')->with('Berhasil', 'Bantuan Layanan telah berhasil kami terima');
    }

    public function update($id)
    {

        $help = Helpdesk::where('id','=', $id)->first();
        // dd($help);
        return view('layouts.backend.helpdesk.update', compact(['help']));
    }

    public function savelayanan($id, Request $request)
    {
        // dd($request->all());
        $help = Helpdesk::find($id);
        $request->merge([
            'status' => $request->status,
            'pesan_layanan' => $request->pesan_layanan . '<br /> Feedback: <br />' . $request->pesan_layanan_pre,
            'last_updated_date' => date('Y-m-d H:i:s'),
            'updated_date' => date('Y-m-d H:i:s')
        ]);
        $help->update($request->except(['_token','pesan_layanan_pre']));
        // dd($help);
        return redirect('/admin/daftarlayanan')->with('Berhasil', 'Bantuan Layanan telah berhasil diperbaharui');
    }

    public function closed($id)
    {
    // dd($request->all());
    $help = Helpdesk::where('id',$id)->update([
    'status' => 'Closed',
    'closed_date' => date('Y-m-d H:i:s'),
    'last_updated_date' => date('Y-m-d H:i:s'),
    'updated_date' => date('Y-m-d H:i:s')
    ]);
    // $help->update([
    // 'status' => 'Closed',
    // 'closed_date' => date('Y-m-d H:i:s'),
    // 'last_updated_date' => date('Y-m-d H:i:s'),
    // 'updated_date' => date('Y-m-d H:i:s')
    // ]);

    // $help->update($request->except(['_token']));
    // dd($help);
    $hld = Helpdesk::all();
    return view('layouts.backend.helpdesk.index', compact(['hld']));
    }

    public function helpdeskexport(){
        
    }
}