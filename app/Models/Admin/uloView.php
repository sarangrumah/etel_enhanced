<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Config;
use Session;

class uloView extends Model
{
    use HasFactory;

    // protected $table = 'tb_trx_ulo';
	protected $table = 'vw_list_ulo';
    const CREATED_AT = 'created_date';
	const UPDATED_AT = 'updated_date';

    public function view_ulo($id_departemen, $id_izin,$id_jabatan,$is_evaluator = 0,$id_user_session = 0 ){
		$limit_db = Config::get('app.admin.limit');

		if ($id_izin != '') {
			$ulo = uloView::select('vw_list_ulo.id as id_ulo','vw_list_ulo.*')
			
			// ->join('tb_oss_mst_kodestatusizin','tb_trx_ulo.status_ulo','=','tb_oss_mst_kodestatusizin.oss_kode')
			// ->join('vw_list_ulo','tb_trx_ulo.id_izin','=','vw_list_ulo.id_izin')
			->where('vw_list_ulo.id_izin','=',$id_izin)
			->where('vw_list_ulo.is_active','=','1')
			->with('KodeIzin');
			$ulo = $ulo->first();
			// dd($ulo);
		}else{
			
			$ulo = uloView::select('*')
			// ->join('vw_list_ulo','tb_trx_ulo.id_izin','=','vw_list_ulo.id_izin')
			// ->join('tb_oss_mst_kodestatusizin','tb_trx_ulo.status_ulo','=','tb_oss_mst_kodestatusizin.oss_kode')
			->where('is_active','=','1');
			// dd($ulo);
			if($is_evaluator == 1){
				$ulo = $ulo->join('tb_trx_disposisi_evaluator_ulo as d','d.id_izin','=','vw_list_ulo.id_izin');
				$ulo = $ulo->where('d.id_disposisi_user','=', $id_user_session);
			};
			$ulo = $ulo->with('KodeIzin')->orderBy('updated_date','desc');
			if ($id_jabatan == 2) { //koordinator
				$ulo = $ulo->where(function($q) {
					$q->where('status_ulo','=',20)->orWhere('status_ulo','=',903)->orderBy('updated_date','desc');
				});
			}else if($id_jabatan == 4){ //evaluator
				$ulo = $ulo->where('status_ulo','=',901)->orderBy('updated_date','desc');
			}else if($id_jabatan == 3){ //subkoordinator
				$ulo = $ulo->where('status_ulo','=',902)->orderBy('updated_date','desc');
			}else if($id_jabatan == 1){ //direktur
				$ulo = $ulo->where('status_ulo','=',904)->orderBy('updated_date','desc');
			}
		}
		// dd($id_jabatan);
		return $ulo;
    }

	public function KodeIzin()
    {
        return $this->belongsTo(KodeIzin::class, 'status_ulo', 'oss_kode');
    }
}
// tb_oss_mst_kodestatusizin