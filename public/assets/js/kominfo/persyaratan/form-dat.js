
// Class definition
var FormDat = function () {
	// Elements		
	var formDat;
	var tambahDatBtn;
	var simpanDatBtn;
	var tbodyDat;
	var lokasi = [];
	var jenis = [];
	var merk = [];
	var buatan = [];
	var type = [];
	var serial_number = [];
	var nomor_sertifikat = [];
	var foto_sertifikat = [];
	var foto_perangkat = [];
	var foto_sn = [];
	var foto_bukti_kepemilikan = [];
	var number = 1;
	
	
	//method
	var initForm = () => {
		
		$("#simpan-dat").click(function() {	
			// event.preventDefault();
			$.ajax({
				url: 'prosesDataAlatTeknis',
				type: 'post',
				dataType: 'json',
				// data: $('form#form_data_alat_teknis').serialize(),
				data: new FormData(document.getElementById("form_data_alat_teknis")),
				processData: false,
				contentType: false,
				success: function(data) {
					swal("Berhasil!", "Disimpan", "success");
				}
			});
			swal("Berhasil!", "Disimpan", "success");
		});
		
		$("#tambah-dat").click(function() {
			number++;
			$("#body-dat").append(addNewRow(number));
			$("#dat-delete-"+(number-1)).attr("disabled", "disabled");
			console.log($("#dat-delete-"+(number-1)));
		});
		
		$("#body-dat").on('click','.remove',function(){
	        $(this).parent().parent().remove();
	        number --;
	        $("#dat-delete-"+(number)).removeAttr("disabled");
	    });
		
	}
	
	var addNewRow = (number) => {
		var datRow = `
			<tr>
	            <td>`+ number +`</td>
	            <td>
					Alamat Lokasi Perangkat<em style="color: red">*</em>: <textarea name="lokasi[]" class="form-control form-control-sm" id="" cols="30" rows="4"></textarea>
					Jenis<em style="color: red">*</em>: <input type="text" name="jenis[]" class="form-control form-control-sm" placeholder=""/>
				</td>
				<td>
					Merk<em style="color: red">*</em>: <input type="text" name="merk[]" class="form-control form-control-sm" placeholder=""/>
					Buatan<em style="color: red">*</em>: <input type="text" name="buatan[]" class="form-control form-control-sm" placeholder=""/>
					Type<em style="color: red">*</em>: <input type="text" name="type[]" class="form-control form-control-sm" placeholder=""/>
				</td>
				<td>
					Serial Number<em style="color: red">*</em>: <input type="text" name="serial_number[]" class="form-control form-control-sm" placeholder=""/>
					No Sertifikat<em style="color: red">*</em>: <input type="text" name="nomor_sertifikat[]" class="form-control form-control-sm" placeholder=""/>
					File Sertifikat<em style="color: red">*</em>: <input type="file" name="file_sertifikat[]" class="form-control form-control-sm" accept="application/pdf"/>
					
				</td>
				<td>
					Foto Perangkat<em style="color: red">*</em>: <input type="file" name="foto_perangkat[]" class="form-control form-control-sm" accept="application/pdf"/>
					Foto Serial Number<em style="color: red">*</em>: <input type="file" name="foto_sn[]" class="form-control form-control-sm" accept="application/pdf">
					Bukti Kepemilikan Perangkat<em style="color: red">*</em>: <input type="file" name="foto_bukti_kepemilikan[]" class="form-control form-control-sm" accept="application/pdf"/>
				</td>			            
	            <td class="items-align-center">
	            <button id="dat-delete-`+ (number) + `" class="btn btn-icon btn-danger remove w-30px h-30px">
					<!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
					<span class="svg-icon svg-icon-light svg-icon-3">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<path d="M21 13H3C2.4 13 2 12.6 2 12C2 11.4 2.4 11 3 11H21C21.6 11 22 11.4 22 12C22 12.6 21.6 13 21 13Z" fill="black"/>
						</svg>
					</span>
				</button>
				</td>
	        </tr>	
		`;
		return datRow;
	}
	
	
	return {
		// Public Functions
		init: function () {
			formDat = document.querySelector("#form-dat");
			tambahDatBtn = document.querySelector("#tambah-dat");			
			simpanDatBtn = document.querySelector("#simpan-dat");
			tbodyDat = $("body-dat");			
			initForm();	
		}
	};
}();

//On document ready
KTUtil.onDOMContentLoaded(function() {
    FormDat.init();
});