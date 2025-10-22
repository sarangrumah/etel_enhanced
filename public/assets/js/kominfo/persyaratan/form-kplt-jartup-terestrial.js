
// Class definition
var FormKpltJartupTerestrial = function () {
	// Elements		
	
	
	var periode = [];
	var jumlahNode = [];
	var cakupanWilayah = [];
	var jumlahKabel = [];
	var kapasitasBw = [];
	var panjangRuteKabel = [];
	var notes = [];
		
	
	
	//method
	var initForm = () => {
		
		$("#simpan-kplt-jartup-terestrial").click(function() {	
			periode = [];
			jumlahNode = [];
			cakupanWilayah = [];
			jumlahKabel = [];
			kapasitasBw = [];
			panjangRuteKabel = [];
			notes = [];		
			$("#body-kplt-jartup-terestrial input[name=periode\\[\\]]").each(function() {
			   periode.push($(this).val());
			});
			$("#body-kplt-jartup-terestrial input[name=jumlah-unit\\[\\]]").each(function() {
				jumlahNode.push($(this).val());
			 });
			 $(".cakupanwilayah").each(function() {
				cakupanWilayah.push($(this).val());
			 });
			 $("#body-kplt-jartup-terestrial input[name=jumlah-kabel\\[\\]]").each(function() {
				jumlahKabel.push($(this).val());
			 });
			 $("#body-kplt-jartup-terestrial input[name=kapasistas-bw\\[\\]]").each(function() {
				kapasitasBw.push($(this).val());
			 });
			 $("#body-kplt-jartup-terestrial input[name=panjang-rute-kabel\\[\\]]").each(function() {
				panjangRuteKabel.push($(this).val());
			 });
			 $("#body-kplt-jartup-terestrial input[name=notes\\[\\]]").each(function() {
				notes.push($(this).val());
			 });

			// console.log($("#body-kplt-jartup-terestrial input[name=kapasistas-bw\\[\\]]").map(function(){return $(this).val();}).get());
			 $.ajax({
				type: "post",
				url: "prosesKpltJartupFoTerestrial",
				headers: {"X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")},
				data: {
					perizinan_id: $("#kplt-jartup-terestrial input[name=perizinan_id]").val(),
					periode: periode,
					jumlahNode: jumlahNode,
					cakupanWilayah: cakupanWilayah,
					jumlahKabel: jumlahKabel,
					kapasitasBw: kapasitasBw,
					panjangRuteKabel: panjangRuteKabel,
					notes: notes,
				},
				success: function(data){
					//   alert("Data Save: " + data);
					console.log("Data Save: " , data);
					swal("Berhasil!", "Disimpan", "success");
				},
				error: function(data){
					 alert("Error")
				}
			});
		});
		
		$("#tambah-kplt-jartup-terestrial").click(function() {			
			$("#body-kplt-jartup-terestrial").append(kpltRow);
			initiateCakupanWilayah();
		});
		
		$("#body-kplt-jartup-terestrial").on('click','.remove',function(){
	        $(this).parent().parent().remove();
		});
		var existing = getExisting();
		if(existing.length == 0) {
			$("#body-kplt-jartup-terestrial").append(kpltRow);
		} else {
			existing.forEach(item => {
				console.log(item);
				$("#body-kplt-jartup-terestrial").append(kpltRow);
			});
		}
		initiateCakupanWilayah();
	}
	
	var kpltRow = `<tr>
			            <td><input type="text" name="periode[]" class="form-control" placeholder="xxx"/></td>
			            <td><input type="text" name="jumlah-unit[]" class="form-control" placeholder="xxx"/></td>
			            <td><select id="cakupan-wilayah[]" name="cakupan-wilayah[]" class="form-control form-select cakupanwilayah" data-control="select2"></select></td>
			            <td><input type="text" name="jumlah-kabel[]" class="form-control" placeholder="xxx"/></td>
			            <td><input type="text" name="kapasistas-bw[]" class="form-control" placeholder="xxx"/></td>
			            <td><input type="text" name="panjang-rute-kabel[]" class="form-control" placeholder="xxx"/></td>
						<td><input type="text" name="notes[]" class="form-control" placeholder="xxx"/></td>
			            <td class="items-align-center text-end">
				            <button class="btn btn-icon btn-danger w-30px h-30px remove">
								<!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
								<span class="svg-icon svg-icon-light svg-icon-3">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<path d="M21 13H3C2.4 13 2 12.6 2 12C2 11.4 2.4 11 3 11H21C21.6 11 22 11.4 22 12C22 12.6 21.6 13 21 13Z" fill="black"/>
									</svg>
								</span>
							</button>
							</td>
					</tr>`;
	
	var getExisting = function () {
		var pathArray = window.location.pathname.split('/');
		var id = pathArray[2];
		var existing = [];
		$.ajax({
			type: 'GET',
			url: "/persyaratan/kplt-jartup-terestrial/" + id,
		}).then(function (data) {
			existing = data;
		});	
		return existing;
	}

	var initiateCakupanWilayah = function () {	
		$('.cakupanwilayah').each(function(index, element){
			$(this).select2({placeholder: "Pilih Kota"});

		});
		// $('#body-kplt-jartup-terestrial input[name=cakupan-wilayah\\[\\]]').each(function(index, element) {
		$('.cakupanwilayah').each(function(index, element){
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
		// console.log("okeeee");
	}
	
	return {
		// Public Functions
		init: function () {
			formKplt = document.querySelector("#form-kplt-jartup-terestrial");
			tambahKpltBtn = document.querySelector("#tambah-kplt-jartup-terestrial");			
			simpanKpltBtn = document.querySelector("#simpan-kplt-jartup-terestrial");
			tbodyKplt = $("body-kplt-jartup-terestrial");			
			initForm();	
		}
	};
}();

//On document ready
KTUtil.onDOMContentLoaded(function() {
	FormKpltJartupTerestrial.init();
});