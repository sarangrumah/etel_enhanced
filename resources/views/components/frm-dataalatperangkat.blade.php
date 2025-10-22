<div>
<script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>
<script src="global_assets/js/demo_pages/form_layouts.js"></script>
<script src="global_assets/js/plugins/forms/validation/validate.min.js"></script>

<script src="global_assets/js/demo_pages/form_validation.js"></script>
<div class="card">
	<div class="card-header bg-indigo text-white header-elements-inline">
		<div class="row">
			<div class="col-lg">
				<h6 class="card-title font-weight-semibold py-3">Formulir Data Teknis Alat/Perangkat</h6>
			</div>
		</div>
	</div>
	<div class="card-body">
		<form action="#">
            <div class="alert alert-info alert-styled-left alert-dismissible">
		    	<span class="font-weight-semibold">Seluruh Dokumen dalam format PDF dan maksimal 5 MB.</span>
		    </div>
            <div class="form-group">
                <table class="table table-row-bordered form-table">
                    <thead>
                        <tr class="fw-bolder fs-6 text-center text-gray-800">
                            <th>No</th>
                            <th colspan="5">Data</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>    	
                        <tbody id="body-dat">
                            <tr>
                                <td>1</td>
                                <td>
                                    Alamat Lokasi Perangkat<span class="text-danger">*</span>: <textarea name="lokasi[]" class="form-control form-control-sm" id="" cols="30" rows="4"></textarea>
                                    Jenis<span class="text-danger">*</span>: <input type="text" name="jenis[]" class="form-control form-control-sm" placeholder=""/>
                                </td>
                                <td>
                                    Merk<span class="text-danger">*</span>: <input type="text" name="merk[]" class="form-control form-control-sm" placeholder=""/>
                                    Buatan<span class="text-danger">*</span>: <input type="text" name="buatan[]" class="form-control form-control-sm" placeholder=""/>
                                    Type<span class="text-danger">*</span>: <input type="text" name="type[]" class="form-control form-control-sm" placeholder=""/>
                                </td>
                                <td>
                                    Serial Number<span class="text-danger">*</span>: <input type="text" name="serial_number[]" class="form-control form-control-sm" placeholder=""/>
                                    No Sertifikat<span class="text-danger">*</span>: <input type="text" name="nomor_sertifikat[]" class="form-control form-control-sm" placeholder=""/>
                                    File Sertifikat<span class="text-danger">*</span>: <input type="file" name="foto_sertifikat[]" class="form-control h-auto foto_sertifikat" accept="application/pdf"/>                                  
                                </td>
                                <td>
                                    Foto Perangkat<span class="text-danger">*</span>: <input type="file" name="foto_perangkat[]" class="form-control h-auto" accept="application/pdf"/>
                                    Foto Serial Number<span class="text-danger">*</span>: <input type="file" name="foto_sn[]" class="form-control h-auto form-control-sm" accept="application/pdf">
                                    Bukti Kepemilikan Perangkat<span class="text-danger">*</span>: <input type="file" name="foto_bukti_kepemilikan[]" class="form-control h-auto form-control-sm" accept="application/pdf"/>
                                </td>			            
                                <td class="items-align-center">
                                    <button type="submit" class="btn btn-secondary"><i class="icon-reset"></i></button>
                                </td>
                            </tr>				        		       
                        </tbody>
                </table>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-secondary">Tambah Data <i class="icon-stack-plus ml-2"></i></button>
			</div>
		</form>
	</div>
</div>
</div>