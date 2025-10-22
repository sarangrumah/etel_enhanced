
// Class definition
var form_jasa_cc = function () {
	// Elements		
	var number = 1;
	
	
	//method
	var initForm = () => {
		
		$("#simpan-jasa-cc").click(function() {	
			// event.preventDefault();
			$.ajax({
				url: 'proses-jasa-cc',
				type: 'post',
				dataType: 'json',
				// data: $('form#form_data_alat_teknis').serialize(),
                headers: {"X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")},
				data: new FormData(document.getElementById("form_jasa_cc")),
				processData: false,
				contentType: false,
				success: function(data) {
					swal("Berhasil!", "Disimpan", "success");
				}
			});
            // $("#toggle-radio-konv").removeAttr("data-bs-toggle");
            // $("#toggle-radio-trunking").removeAttr("data-bs-toggle");
            // $("#toggle-radio-data").removeAttr("data-bs-toggle");
            // $("#toggle-satelit").removeAttr("data-bs-toggle");
            swal("Berhasil!", "Disimpan", "success");
		});

        $("#tambah-jasa-cc").click(function() {			
			$("#body-jasa-cc").append(foRow);
            initiateKabKota();
		});
		
		$("#body-jasa-cc").on('click','.remove',function(){
	        $(this).parent().parent().remove();
	    });
        initiateKabKota();
		
	}
	
		var foRow = `
                <tr>
                    <td><input type="text" name="tahun[]" class="form-control" placeholder=""/></td>
                    <td><select name="pusat_pelayanan_kota[]" class="form-control form-select pusat_pelayanan_kota" data-control="select2"></select></td>		            
                    <td><input type="text" name="pusat_pelayanan_jumlah[]" class="form-control" placeholder=""/></td>
                    <td><input type="text" name="kapasitas_layanan[]" class="form-control" placeholder=""/></td>
                    <td class="items-align-center text-end">
                    <button id="jasa-cc-delete-`+ (number) + `" class="btn btn-icon btn-danger remove w-30px h-30px">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                        <span class="svg-icon svg-icon-light svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M21 13H3C2.4 13 2 12.6 2 12C2 11.4 2.4 11 3 11H21C21.6 11 22 11.4 22 12C22 12.6 21.6 13 21 13Z" fill="black"/>
                            </svg>
                        </span>
                    </button>
                    </td>
                </tr>`;

            var initiateKabKota = function () {	
                $('.pusat_pelayanan_kota').each(function(index, element){
                    $(this).select2({placeholder: "Pilih Kota"});
        
                });
                // $('#body-kplt-jartup-terestrial input[name=cakupan-wilayah\\[\\]]').each(function(index, element) {
                $('.pusat_pelayanan_kota').each(function(index, element){
                    $(this).select2({
                        placeholder: "Pilih Kota",
                        ajax: {
                            url:  function() {
                                return "/master/kota-provinsi-v2"
                            },
                            dataType: 'json',
                            type: "post",
                            headers: {"X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")},
                            data: function (params) {
                                return {
                                    term: params.term
                                };
                            },
                            processResults: function (data) {
                                return {
                                    // results: $.map(data, function (item) {
                                    // 	var children = [];
                                    // 	for(var k in item){
                                    // 		var childItem = item[k.prov_name];
                                    // 		childItem.text = item[k.prov_name].city_name;
                                    // 		children.push(childItem);
                                    // 	}								
                                    // 	return {
                                    // 		text: item.prov_name,
                                    // 		children: children
                                    // 	}
                                    // })
                                    results: data
                                };
                            }
                        }
                    });
                });
            }
	
	
        return {
            // Public Functions
            init: function () {
                initForm();	
            }
        };
}();


//On document ready
KTUtil.onDOMContentLoaded(function() {
    form_jasa_cc.init();
});