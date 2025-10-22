<div class="card">
	<div class="card-header bg-indigo text-white header-elements-inline">
		<div class="row">
			<div class="col-lg">
				<h6 class="card-title font-weight-semibold py-3">Komitmen Kinerja Layanan</h6>
			</div>
		</div>
	</div>
	<div class="card-body">
		<form action="#">
            <div class="form-group">
                <table class="table table-row-bordered form-table">
                    <thead>
                        <tr class="fw-bolder fs-6 text-center text-gray-800">
				        	<th>Periode</th>
				        	<th>Jumlah Node (unit)</th>
				        	<th>Cakupan Wilayah Layanan (Kabupaten/Kota)</th>
				        	<th>Jumlah  Kabel  Fiber Optik (core) </th>
				        	<th>Kapasitas Bandwidth (Gbps) </th>
				        	<th>Panjang Rute Kabel Fiber Optik (km)</th>
				        	<th>Catatan</th>
				        	<th class="text-end">Aksi</th>
				        </tr>
                    </thead>

                    <tbody id="body-kplt-jartup-terestrial">
                        			        		       
                    </tbody>
                </table>
            </div>
            
            <div class="form-group">
                <button type="button" id="tambah-kplt-jartup-terestrial" class="btn btn-secondary float-right">Tambah Data <i class="icon-stack-plus ml-2"></i></button>
			</div>
			<div class="form-group">
                <button type="submit" class="btn btn-secondary float-right">Simpan Data <i class="icon-stack-plus ml-2"></i></button>
			</div>
		</form>
	</div>
</div>
@once
    @push('scripts')        
    <script src="assets/js/kominfo/persyaratan/form-kplt-jartup-terestrial.js" type="text/javascript"></script>    
    @endpush
@endonce