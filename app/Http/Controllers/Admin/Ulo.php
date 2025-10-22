<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Config;
use Session;

class Ulo extends Model
{
    use HasFactory;

    protected $table = 'tb_trx_ulo';
    const CREATED_AT = 'created_date';
	const UPDATED_AT = 'updated_date';

    public function view_ulo($id_departemen, $id_izin,$id_jabatan,$is_evaluator = 0,$id_user_session = 0 ){
		$limit_db = Config::get('app.admin.limit');
		// dd($id_izin);
		if ($id_izin != 'EMPTY') {
			$ulo = Ulo::select('tb_trx_ulo.id as id_ulo','tb_trx_ulo.*','vw_list_izin.*')
			->join('vw_list_izin','tb_trx_ulo.id_izin','=','vw_list_izin.id_izin')
			->where('tb_trx_ulo.id_izin','=',$id_izin)
			// ->where('tb_trx_ulo.is_active','=','1')
			->with('KodeIzin');
			$ulo = $ulo->first();
			// dd($ulo);
		}else{
			
			$ulo = Ulo::select('*')
			->join('vw_list_izin as d',function($join){
				$join->on('d.id_izin','=','tb_trx_ulo.id_izin');
				$join->on('d.uloid','=','tb_trx_ulo.id');
			})
			->where('tb_trx_ulo.is_active','=','1');
			// dd($ulo);
			if($is_evaluator == 1){
				$ulo = $ulo->join('tb_trx_disposisi_evaluator_ulo as d',
				function($join){
					$join->on('d.id_izin','=','tb_trx_ulo.id_izin');
					$join->on('d.id_ulo','=','tb_trx_ulo.id');
				});
				$ulo = $ulo->where('d.id_disposisi_user','=', $id_user_session);
			};
			// dd($id_jabatan);
			$ulo = $ulo->with('KodeIzin')->orderBy('updated_date','desc');
			if ($id_jabatan == 2) { //koordinator
				$ulo = $ulo->where(function($q) {
					$q->whereIn('status_ulo',[20,23,601,603,903,901])->orderBy('updated_date','desc');
				});
			}else if($id_jabatan == 4){ //evaluator
				$ulo = $ulo->where('status_ulo','=',901)->orderBy('updated_date','desc');
			}else if($id_jabatan == 3){ //subkoordinator
				$ulo = $ulo->where('status_ulo','=',['902','9021','9023'])->orderBy('updated_date','desc');
			}else if($id_jabatan == 1){ //direktur
				$ulo = $ulo->whereIn('status_ulo',['904','50'])
					->where('status_sk_ulo','=','NULL')
					->orderBy('updated_date','desc');
			}
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