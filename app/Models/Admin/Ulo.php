<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Config;
use Session;
use DB;

class Ulo extends Model
{
    use HasFactory;

    protected $table = 'tb_trx_ulo';
	// protected $table = 'vw_list_ulo';
    const CREATED_AT = 'created_date';
	const UPDATED_AT = 'updated_date';

    public function view_ulo($id_departemen, $id_izin,$id_jabatan,$is_evaluator = 0,$id_user_session = 0 ){
		$limit_db = Config::get('app.admin.limit');
		// dd($id_izin);
		if ($id_izin != 'EMPTY') {
			$ulo = Ulo::select('vw_list_ulo.id as id_ulo','vw_list_ulo.*')
			
			// ->join('tb_oss_mst_kodestatusizin','tb_trx_ulo.status_ulo','=','tb_oss_mst_kodestatusizin.oss_kode')
			->join('vw_list_ulo',function($join){
				$join->on('tb_trx_ulo.id_izin','=','vw_list_ulo.id_izin');
				$join->on('tb_trx_ulo.id','=','vw_list_ulo.id');
			})
			->where('vw_list_ulo.id','=',$id_izin)
			// ->where('vw_list_ulo.is_active','=','1')
			->with('KodeIzin');
			$ulo = $ulo->first();
			// dd($ulo);
		}else{
			
			$ulo = Ulo::select('vw_list_ulo.*')
			->join('vw_list_ulo',function($join){
				$join->on('tb_trx_ulo.id_izin','=','vw_list_ulo.id_izin');
				$join->on('tb_trx_ulo.id','=','vw_list_ulo.id');
			});
			// ->join('tb_oss_mst_kodestatusizin','tb_trx_ulo.status_ulo','=','tb_oss_mst_kodestatusizin.oss_kode')
			// ->where('vw_list_ulo.is_active','1');
			// dd($id_jabatan);
			if($is_evaluator == 1){
				$ulo = $ulo->join('tb_trx_disposisi_evaluator_ulo as d',function($join){
					$join->on('d.id_izin','=','vw_list_ulo.id_izin');
					$join->on('d.id_ulo','=','vw_list_ulo.id');
				});
				$ulo = $ulo->where('d.id_disposisi_user','=', $id_user_session);
			};
			$ulo = $ulo->with('KodeIzin')->orderBy('updated_date','desc');
			if ($id_jabatan == 2) { //koordinator
				$ulo = $ulo->whereIn('vw_list_ulo.status_ulo',[20,903,901,51])->orderBy('updated_date','desc');
			}else if($id_jabatan == 4){ //evaluator
				$ulo = $ulo->where('vw_list_ulo.status_ulo','=',901)->orderBy('updated_date','desc');
			}else if($id_jabatan == 3){ //subkoordinator
				$ulo = $ulo->whereIn('vw_list_ulo.status_ulo',[902,9021,9023])->orderBy('updated_date','desc');
			}else if($id_jabatan == 1){ //direktur
				$ulo = $ulo->whereIn('vw_list_ulo.status_ulo',[904,50])
							->where('vw_list_ulo.status_sk_ulo','=',null)
							->orderBy('updated_date','desc');
			}
			// $ulo->orWhere(function ($query) {
			// 	$query->where('vw_list_ulo.is_active', '1')
			// 		->Where('vw_list_ulo.status_survey', 0);
			// });
			// $ulo->Where('vw_list_ulo.status_survey', 0);
			// dd($ulo);
			// });
		}
		// dd($ulo);
		return $ulo;
    }

	public function KodeIzin()
    {
        return $this->belongsTo(KodeIzin::class, 'status_ulo', 'oss_kode');
    }
}
// tb_oss_mst_kodestatusizin